<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Department;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    public function run(): void
    {
        $regions = [
            'Île-de-France' => [
                ['name' => 'Paris', 'code' => '75'],
                ['name' => 'Seine-et-Marne', 'code' => '77'],
                ['name' => 'Yvelines', 'code' => '78'],
                ['name' => 'Essonne', 'code' => '91'],
                ['name' => 'Hauts-de-Seine', 'code' => '92'],
                ['name' => 'Seine-Saint-Denis', 'code' => '93'],
                ['name' => 'Val-de-Marne', 'code' => '94'],
                ['name' => "Val-d'Oise", 'code' => '95']
            ]
        ];

        foreach ($regions as $regionName => $departments) {
            $region = Region::create([
                'name' => $regionName,
                'slug' => Str::slug($regionName)
            ]);
            
            foreach ($departments as $department) {
                Department::create([
                    'name' => $department['name'],
                    'region_id' => $region->id,
                    'slug' => Str::slug($department['name']),
                    'code' => $department['code']
                ]);
            }
        }
    }
} 