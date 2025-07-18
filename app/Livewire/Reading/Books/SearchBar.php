<?php

namespace App\Livewire\Reading\Books;
use App\Models\Reading\Book;
use Livewire\Component;

class SearchBar extends Component
{

    public $searchRequest = null;
    public $searchResult = null;
public function mount()
{

}




    public function getSearchResultProperty()
    {
        
if($this->searchRequest){
        return  Book::where('title','like','%'.$this->searchRequest.'%')
      ->limit(10)
      ->get();
    }

}
    public function render()
    {  


         $this->searchResult = $this->getSearchResultProperty($this->searchRequest);

        return view('livewire.reading.books.search-bar');
    }
}
