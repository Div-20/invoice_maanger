<?php

namespace Database\Seeders;

use App\Models\LocationStates;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\LazyCollection;

class LocationStateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        LazyCollection::make(function () {
            $handle = fopen(public_path("csv/location_states.csv"), 'r');

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
                    $aData = explode(',', $row[0]);
                    return [
                        'id' => trim($aData[0]),
                        'name' => trim($aData[1]),
                        'country_id' => trim($aData[2]),
                        'created_at' =>  \Carbon\Carbon::now(),
                        'updated_at' =>  \Carbon\Carbon::now(),
                        'status' =>  LocationStates::STATUS_ACTIVE,
                    ];
                })->toArray();

                LocationStates::insert($records);
            });
    }
}
