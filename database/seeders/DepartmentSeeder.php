<?php

namespace Database\Seeders;

use App\Models\Department;
use App\Models\Region;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $departments = [
            'Auvergne-Rhône-Alpes' => [
                ['name' => 'Ain', 'code' => '01'],
                ['name' => 'Allier', 'code' => '03'],
                ['name' => 'Ardèche', 'code' => '07'],
                ['name' => 'Cantal', 'code' => '15'],
                ['name' => 'Drôme', 'code' => '26'],
                ['name' => 'Isère', 'code' => '38'],
                ['name' => 'Loire', 'code' => '42'],
                ['name' => 'Haute-Loire', 'code' => '43'],
                ['name' => 'Puy-de-Dôme', 'code' => '63'],
                ['name' => 'Rhône', 'code' => '69'],
                ['name' => 'Savoie', 'code' => '73'],
                ['name' => 'Haute-Savoie', 'code' => '74'],
            ],
            'Île-de-France' => [
                ['name' => 'Paris', 'code' => '75'],
                ['name' => 'Seine-et-Marne', 'code' => '77'],
                ['name' => 'Yvelines', 'code' => '78'],
                ['name' => 'Essonne', 'code' => '91'],
                ['name' => 'Hauts-de-Seine', 'code' => '92'],
                ['name' => 'Seine-Saint-Denis', 'code' => '93'],
                ['name' => 'Val-de-Marne', 'code' => '94'],
                ['name' => "Val-d'Oise", 'code' => '95'],
            ],
            // Add other departments for each region...
        ];

        foreach ($departments as $regionName => $depts) {
            $region = Region::where('name', $regionName)->first();
            
            foreach ($depts as $dept) {
                Department::create([
                    'name' => $dept['name'],
                    'code' => $dept['code'],
                    'slug' => Str::slug($dept['name']),
                    'region_id' => $region->id,
                ]);
            }
        }
    }
} 