<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property string $phone
 */
class SMSOffer extends BaseEntity
{
    public function __construct(string $phone)
    {
        parent::__construct([
            'token' => $phone,
        ]);
    }
};
