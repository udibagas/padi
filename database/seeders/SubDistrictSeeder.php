<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubDistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(database_path('seeders/sub_districts.json'));
        $subDistricts = json_decode($data, true);

        $cities = DB::table('cities')->get();
        $cities = $cities->keyBy('code');

        foreach ($subDistricts as $key => $subDistrict) {
            $city = $cities->get($subDistrict['city_code']);
            $subDistricts[$key]['city_id'] = $city->id;
        }

        DB::table('sub_districts')->insert($subDistricts);
    }
}
