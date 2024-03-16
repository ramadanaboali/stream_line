<?php

namespace App\Services\General;

use App\Repositories\General\CategoryRepository;
use App\Services\AbstractService;

class CategoryService extends AbstractService
{
    protected $repo;
    public function __construct(CategoryRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
