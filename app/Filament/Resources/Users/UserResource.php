<?php

namespace App\Filament\Resources\Users;

use App\Filament\Resources\Users\Pages\CreateUser;
use App\Filament\Resources\Users\Pages\EditUser;
use App\Filament\Resources\Users\Pages\ListUsers;
use App\Models\User;
use BackedEnum;
use BezhanSalleh\FilamentShield\Contracts\HasShieldPermissions;
use Carbon\Carbon;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Password;
use Spatie\Permission\Models\Role;

class UserResource extends Resource implements HasShieldPermissions
{
    protected static ?string $model = User::class;

    protected static ?string $recordTitleAttribute = 'name';

    protected static string | BackedEnum | null $navigationIcon = 'heroicon-o-users';

    protected static ?int $navigationSort = 3;

    /** @return string[] */
    public static function getPermissionPrefixes(): array
    {
        return [
            'view',
            'view_any',
            'create',
            'update',
            'delete',
            'delete_any',
        ];
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('name')
                    ->label(__('resources/user.name'))
                    ->required()
                    ->maxLength(255)
                    ->autofocus(fn (string $operation): bool => $operation === 'create')
                    ->inlineLabel(),

                TextInput::make('email')
                    ->label(__('resources/user.email'))
                    ->email()
                    ->required()
                    ->maxLength(255)
                    ->unique(ignoreRecord: true)
                    ->inlineLabel(),

                TextInput::make('password')
                    ->label(fn (?User $record) => static::getPasswordLabel($record))
                    ->required(fn (string $operation): bool => $operation === 'create')
                    ->password()
                    ->revealable()
                    ->rule(Password::default())
                    ->autocomplete('new-password')
                    ->dehydrated(fn ($state): bool => filled($state))
                    ->dehydrateStateUsing(fn ($state): string => Hash::make($state))
                    ->live(debounce: 500)
                    ->same('passwordConfirmation')
                    ->inlineLabel(),

                TextInput::make('passwordConfirmation')
                    ->label(fn (?User $record) => static::getPasswordConfirmationLabel($record))
                    ->password()
                    ->revealable()
                    ->required(fn (Get $get): bool => filled($get('password')))
                    ->visible(fn (Get $get): bool => filled($get('password')))
                    ->dehydrated(false)
                    ->inlineLabel(),

                Toggle::make('email_verified_at')
                    ->label(__('resources/user.verified'))
                    ->onColor('success')
                    ->offColor('danger')
                    ->default(null)
                    ->dehydrateStateUsing(fn ($state, $record) => static::dehydrateEmailVerificationState($state, $record))
                    ->afterStateHydrated(fn ($component, $state) => $component->state($state !== null))
                    ->inlineLabel(),

                Select::make('roles')
                    ->multiple()
                    ->maxItems(1)
                    ->relationship('roles', 'name')
                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => Str::headline($record->name))
                    ->preload()
                    ->label(__('resources/user.roles'))
                    ->inlineLabel(),
            ]);
    }

    protected static function getPasswordLabel(?User $record): string
    {
        return $record === null ? __('resources/user.password') : __('resources/user.new_password');
    }

    protected static function getPasswordConfirmationLabel(?User $record): string
    {
        return $record === null ? __('resources/user.password_confirmation') : __('resources/user.new_password_confirmation');
    }

    protected static function dehydrateEmailVerificationState(mixed $state, mixed $record): ?Carbon
    {
        if ($record !== null && (bool) $state === ($record->email_verified_at !== null)) {
            return $record->email_verified_at;
        }

        return $state === true ? now() : null;
    }

    protected static function getEmailVerificationState(User $record): string
    {
        return $record->email_verified_at !== null ? __('resources/user.verified') : __('resources/user.unverified');
    }

    protected static function getEmailVerificationColor(User $record): string
    {
        return $record->email_verified_at !== null ? 'success' : 'danger';
    }

    /**
     * @param  Builder<User>  $query
     * @param  array<string, mixed>  $data
     * @return Builder<User>
     */
    protected static function applyVerificationFilter(Builder $query, array $data): Builder
    {
        return $query
            ->when(
                ($data['value'] ?? null) === 'verified',
                fn (Builder $query): Builder => $query->whereNotNull('email_verified_at')
            )
            ->when(
                ($data['value'] ?? null) === 'unverified',
                fn (Builder $query): Builder => $query->whereNull('email_verified_at')
            );
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label(__('resources/user.name'))
                    ->searchable(isIndividual: true)
                    ->sortable(),
                TextColumn::make('email')
                    ->label(__('resources/user.email'))
                    ->searchable(isIndividual: true, isGlobal: false)
                    ->sortable(),
                TextColumn::make('email_verified_at')
                    ->label(__('resources/user.verified'))
                    ->badge()
                    ->getStateUsing(fn (User $record) => static::getEmailVerificationState($record))
                    ->color(color: fn (User $record) => static::getEmailVerificationColor($record))
                    ->sortable()
                    ->toggleable(),
                TextColumn::make('roles')
                    ->label(__('resources/user.roles'))
                    ->searchable(isGlobal: false)
                    ->toggleable()
                    ->getStateUsing(fn ($record) => $record->roles->pluck('name')->join(', '))
                    ->formatStateUsing(fn ($state): string => Str::headline($state)),
                TextColumn::make('created_at')
                    ->label(__('resources/user.created_at'))
                    ->date(timezone: 'Asia/Jakarta')
                    ->dateTimeTooltip(timezone: 'Asia/Jakarta')
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                SelectFilter::make('verified')
                    ->label(__('resources/user.verified'))
                    ->options([
                        'verified' => __('resources/user.verified'),
                        'unverified' => __('resources/user.unverified'),
                    ])
                    ->query(
                        callback: fn (Builder $query, array $data): Builder => static::applyVerificationFilter($query, $data)
                    ),

                SelectFilter::make('role')
                    ->relationship('roles', 'name')
                    ->label(__('resources/user.roles'))
                    ->getOptionLabelFromRecordUsing(fn (Role $record): string => Str::headline($record->name)),
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => ListUsers::route('/'),
            'create' => CreateUser::route('/create'),
            'edit' => EditUser::route('/{record}/edit'),
        ];
    }

    public static function getGloballySearchableAttributes(): array
    {
        return ['name', 'email'];
    }

    public static function getModelLabel(): string
    {
        return __('resources/user.single');
    }

    public static function getPluralModelLabel(): string
    {
        return __('resources/user.plural');
    }

    public static function getNavigationGroup(): ?string
    {
        return __('resources/user.nav.group');
    }

    public static function getNavigationLabel(): string
    {
        return __('resources/user.plural');
    }

    /** @return Builder<User> */
    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->with('roles');
    }
}
