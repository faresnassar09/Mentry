<?php

namespace App\Models;

use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable implements FilamentUser
{

    public function canAccessPanel(Panel $panel): bool
    {
        return str_ends_with($this->email, 'fares.ahmed.nassar0@gmail.com') && $this->hasVerifiedEmail();
    }


    public $fillable = [
        'name',
        'email',
        'password',

    ];
    
}
