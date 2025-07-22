<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property string $token
 */
class QRData extends BaseEntity
{
    public function __construct(string $token)
    {
        parent::__construct([
            'token' => $token,
        ]);
    }
};
