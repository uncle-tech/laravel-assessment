<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\Tours as Tours;

class DeleteToursTest extends TestCase
{
    use DatabaseTransactions;
    private function getLastIdFromDatabase(){
        return Tours::select("id")->orderBy('created_at', 'desc')->first();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // TEST FOR DELETE METHOD     
    public function testDeleteTour(){
        $id = $this->getLastIdFromDatabase()->id;
        $response = $this->deleteJson('api/tours/'.$id);
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => true,
                "message" => "Deleted"
            ]);
    
    }
}
