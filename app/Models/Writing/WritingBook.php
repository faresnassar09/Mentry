<?php

namespace App\Models\Writing;

use Illuminate\Database\Eloquent\Model;

class WritingBook extends Model
{

    public $fillable = ['user_id','title','path','updated_at'];

    
}
