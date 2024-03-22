<?php

namespace App\Services\Admin;

use App\Repositories\Admin\SystemNotificationRepository;
use App\Services\AbstractService;

class SystemNotificationService extends AbstractService
{
    protected $repo;
    public function __construct(SystemNotificationRepository $repo)
    {
        parent::__construct($repo);
        $this->repo = $repo;
    }
}
