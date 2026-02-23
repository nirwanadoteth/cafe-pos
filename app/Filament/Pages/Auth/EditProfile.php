<?php

namespace App\Filament\Pages\Auth;

use Filament\Auth\Pages\EditProfile as BaseEditProfile;
use Filament\Infolists\Components\TextEntry;
use Filament\Schemas\Components\Component;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class EditProfile extends BaseEditProfile
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
            // SQL: SELECT roles.name FROM roles
            //      INNER JOIN model_has_roles ON model_has_roles.role_id = roles.id
            //      WHERE model_has_roles.model_id = :user_id AND model_has_roles.model_type = 'App\Models\User'
            ->state(fn ($record) => Str::headline($record->roles->pluck('name')->join(', ')));
    }
}
