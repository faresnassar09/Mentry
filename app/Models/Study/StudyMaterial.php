<?php

namespace App\Models\Study;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyMaterial extends Model
{
    use HasFactory;
    
    public $fillable = ['user_id','title','path','type','last_read'];

    public function user(){


        return $this->belongsTo(User::class);
    }
}  
