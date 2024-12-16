<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = file_get_contents(database_path('seeders/villages.json'));
        $villages = json_decode($data, true);

        $subDistricts = DB::table('sub_districts')->get();
        $subDistricts = $subDistricts->keyBy('code');

        foreach ($villages as $key => $village) {
            $subDistrict = $subDistricts->get($village['district_code']);
            $villages[$key]['sub_district_id'] = $subDistrict->id;
            $villages[$key]['sub_district_code'] = $subDistrict->code;
            $villages[$key]['postal_code'] = $villages[$key]['postalCode'] ?? null;

            unset($villages[$key]['district_code']);
            unset($villages[$key]['postalCode']);
        }

        $collection = collect($villages);
        $chunks = $collection->chunk(1000);

        foreach ($chunks as $chunk) {
            DB::table('villages')->insert($chunk->toArray());
        }
    }
}
