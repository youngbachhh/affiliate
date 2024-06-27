<?php

namespace App\Enums;

enum PaymentStatus: int {
    case Pending = 1;
    case Paid = 2;
    case Failed = 3;
    case Cancelled = 4;
}
