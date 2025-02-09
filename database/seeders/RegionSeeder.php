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
                'Paris', 'Seine-et-Marne', 'Yvelines', 'Essonne',
                'Hauts-de-Seine', 'Seine-Saint-Denis', 'Val-de-Marne', "Val-d'Oise"
            ],
            'Auvergne-Rhône-Alpes' => [
                'Ain', 'Allier', 'Ardèche', 'Cantal', 'Drôme', 'Isère',
                'Loire', 'Haute-Loire', 'Puy-de-Dôme', 'Rhône', 'Savoie', 'Haute-Savoie'
            ],
            'Nouvelle-Aquitaine' => [
                'Charente', 'Charente-Maritime', 'Corrèze', 'Creuse', 'Dordogne',
                'Gironde', 'Landes', 'Lot-et-Garonne', 'Pyrénées-Atlantiques',
                'Deux-Sèvres', 'Vienne', 'Haute-Vienne'
            ],
            'Bourgogne-Franche-Comté' => [
                'Côte-d\'Or', 'Doubs', 'Jura', 'Nièvre', 'Haute-Saône',
                'Saône-et-Loire', 'Yonne', 'Territoire de Belfort'
            ],
            'Bretagne' => [
                'Côtes-d\'Armor', 'Finistère', 'Ille-et-Vilaine', 'Morbihan'
            ],
            'Centre-Val de Loire' => [
                'Cher', 'Eure-et-Loir', 'Indre', 'Indre-et-Loire',
                'Loir-et-Cher', 'Loiret'
            ]
        ];

        foreach ($regions as $regionName => $departments) {
            $region = Region::create([
                'name' => $regionName,
                'slug' => Str::slug($regionName)
            ]);
            
            foreach ($departments as $departmentName) {
                Department::create([
                    'name' => $departmentName,
                    'region_id' => $region->id,
                    'slug' => Str::slug($departmentName)
                ]);
            }
        }
    }
} 