<?php

namespace App\Models\Reading;

use App\Models\Category;
use Illuminate\Database\Eloquent\Model;

class Book extends Model
{

    public $fillable = [
        'title',
        'description',
        'author',
        'pages',
        'book_path',
        'cover_path',
        'category_id'
        
    ];

    public function category(){ 

        return $this->belongsTo(Category::class); 
    }


}
