<?php

namespace App\Enums;

enum OrderStatus: int {
    case Pending = 1;
    case Processing = 2;
    case Completed = 3;
    case Cancelled = 4;
}
