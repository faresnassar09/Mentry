<?php

namespace App\Models\Study;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudyScheduleItem extends Model
{
    use HasFactory;

    public $fillable = ['study_schedual_id','task','ends_at'];





    public $casts = [
        'ends_at' => 'datetime',
    ];

}
