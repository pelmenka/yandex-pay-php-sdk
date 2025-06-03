<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property float $count
 * @property float | null $available
 */
class ItemQuantity extends BaseEntity
{
    public function __construct(float $count, ?float $available = null)
    {
        parent::__construct();

        $this->count = $count;
        if ($available) {
            $this->available = $available;
        }
    }

    protected array $casts = [
        'count' => 'money',
        'available' => 'money',
    ];
};
