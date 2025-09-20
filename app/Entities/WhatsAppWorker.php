<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class WhatsAppWorker extends Entity
{
    protected $datamap = [];
    protected $dates   = ['created_at','started_at','finished_at'];
    protected $casts   = [];
}
