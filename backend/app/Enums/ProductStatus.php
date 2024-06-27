<?php

namespace App\Enums;

enum ProductStatus: int {
    case Pending = 1;
    case Active = 2;
    case Inactive = 3;
    case OutOfStock = 4;
    case Discontinued = 5;
}
