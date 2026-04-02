<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @method void authorize(string $ability, mixed $arguments = [])
 */
abstract class Controller extends BaseController
{
    use AuthorizesRequests;
}
