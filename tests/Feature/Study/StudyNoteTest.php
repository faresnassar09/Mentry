<?php

namespace Tests\Feature\Study;

use App\Models\Study\StudyNote;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class StudyNoteTest extends TestCase
{

    use RefreshDatabase;

    /**
     * A basic feature test example.
     */
    public function test_study_note_can_inserted(): void
    {

        $user = User::factory()->create(); 

        $noteResponse = StudyNote::create([

            'user_id' =>$user->id,
            'title' => 'lojpoj' ,
             'body' => 'ihoihoi',
            
            ]);


            $noteResponse->assertStatus(200);

        $this->assertDatabaseHas('study_notes',[

            'body' => 'ihoihoi',
        ]);
    }
}
