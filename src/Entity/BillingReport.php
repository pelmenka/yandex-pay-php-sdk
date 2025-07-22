<?php

namespace Triya\YandexPaySdk\Entity;

use Triya\YandexPaySdk\BaseEntity;

/**
 * 
 * @package Triya\YandexPaySdk\Entity
 * 
 * @property string $branchId
 * @property string $managerId
 */
class BillingReport extends BaseEntity
{
    public function __construct(string $branchId, string $managerId)
    {
        parent::__construct([
            'branchId' => $branchId,
            'managerId' => $managerId
        ]);
    }
};
