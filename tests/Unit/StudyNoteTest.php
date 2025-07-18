<?php

namespace Tests\Unit;

use App\Models\Study\StudyNote;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class StudyNoteTest extends TestCase
{

    public function test_study_note(): void
    {


        
 
        $this->assertDatabaseHas('users', [
            'email' => 'ff01121414088@gmail.com',
        ]);
        

    }
}
