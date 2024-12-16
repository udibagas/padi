<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(database_path('seeders/cities.json'));
        $cities = json_decode($data, true);

        $provinces = DB::table('provinces')->get();
        $provinces = $provinces->keyBy('code');

        foreach ($cities as $key => $city) {
            $province = $provinces->get($city['province_code']);
            $cities[$key]['province_id'] = $province->id;
        }

        DB::table('cities')->insert($cities);
    }
}
