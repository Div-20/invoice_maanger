<?php

namespace Database\Seeders;

use App\Models\LocationCountry;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class LocationCountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(public_path("csv/location_countries.csv"), 'r');

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
                    $aData = explode(',',$row[0]);
                    return [
                        'id' => trim($aData[0]),
                        'name' => trim($aData[1]),
                        'code' => trim($aData[2]),
                        'capital' => trim($aData[3]),
                        'currency' => trim($aData[4]),
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' =>  \Carbon\Carbon::now(),
                        'status' =>  LocationCountry::STATUS_ACTIVE,
                    ];
                })->toArray();

                LocationCountry::insert($records);
            });
    }
}
