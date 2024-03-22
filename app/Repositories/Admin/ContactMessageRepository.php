<?php

namespace App\Repositories\Admin;

use App\Models\ContactMessage;
use App\Repositories\AbstractRepository;

class ContactMessageRepository extends AbstractRepository
{
    public function __construct()
    {
        parent::__construct(ContactMessage::class);
    }


}
