<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Copy;
use Illuminate\Http\Request;
use App\Http\Resources\CopyResource;

class InventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $copies = Copy::with('book')->get();

        return CopyResource::collection($copies);
    }
}
