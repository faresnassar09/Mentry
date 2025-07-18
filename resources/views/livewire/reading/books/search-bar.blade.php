<div class="relative">
    <form action="" method="GET" class="mb-6">
        <input
            type="text"
            name="search"
            wire:model.live="searchRequest"
            placeholder="ابحث عن كتاب..."
            class="w-full md:w-1/2 px-4 py-2 rounded-lg border border-gray-300 focus:outline-none focus:ring-2 focus:ring-blue-500"
        />
    </form>
  
    @if ($searchResult)
        <div class="bg-white border border-gray-300 rounded-lg shadow-md p-4 w-full md:w-1/2">
            @foreach ($searchResult as $book)
               <a href="{{route('reading.books.read',$book->id)}}">   <div class="py-2 border-b last:border-none">
                 {{ $book->title }}
                </div></a> 
            @endforeach
        </div>

    @endif
</div>
