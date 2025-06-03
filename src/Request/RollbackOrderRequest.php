<?php

namespace Triya\YandexPaySdk\Request;

class RollbackOrderRequest extends BaseRequest
{
    public function send(string $orderId)
    {
        $this->setPostContent(null);
        $this->setHeaders();

        return $this->exec("/v1/orders/{$orderId}/rollback");
    }
};
