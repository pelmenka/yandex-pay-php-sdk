<?php

namespace Triya\YandexPaySdk;

use Triya\YandexPaySdk\Entity\Request\CreateOrderRequestBody;
use Triya\YandexPaySdk\Entity\Request\RefundOrderRequestBody;
use Triya\YandexPaySdk\Request\CreateOrderRequest;
use Triya\YandexPaySdk\Request\GetOrderRequest;
use Triya\YandexPaySdk\Request\RefundOrderRequest;
use Triya\YandexPaySdk\Request\RollbackOrderRequest;

class Client
{
    private JWTDecoder $jwtDecoder;

    /**
     * 
     * @param string $apiKey Ключ к API\
     * В случае sandbox окружения здесь указывется merchant_id
     * @param bool $sandbox 
     * @return void 
     */
    public function __construct(public readonly string $apiKey, public readonly bool $sandbox)
    {
        $this->jwtDecoder = new JWTDecoder($sandbox);
    }

    public function createOrder(CreateOrderRequestBody $body, string $requestId, int $attempt = 0)
    {
        $request = new CreateOrderRequest($this);
        $request->setMetadata($requestId, $attempt);
        return $request->send($body);
    }

    public function rollbackOrder(string $orderId, string $requestId, int $attempt = 0)
    {
        $request = new RollbackOrderRequest($this);
        $request->setMetadata($requestId, $attempt);
        return $request->send($orderId);
    }

    public function refundOrder(string $orderId, float $amount, string $requestId, int $attempt = 0)
    {
        $request = new RefundOrderRequest($this);
        $request->setMetadata($requestId, $attempt);
        return $request->send(new RefundOrderRequestBody($orderId, $amount));
    }

    public function getOrder(string $orderId)
    {
        $request = new GetOrderRequest($this);
        return $request->send($orderId);
    }

    public function decodeJWT(string $payload)
    {
        return $this->jwtDecoder->decode($payload);
    }

    public function getApiBaseUrl()
    {
        return $this->sandbox ? 'https://sandbox.pay.yandex.ru/api/merchant' : 'https://pay.yandex.ru/api/merchant';
    }
};
