<?php

namespace App\Filament\Pages;

use App\Models\Product;
use Filament\Facades\Filament;
use Filament\Pages\SimplePage;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\MaxWidth;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextColumn\TextColumnSize;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;

class Welcome extends SimplePage implements HasTable
{
    use InteractsWithTable;

    protected static string $view = 'filament.pages.welcome';

    public function hasTopbar(): bool
    {
        return false;
    }

    public function getMaxWidth(): MaxWidth | string | null
    {
        return MaxWidth::ScreenLarge;
    }

    public static function shouldRegisterNavigation(): bool
    {
        return false;
    }

    public function getTitle(): string | Htmlable
    {
        return 'Welcome';
    }

    public function getHeading(): string | Htmlable
    {
        return '';
    }

    public function table(Table $table): Table
    {
        return $table
            ->query(Product::query()->where('is_visible', true))
            ->headerActions([
                Action::make('login')
                    ->url(Filament::getLoginUrl()),
            ])
            ->heading('List of our categories and products')
            ->columns([
                Split::make([
                    SpatieMediaLibraryImageColumn::make('product-image')
                        ->defaultImageUrl(url('https://placehold.co/100x100.jpeg?text=No+Image'))
                        ->square()
                        ->size(100)
                        ->collection('product-images')
                        ->grow(false)
                        ->limit(1),

                    Stack::make([
                        TextColumn::make('name')
                            ->size(TextColumnSize::Large)
                            ->weight(FontWeight::Bold),

                        TextColumn::make('price')
                            ->money('IDR'),

                        TextColumn::make('description')
                            ->markdown()
                            ->wrap(),
                    ])->space(),
                ]),
            ])
            ->groups([
                Group::make('category.name')
                    ->titlePrefixedWithLabel(false)
                    ->collapsible()
                    ->getDescriptionFromRecordUsing(function (Product $record) {
                        return $record->category?->description;
                    }),
            ])
            ->defaultGroup('category.name')
            ->groupingSettingsHidden()
            ->contentGrid([
                'md' => 1,
                'xl' => 2,
            ])
            ->paginated(false);
    }
}
