<?php

use Illuminate\Database\Seeder;
use App\Models\City;
use App\Models\Country;

class CityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        for($i=0;$i<5;$i++){
        	$country = factory(Country::class)->create();
	        factory(City::class, 5)->create([
	        	'country_id' => $country->id,
	        ]);
        }
    }
}
