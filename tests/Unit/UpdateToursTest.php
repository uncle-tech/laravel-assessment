<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\Tours as Tours;
use Illuminate\Support\Facades\DB;

class UpdateToursTest extends TestCase
{
    use DatabaseTransactions;
    // GENERATE RIGHT DATAS FOR TEST
    private function generateDatas(){
        $start = Faker::create()->dateTime()->format('Y-m-d H:i:s');
        return [
            'start' => $start,
            'end' => date('Y-m-d H:i:s', strtotime($start. '+ 2 hours')),
            'price' => Faker::create()->numberBetween($min = 0, $max = 99999999)
        ];
    }

    //GETTING A LAST INSERT ID FROM DATABASE
    private function getLastIdFromDatabase(){
        return Tours::select("id")->orderBy('created_at', 'desc')->first();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

     // TEST THE UPDATE METHOD
    public function testUpdateTour(){
        $id = $this->getLastIdFromDatabase()->id;
        $response = $this->putJson('api/tours/'.$id, $this->generateDatas());
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => true,
                "message" => "Updated"
            ]);
    
    }
}
