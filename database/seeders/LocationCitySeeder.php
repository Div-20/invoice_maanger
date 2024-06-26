<?php

namespace Database\Seeders;

use App\Models\LocationCity;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class LocationCitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(public_path("csv/location_cities.csv"), 'r');

            while (($line = fgetcsv($handle, 4096)) !== false) {
                $dataString = implode(", ", $line);
                $row = explode(';', $dataString);
                yield $row;
            }

            fclose($handle);
        })
            ->skip(1)
            ->chunk(1000)
            ->each(function (LazyCollection $chunk) {
                $records = $chunk->map(function ($row) {
                    $aData = explode(', ', $row[0]);
                    return [
                        'id' => trim($aData[0]),
                        'name' => trim($aData[1]),
                        'state_id' => trim($aData[2]),
                        'district_id' => (($aData[3] == NULL || $aData[3] == 'NULL' || $aData[3] == '') ? 0 : trim($aData[3])),
                        'region_status' => trim($aData[4]),
                        'pin_code' => (($aData[6] == NULL || $aData[6] == 'NULL' || $aData[6] == '') ? 0 : trim($aData[6])),
                        'icon' => trim($aData[7]),
                        'tier_type' => trim($aData[5]),
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' =>  \Carbon\Carbon::now(),
                        'status' =>  LocationCity::STATUS_ACTIVE,
                    ];
                })->toArray();
                LocationCity::insert($records);
            });
    }
}
