<?php

namespace Triya\YandexPaySdk\Request;

use Triya\YandexPaySdk\Entity\Request\RefundOrderRequestBody;

class RefundOrderRequest extends BaseRequest
{
    public function send(RefundOrderRequestBody $body)
    {
        $this->setPostContent(json_encode($body));
        $this->setHeaders();

        return $this->exec("/v2/orders/{$body->orderId}/refund");
    }
};
