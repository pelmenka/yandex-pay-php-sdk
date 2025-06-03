<?php

namespace Triya\YandexPaySdk;

use Firebase\JWT\JWK;
use Firebase\JWT\JWT;
use RuntimeException;

class JWTDecoder
{
    private array $keys = null;

    public function __construct(private readonly bool $sandbox)
    {
        
    }

    public function decode(string $payload)
    {
        $this->loadKeys();
        return JWT::decode($payload, $this->keys);
    }

    private function loadKeys()
    {
        if (!empty($this->keys)) {
            return;
        }

        $curl = curl_init($this->getApiUrl());
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($curl);

        $error = curl_errno($curl);
        if ($error) {
            $error = curl_error($curl);
            curl_close($curl);
            throw new RuntimeException($error);
        }
        curl_close($curl);

        $keysData = json_decode($response, JSON_OBJECT_AS_ARRAY | JSON_THROW_ON_ERROR);

        $this->keys = JWK::parseKeySet($keysData);
    }

    private function getApiUrl()
    {
        return $this->sandbox ? 'https://sandbox.pay.yandex.ru/api/jwks' : 'https://pay.yandex.ru/api/jwks';
    }
};
