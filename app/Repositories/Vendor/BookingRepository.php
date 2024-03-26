<?php

namespace App\Repositories\Vendor;

use App\Models\Booking;
use App\Repositories\AbstractRepository;
class BookingRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Booking::class);
    }

}
