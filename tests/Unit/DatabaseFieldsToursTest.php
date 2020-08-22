<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Faker\Factory as Faker;
use Tests\TestCase;
use App\Models\Tours as Tours;

class DatabaseFieldsToursTest extends TestCase
{
    use DatabaseTransactions;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    // TEST FOR TO COMPARE THE DATABASE

    public function testDatabaseFieldsTour(){
        $tours = new Tours;
        $expected = [
            "start",
            "end", 
            "price"
        ];
        $compare = array_diff($expected, $tours->getFillable());
        $this->assertEquals(0, count($compare));
    
    }
}
