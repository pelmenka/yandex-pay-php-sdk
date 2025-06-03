<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property string $productId
 * @property string $title
 * @property float | ItemQuantity $quantity
 * @property float $total
 */
class RenderedCartItem extends BaseEntity
{
    public function __construct(string $id, string $title, float | ItemQuantity $quantity, float $total)
    {
        parent::__construct([
            'productId' => $id,
            'title'     => $title,
            'quantity'  => $quantity,
            'total'     => $total
        ]);
    }

    protected array $casts = [
        'quantity' => 'quantity',
        'total' => 'money'
    ];
};
