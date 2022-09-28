<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Score;

class ScoreTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_single_score_score(){
        $score = Score::factory()->create();
        $this->assertIsInt($score->score);
    }

    public function test_single_score_name(){
        $score = Score::factory()->create();
        $this->assertIsString($score->name);
    }
}
