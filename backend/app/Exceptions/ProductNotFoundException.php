<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Exception;

class ProductNotFoundException extends Exception
{
    public function render($request)
    {
        return ApiResponse::error('Product not found', 404);
    }
}
