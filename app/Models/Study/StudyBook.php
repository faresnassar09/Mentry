<?php

namespace App\Models\Study;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyBook extends Model
{

    public $fillable = ['user_id','path','title','last_read'];

    use HasFactory;


    public function user(){


        return $this->belongsTo(User::class);
    }
}
