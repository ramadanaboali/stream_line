<?php

namespace App\Repositories\Vendor;

use App\Models\TaxInvoice;
use App\Repositories\AbstractRepository;
class TaxInvoiceRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(TaxInvoice::class);
    }

}
