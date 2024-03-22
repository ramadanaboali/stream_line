<?php

namespace App\Repositories\Admin;

use App\Models\SystemNotification;
use App\Repositories\AbstractRepository;

class SystemNotificationRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(SystemNotification::class);
    }


}
