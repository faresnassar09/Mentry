<?php

namespace App\Models\Writing;

use Illuminate\Database\Eloquent\Model;

class WritingNote extends Model
{

    public $fillable = ['user_id','writing_book_id','content'];

    public function writingBook() {


        return $this->belongsTo(WritingBook::class);
    }

}
