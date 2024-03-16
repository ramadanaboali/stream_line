<?php

namespace App\Repositories\General;

use App\Models\Category;
use App\Repositories\AbstractRepository;

class CategoryRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(Category::class);
    }


}
