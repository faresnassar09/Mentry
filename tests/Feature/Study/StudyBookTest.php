<?php

namespace Tests\Feature\Study;

use App\Models\Study\StudyBook;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class StudyBookTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_authentcated_user_can_create_study_book(): void
    {

        Storage::fake('public');
        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $this->postJson('api/v1/user/study/books/', [

            'title' => 'test title',
            'book' => UploadedFile::fake()->create('book.pdf', 1, 'application/pdf'),
        ]);



        $this->assertDatabaseHas('study_books', [

            'user_id' => $user->id,
            'title' => 'test title',
        ]);
    }

    public function test_guest_cannot_add_book()
    {
        $response = $this->postJson('api/v1/user/study/books/', [
            'title' => 'Guest Book',
            'year' => 2025,
        ]);

        $response->assertStatus(401);
    }

    public function test_book_requires_file_and_titele()
    {

        // our roles are the title : 5 letter and book : should be .pdf

        // check -> App\Http\Requests\Study\BookRequest 

        Storage::fake('public');

        $user = User::factory()->create();

        $this->actingAs($user, 'sanctum');

        $response = $this->postJson('api/v1/user/study/books/', [

            'title' => 'one',
            'book' => UploadedFile::fake()->create('test.png', 1),

        ]);


        $response->assertJsonValidationErrors(['title', 'book']);

        $response->assertStatus(422);
    }

    public function test_authentcated_user_can_see_only_his_study_books()
    {

        $ownerUser = User::factory()->create();
        $unAuthorizedUser = User::factory()->create();

        $this->actingAs($unAuthorizedUser, 'sanctum');

        $ownerUserBook = StudyBook::create([

            'user_id' => $ownerUser->id,
            'title' => 'ownerUser book',
            'path' => 'owner user path book'

        ]);

        $unAuthorizedUserBook = StudyBook::create([

            'user_id' => $unAuthorizedUser->id,
            'title' => 'unAuthorized User book',
            'path' => 'unAuthorizedUser path book'

        ]);

         $response = $this->getJson("api/v1/user/study/books/{$ownerUserBook->id}");

         $response->assertJsonFragment([
            'message' => 'This action is unauthorized.'
        ]);

        $response->assertStatus(403);
    }

    public function test_user_can_delete_study_book(){


Storage::fake('public');

$user = User::factory()->create();

$this->actingAs($user,'sanctum');

$insertBookResponse = $this->postJson('api/v1/user/study/books',
[
'title' => 'test book',
'book' => UploadedFile::fake()->create('test.pdf',1),]

);

$insertBookResponse->assertStatus(201);


$response = $this->deleteJson("api/v1/user/study/books/{$insertBookResponse['data']['id']}");

$response->assertStatus(200);

$this->assertDatabaseMissing('study_books',[

'id' => $insertBookResponse['data']['id'],

]);

    }
}
