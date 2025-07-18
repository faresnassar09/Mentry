<?php

namespace App\Http\Controllers\writing;

use App\Http\Controllers\Controller;
use App\Models\Writing\WritingBook;
use App\Service\FileServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Log;

class BookController extends Controller
{

    public function __construct(public FileServices $fileServices) {}

    public function index()
    {

        $title = 'كتبي';
        $books = Auth::user()->userBooks()->get();

        return view('users.writing.books.index',compact('title','books'));
    }


    public function create()
    {

        $title = 'كتاب جديد';
        return view('users.writing.books.create', compact('title'));
    }

    public function store(Request $request)
    {

        $file =  $this->fileServices->storeGeneratedFile(

            'users_books',
            $request->title,
            $request->content,

        );


        if (!$file['status'] || !$file['path'] ) {

            Log::channel('user')->error('error occurred while uploading file to the system',[

                'user_id' => Auth::id(),
                'title' => $request->title,

            ]);



            return back()->with('failed', 'حدثت مشكلة اثناء حفظ الكتاب');  
        }

        
        $status = $this->insertInDatabase($request->title,$file['path']);


        if (!$status) {
            
            return back()->with('failed','حدث مشكلة اثناء حفظ الكتاب');
        }


        return back()->with('success', 'تم اضافة الكتاب بنجاح');


    }


    public function edit(WritingBook $book)
    {

        Gate::authorize('edit',$book);

        $title = 'اكمل الكتابة';

        $content = $this->fileServices->getFileContent($book->path);

        
        return view('users.writing.books.edit',compact('title','book','content'));

    }


    public function update(WritingBook $book ,Request $request)
    {

        Gate::authorize('update',$book);

    $this->updateInDatabase($book,$request->title);



    $statusOfUpdatingFileContent = 
    $this->fileServices->
    updateExistFileContent($book->path,$request->content,$book->id);



    if(!$statusOfUpdatingFileContent){
        return back()->with('faild',' حدثت مشكلة اثناء تحديث الكتاب');

    }

    $this->updateLastWriting($book);
    
 return back()->with('success',' تم تحديث بيانات الكتاب' );

    }

    public function download(WritingBook $book){


 Gate::authorize('download',$book);

 return $this->fileServices->generatePdfFile($book->path,$book->title);
          
    }


    public function delete(WritingBook $book){

        Gate::authorize('delete',$book);

        $deleteFromDatabaseStatus = $this->deleteFromDatabase($book);

        if(!$deleteFromDatabaseStatus){

            return back()->with('faild','حدث خطاء اثناء حذف الكتاب');

        }

    $deleteFromStoarge = $this->fileServices->deleteGeneralFile($book);        

    return back()->with('success','تم حذف الكتاب');

    }

    public function insertInDatabase($title, $path)
    {


        try {
            $book = Auth::user()->userBooks()->create([

                'title' => $title,
                'path' => $path,
            ]);

            Log::channel('user')->info('new user book uploaded successfully', [

                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'book_title' => $book->title,

            ]);

            return true;
        } catch (\Exception $e) {

            Log::channel('user')->error('error occurred while saving user book in database', [

                'user_id' => Auth::id(),
                'book_title' => $title,
                'exception_details' => $e->getMessage(),
            ]);

            return false;
        }
    }

    public function updateInDatabase($book,$title){

        try {

            if($book->title != $title){

        $book->update(['title' => $title]);

        Log::channel('user')->info('user book changed successfully',[

            'user_id' => $book->user_id,
            'book_id' => $book->id,
            'old_title' => $book->title,
            'new_title' => $title,

        ]);

        return true;
            }


        } catch (\Exception $e) {


            Log::channel('user')->error('error occurred while updating the titile',[


                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'exception_details' => $e->getMessage(),
            ]);

            return false;
        }


    }

    public function updateLastWriting($book){


        try {
            
         $book->update(['updated_at' => now()]);

         Log::channel('user')->info('updated');

        } catch (\Exception $e) {

            Log::channel('user')->error('error occurred while updating last writing',[

                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'exception_details' => $e->getMessage(),

            ]);


        }


    }

    public function deleteFromDatabase($book){

        try {
            $book->delete();
             
            Log::channel('user')->info('user book deleted successfully',[

                'user_id' => $book->user_id,
                'book_id' => $book->id,
                'book_title' => $book->title,
            ]);

    return true;
        } catch (\Exception $e) {

            Log::channel('user')->error('erroe occurred while deleting user book',[

                'user_id' => $book->user_id,
                'book_title' => $book->titile,
                'exception_error' => $e->getMessage(),

            ]);

            return false;
        }

         
    }
}
   