<?php

namespace Triya\YandexPaySdk;

use Triya\YandexPaySdk\Entity\ItemQuantity;

class EntityTransformer
{
    private array $transformers = [];

    public function __construct()
    {
        $this->transformers['money'] = fn (float $value) => number_format($value, 2, '.', '');
        $this->transformers['quantity'] = fn (float | ItemQuantity $value) => $value instanceof ItemQuantity ? $value : new ItemQuantity($value);
    }

    public function transformValue(string $type, mixed $value)
    {
        if (isset($this->transformers[$type])) {
            return $this->transformers[$type]($value);
        }

        return $value;
    }
};

