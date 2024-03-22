<?php

namespace App\Repositories\Vendor;

use App\Models\Section;
use App\Repositories\AbstractRepository;
class SectionRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Section::class);
    }

}
