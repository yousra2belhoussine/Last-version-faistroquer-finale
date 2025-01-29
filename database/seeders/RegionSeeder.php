<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Region;
use App\Models\Department;
use Illuminate\Support\Str;

class RegionSeeder extends Seeder
{
    public function run()
    {
        $regions = [
            'Auvergne-Rhône-Alpes' => [
                'code' => 'ARA',
                'departments' => ['Ain', 'Allier', 'Ardèche', 'Cantal', 'Drôme', 'Isère', 'Loire',
                    'Haute-Loire', 'Puy-de-Dôme', 'Rhône', 'Savoie', 'Haute-Savoie']
            ],
            'Bourgogne-Franche-Comté' => [
                'code' => 'BFC',
                'departments' => ['Côte-d\'Or', 'Doubs', 'Jura', 'Nièvre', 'Haute-Saône',
                    'Saône-et-Loire', 'Yonne', 'Territoire de Belfort']
            ],
            'Bretagne' => [
                'code' => 'BRE',
                'departments' => ['Côtes-d\'Armor', 'Finistère', 'Ille-et-Vilaine', 'Morbihan']
            ],
            'Centre-Val de Loire' => [
                'code' => 'CVL',
                'departments' => ['Cher', 'Eure-et-Loir', 'Indre', 'Indre-et-Loire',
                    'Loir-et-Cher', 'Loiret']
            ],
            'Île-de-France' => [
                'code' => 'IDF',
                'departments' => ['Paris', 'Seine-et-Marne', 'Yvelines', 'Essonne',
                    'Hauts-de-Seine', 'Seine-Saint-Denis', 'Val-de-Marne', 'Val-d\'Oise']
            ]
        ];

        foreach ($regions as $regionName => $data) {
            $region = Region::create([
                'name' => $regionName,
                'code' => $data['code'],
                'slug' => Str::slug($regionName)
            ]);
            
            foreach ($data['departments'] as $departmentName) {
                Department::create([
                    'name' => $departmentName,
                    'region_id' => $region->id,
                    'slug' => Str::slug($departmentName)
                ]);
            }
        }
    }
} 