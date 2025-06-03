<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property float $amount
 * @property float $pointsAmount
 */
class CartTotal extends BaseEntity
{
    public function __construct(float $amount, ?float $pointsAmount = null)
    {
        parent::__construct([
            'amount'       => $amount,
            'pointsAmount' => $pointsAmount,
        ]);
    }

    protected array $casts = [
        'amount' => 'money',
    ];
};
