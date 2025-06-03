<?php

namespace Triya\YandexPaySdk\Request;

class GetOrderRequest extends BaseRequest
{
    public function send(string $orderId)
    {
        $this->setHeaders();
        return $this->exec("/v1/orders/{$orderId}");
    }
};
