<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController; // Alias BaseController

abstract class Controller extends BaseController // Extend BaseController
{
    use AuthorizesRequests, ValidatesRequests; // Use the traits
}
