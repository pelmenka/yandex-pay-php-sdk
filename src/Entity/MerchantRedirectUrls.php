<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property string $onError
 * @property string $onSuccess
 * @property ?string $onAbort
 */
class MerchantRedirectUrls extends BaseEntity
{
    public function __construct(string $onSuccess, ?string $onError = null)
    {
        parent::__construct([
            'onSuccess' => $onSuccess,
            'onError' => $onError ?? $onSuccess
        ]);
    }
};
