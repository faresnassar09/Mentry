<?php

namespace App\Models\Study;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyNote extends Model
{
    use HasFactory; 

    public $fillable = ['user_id','study_book_id','title','body'];  

    public function studyBook(){


        return $this->belongsTo(StudyBook::class);
    }
}
