<?php

namespace App\Filament\Resources\Roles;

use App\Filament\Resources\Roles\Pages\CreateRole;
use App\Filament\Resources\Roles\Pages\EditRole;
use BezhanSalleh\FilamentShield\Resources\RoleResource as BaseRoleResource;
use BezhanSalleh\FilamentShield\Resources\RoleResource\Pages\ListRoles;
use BezhanSalleh\FilamentShield\Resources\RoleResource\Pages\ViewRole;

class RoleResource extends BaseRoleResource
{
    public static function getPages(): array
    {
        return [
            'index' => ListRoles::route('/'),
            'create' => CreateRole::route('/create'),
            'view' => ViewRole::route('/{record}'),
            'edit' => EditRole::route('/{record}/edit'),
        ];
    }
}
