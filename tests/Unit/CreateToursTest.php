<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Tests\TestCase;

class CreateToursTest extends TestCase
{
    use DatabaseTransactions;
    private function generateDatas(){
        $start = Faker::create()->dateTime()->format('Y-m-d H:i:s');
        return [
            'start' => $start,
            'end' => date('Y-m-d H:i:s', strtotime($start. '+ 2 hours')),
            'price' => Faker::create()->numberBetween($min = 0, $max = 99999999)
        ];
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // TEST FOR CREATE METHOD

    public function testCreateTour(){
        
        $response = $this->postJson('api/tours', $this->generateDatas());
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => true,
                "message" => "Created"
            ]);
    
    }
}
