<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker\Factory as Faker;
use App\Models\Tours as Tours;

class ToursTest extends TestCase
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

    // GENERATE WRONG DATAS FOR TEST  

    private function generateWrongDatas(){
        return [
            'start' => Faker::create()->name(),
            'end' => Faker::create()->name(),
            'price' => 999999999
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



    // METHODS FOR THE STORE METHOD

    public function test_for_when_the_parameters_are_wrong_in_the_store_method()
    {
        $response = $this->postJson('api/tours', $this->generateWrongDatas());
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Invalid Params"
            ]);
    }
    public function test_for_when_the_parameters_start_is_greater_of_the_end_in_the_store_method()
    {
        $response = $this->postJson('api/tours', [
            'start' => "2020-02-01 00:00:00",
            'end' => "2020-01-01 00:00:00",
            'price' => 999999
        ]);
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Start date must be less than end date"
            ]);
    }
    
    
    // METHODS FOR THE SHOW METHOD

    public function test_for_when_the_id_are_wrong_in_the_show_method()
    {
        $id = $this->getLastIdFromDatabase()->id + 1;
        $response = $this->putJson('api/tours/'.$id);
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Non existed id"
            ]);
    }
    public function test_for_when_the_price_parameter_is_filled_in_wrong_in_the_method_show()
    {
        $response = $this->getJson('api/tours?price[eq]=abc');
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "write a number on the price param"
            ]);
    }
    public function test_for_when_the_operator_parameter_is_filled_in_wrong_in_the_method_show()
    {
        $response = $this->getJson('api/tours?price[abc]=123');
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Invalid Operator"
            ]);
    }
    public function test_for_when_the_limit_parameter_is_filled_in_wrong_in_the_method_show()
    {
        $response = $this->getJson('api/tours?price[gte]=123&limit=abc');
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "The offset and limit field must be of the numeric type"
            ]);
    }
    public function test_for_when_the_offset_parameter_is_filled_in_wrong_in_the_method_show()
    {
        $response = $this->getJson('api/tours?price[gte]=123&limit=123&offset=abc');
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "The offset and limit field must be of the numeric type"
            ]);
    }

    // METHODS FOR THE UPDATE METHOD
    
    public function test_for_when_the_id_are_wrong_in_the_update_method()
    {
        $id = $this->getLastIdFromDatabase()->id + 1;
        $response = $this->putJson('api/tours/'.$id, $this->generateWrongDatas());
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Non existed id"
            ]);
    }
    public function test_for_when_the_parameters_are_wrong_in_the_update_method()
    {
        $id = $this->getLastIdFromDatabase()->id;
        $response = $this->putJson('api/tours/'.$id, $this->generateWrongDatas());
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Invalid Params"
            ]);
    }
    public function test_for_when_the_parameters_start_is_greater_of_the_end_in_the_update_method()
    {
        $id = $this->getLastIdFromDatabase()->id;

        $response = $this->putJson('api/tours/'.$id, [
            'start' => "2020-02-01 00:00:00",
            'end' => "2020-01-01 00:00:00",
            'price' => 999999
        ]);
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Start date must be less than end date"
            ]);
    }

    // METHODS FOR THE DELETE METHOD

    public function test_for_when_the_id_are_wrong_in_the_delete_method()
    {
        $id = $this->getLastIdFromDatabase()->id + 1;
        $response = $this->deleteJson('api/tours/'.$id);
        
        $response
        ->assertStatus(200)
            ->assertJson([
                "response" => false,
                "message" => "Non existed id"
            ]);
    }
}
