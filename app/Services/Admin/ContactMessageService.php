<?php

namespace App\Services\Admin;

use App\Repositories\Admin\ContactMessageRepository;
use App\Services\AbstractService;

class ContactMessageService extends AbstractService
{
    protected $repo;
    public function __construct(ContactMessageRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
