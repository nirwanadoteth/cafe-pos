<?php

namespace App\Filament\Pages\Auth;

use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EditProfile extends \Filament\Auth\Pages\EditProfile
{
    public function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                $this->getNameFormComponent(),
                $this->getEmailFormComponent(),
                $this->getPasswordFormComponent(),
                $this->getPasswordConfirmationFormComponent(),
                $this->getRoleFormComponent(),
            ]);
    }

    protected function getRoleFormComponent(): Component
    {
        return TextEntry::make('roles')
            ->label(__('pages/auth/edit-profile.form.role.label'))
            ->inlineLabel()
            ->state(fn ($record) => Str::headline($record->roles->pluck('name')->join(', ')));
    }
}
