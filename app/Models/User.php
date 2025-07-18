<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use App\Models\Study\StudyBook;
use App\Models\Study\StudyMaterial;
use App\Models\Study\StudyNote;
use App\Models\Study\StudySchedule;
use App\Models\Writing\WritingBook;
use App\Models\Writing\WritingNote;
use App\Models\Writing\WritingSnippet;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];


public function studyBooks(){


return $this->hasMany(StudyBook::class);

}

public function studyMaterials(){


    return $this->hasMany(StudyMaterial::class);
    
    }

    public function studyNotes() {
        
        return $this->hasMany(StudyNote::class);
    }

    public function studySchedules() {

        return $this->hasMany(StudySchedule::class);
        
    }

    public function userBooks(){


        return $this->hasMany(WritingBook::class);
    }

    public function userNotes(){


        return $this->hasMany(WritingNote::class);
    }  
    
    public function userSnippets(){


        return $this->hasMany(WritingSnippet::class);
    }

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
