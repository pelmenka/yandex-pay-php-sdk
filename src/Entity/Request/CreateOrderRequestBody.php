<?php

namespace Triya\YandexPaySdk\Entity\Request;

use Triya\YandexPaySdk\BaseEntity;
use Triya\YandexPaySdk\Entity\MerchantRedirectUrls;
use Triya\YandexPaySdk\Entity\RenderedCart;

/**
 * 
 * @package Triya\YandexPaySdk\Entity\Request
 * 
 * @property RenderedCart $cart
 * @property 'RUB' $currencyCode
 * @property string $orderId
 * @property MerchantRedirectUrls $redirectUrls
 * @property OrderExtensions $extensions
 * @property ?array<'CARD'|'SPLIT'> $availablePaymentMethods
 * @property ?string $billingPhone
 * @property ?bool $isPrepayment
 * @property ?string $metadata
 * @property ?'WEBSITE'|'APP'|'CRM'|'CASH_REGISTER'|'CMS_PLUGIN' $orderSource
 * @property ?'FULLPAYMENT'|'SPLIT' $preferredPaymentMethod
 * @property ?string $purpose
 * @property ?int $ttl
 */
class CreateOrderRequestBody extends BaseEntity
{
    public function __construct(RenderedCart $cart, string $orderId)
    {
        parent::__construct([
            'cart' => $cart,
            'orderId' => $orderId,
            'currencyCode' => 'RUB'
        ]);
    }
};
