<?php

namespace App\Exceptions;

use App\Http\Responses\ApiResponse;
use Exception;

class CategoryNotFoundException extends Exception
{
    public function render($request)
    {
        return ApiResponse::error('Category not found', 404);
    }
}
