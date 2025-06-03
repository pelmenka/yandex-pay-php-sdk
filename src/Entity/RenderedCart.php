<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property RenderedCartItem[] $items
 * @property CartTotal $total
 */
class RenderedCart extends BaseEntity
{
    /**
     * 
     * @param RenderedCartItem[] $items 
     * @return void 
     */
    public function __construct(array $items = [])
    {
        parent::__construct([
            'items' => $items,
        ]);
    }

    public function addItem(RenderedCartItem $newItem)
    {
        foreach ($this->items as $item) {
            if ($item->id === $newItem->id) {
                $item->total += $item->total;
                return;
            }
        }

        $this->items[] = $newItem;
    }

    protected function beforeSerialization()
    {
        if (!$this->total) {
            $totalPrice = array_reduce($this->items, fn ($carry, $item) => $carry + $item->total, 0);
            $this->total = new CartTotal($totalPrice);
        }
    }
};
