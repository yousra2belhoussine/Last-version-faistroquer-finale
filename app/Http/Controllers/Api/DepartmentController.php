<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Region;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    /**
     * Get departments for a specific region.
     */
    public function byRegion(Region $region)
    {
        return response()->json(
            $region->departments()
                ->orderBy('name')
                ->get(['id', 'name'])
        );
    }
} 