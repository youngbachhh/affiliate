<?php

namespace App\Enums;

enum ShipStatus: int {
    case Pending = 1;
    case Shipped = 2;
    case Delivered = 3;
    case Cancelled = 4;
}
