<?php

use App\Filament\Pages\Welcome;
use Illuminate\Support\Facades\Route;

Route::get('/', Welcome::class)->name('filament.admin.welcome');
