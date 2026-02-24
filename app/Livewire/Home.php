<?php

namespace App\Livewire;

use App\Models\Product;
use Filament\Actions\Action;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Facades\Filament;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Support\Enums\FontWeight;
use Filament\Support\Enums\TextSize;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Concerns\InteractsWithTable;
use Filament\Tables\Contracts\HasTable;
use Filament\Tables\Grouping\Group;
use Filament\Tables\Table;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class Home extends Component implements HasActions, HasForms, HasTable
{
    use InteractsWithActions;
    use InteractsWithForms;
    use InteractsWithTable;

    public function table(Table $table): Table
    {
        return $table
            // SQL: SELECT products.*, categories.* FROM products
            //      LEFT JOIN categories ON categories.id = products.category_id
            //      WHERE products.is_visible = 1
            ->query(Product::query()->where('is_visible', true)->with('category'))
            ->heading(__('pages/welcome.table_heading'))
            ->headerActions([
                static::loginAction(),
            ])
            ->columns([
                Split::make([
                    SpatieMediaLibraryImageColumn::make('product-image')
                        ->defaultImageUrl(url('https://placehold.co/100x100.webp?text=No+Image'))
                        ->square()
                        ->imageSize(100)
                        ->collection('product-images')
                        ->conversion('webp')
                        ->grow(false)
                        ->checkFileExistence(false)
                        ->extraImgAttributes(fn (Product $record) => [
                            'alt' => 'Product image of ' . $record->name,
                            'loading' => 'lazy',
                        ]),

                    Stack::make([
                        TextColumn::make('name')
                            ->size(TextSize::Large)
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
                    ->getDescriptionFromRecordUsing(
                        callback: fn (Product $record) => $record->category?->description
                    ),
            ])
            ->defaultGroup('category.name')
            ->groupingSettingsHidden()
            ->contentGrid([
                'sm' => 1,
                'xl' => 2,
            ])
            ->paginated([12, 24, 48]);
    }

    public static function loginAction(): Action
    {
        return Action::make('login')
            ->button()
            ->label(__('actions.login'))
            ->url(Filament::getLoginUrl());
    }

    public function render(): View
    {
        return view('livewire.home');
    }
}
