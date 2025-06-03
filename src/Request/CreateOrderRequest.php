<?php

namespace Triya\YandexPaySdk\Request;

use Triya\YandexPaySdk\Entity\Request\CreateOrderRequestBody;

class CreateOrderRequest extends BaseRequest
{
    public function send(CreateOrderRequestBody $body)
    {
        $this->setPostContent(json_encode($body));
        $this->setHeaders();

        return $this->exec('/v1/orders');
    }
};
