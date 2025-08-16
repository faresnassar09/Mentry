<?php

namespace App\Models\Study;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudySchedule extends Model
{
    use HasFactory;

    public $fillable = ['user_id','ends_at'];

    public function items()
{
    return $this->hasMany(StudyScheduleItem::class);
}


public $casts = [
    'ends_at' => 'datetime',
];
}
