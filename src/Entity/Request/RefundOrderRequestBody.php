<?php

namespace Triya\YandexPaySdk\Entity\Request;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity\Request
 * 
 * @property string $orderId
 * @property float $refundAmount
 */
class RefundOrderRequestBody extends BaseEntity
{
    public function __construct(string $orderId, float $amount)
    {
        parent::__construct([
            'orderId' => $orderId,
            'refundAmount' => $amount
        ]);
    }

    protected array $casts = [
        'refundAmount' => 'money',
    ];
};
