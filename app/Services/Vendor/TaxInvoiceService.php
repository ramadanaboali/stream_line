<?php

namespace App\Services\Vendor;

use App\Repositories\Vendor\TaxInvoiceRepository;
use App\Services\AbstractService;
class TaxInvoiceService extends AbstractService
{
    protected $repo;
    public function __construct(TaxInvoiceRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
  }
