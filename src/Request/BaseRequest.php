<?php

namespace Triya\YandexPaySdk\Request;

use CurlHandle;
use Triya\YandexPaySdk\Client;
use Triya\YandexPaySdk\Exceptions\ApiException;
use Triya\YandexPaySdk\Exceptions\ConnectionException;
use Triya\YandexPaySdk\Exceptions\NotFoundException;
use Triya\YandexPaySdk\Exceptions\ServerErrorException;
use Triya\YandexPaySdk\Exceptions\ServiceUnavailableException;
use Triya\YandexPaySdk\Exceptions\UnauthorizedException;

abstract class BaseRequest
{
    protected CurlHandle $curl;
    protected string | null $requestId = null;
    protected int $timeout = 3000;
    protected int $attempt = 0;
    protected ?string $content = null;

    public function __construct(protected readonly Client $client)
    {
        $this->curl = curl_init();
        curl_setopt($this->curl, CURLOPT_RETURNTRANSFER, true);
    }

    public function __destruct()
    {
        curl_close($this->curl);
    }

    /**
     * @param int $timeout Таймаут в милисекундах, должен быть не меньше секунды и не больше 10 секунд \
     * Получается, значения от 1000 до 10000
     * @return void 
     * 
     * @see https://pay.yandex.ru/docs/ru/custom/backend/yandex-pay-api/
     */
    public function setTimeout(int $timeout) {
        $this->timeout = $timeout;
    }

    /**
     * 
     * @param string $requestId Ключ идемотентности
     * @param int $attempt Номер попытки запроса с этим ключом
     * @return void 
     * 
     * @see https://pay.yandex.ru/docs/ru/custom/backend/yandex-pay-api/
     */
    public function setMetadata(string $requestId, int $attempt = 0) {
        $this->requestId = $requestId;
        $this->attempt = $attempt;
    }

    protected function exec(string $url)
    {
        $url = $this->client->getApiBaseUrl() . $url;

        curl_setopt($this->curl, CURLOPT_URL, $url);

        $response = curl_exec($this->curl);

        if (curl_errno($this->curl) > 0) {
            throw new ConnectionException(curl_error($this->curl));
        }

        $info = curl_getinfo($this->curl);

        switch ($info['http_code'] ?? 0) {
            case 200:
                $result = json_decode($response, flags: JSON_THROW_ON_ERROR);
                return $result;
            case 504:
            case 503:
            case 502:
                throw new ServiceUnavailableException("service unavailable", $info['http_code'], (string) $response);
            case 500:
                throw new ServerErrorException("server error", $info['http_code'], (string) $response);
            case 401:
                throw new UnauthorizedException("unauthorized", $info['http_code'], (string) $response);
            case 404:
                throw new NotFoundException("not found", $info['http_code'], (string) $response);
            default:
                throw new ApiException("", $info['http_code'] ?? 0, (string) $response);
        }
    }

    protected function setPostContent(?string $content)
    {
        $this->content = $content;

        curl_setopt_array($this->curl, [
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => $content,
        ]);
    }

    protected function setHeaders(array $additionalHeaders = [])
    {
        $headers = [
            'Authorization' => "Api-Key {$this->client->apiKey}",
        ];

        if ($this->requestId) {
            $headers['X-Request-Id'] = $this->requestId;
        }

        if ($this->attempt) {
            $headers['X-Request-Attempt'] = $this->attempt;
        }

        if ($this->timeout) {
            $headers['X-Request-Timeout'] = $this->timeout;
        }

        if ($this->content) {
            $headers['Content-Type'] = 'application/json';
            $headers['Content-Length'] = strlen($this->content);
        }

        if (!empty($additionalHeaders)) {
            $headers = array_merge($headers, $additionalHeaders);
        }

        $stringHeaders = [];
        foreach ($headers as $key => $value) {
            $stringHeaders[] = "{$key}: {$value}";
        }

        curl_setopt($this->curl, CURLOPT_HTTPHEADER, $stringHeaders);
    }
};

