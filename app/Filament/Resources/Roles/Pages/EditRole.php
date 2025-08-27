<?php

namespace App\Filament\Resources\Roles\Pages;

use App\Filament\Resources\Roles\RoleResource;
use BezhanSalleh\FilamentShield\Resources\RoleResource\Pages\EditRole as BaseEditRole;
use Filament\Actions\Action;
use Filament\Actions\DeleteAction;

class EditRole extends BaseEditRole
{
    protected static string $resource = RoleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('reset')
                ->hiddenLabel()
                ->icon('heroicon-o-arrow-path')
                ->color('gray')
                ->tooltip('Reset')
                ->action(fn () => $this->fillForm()),
            DeleteAction::make(),
        ];
    }

    protected function getRedirectUrl(): string
    {
        return static::getResource()::getUrl('index');
    }
}
