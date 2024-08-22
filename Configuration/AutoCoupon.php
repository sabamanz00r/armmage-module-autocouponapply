<?php
declare(strict_types=1);
namespace ArmMage\AutoCouponApply\Configuration;

use Magento\Framework\App\Config\ScopeConfigInterface;
use Magento\Store\Model\ScopeInterface;

/**
 * AutoCoupon class return configuration values
 */
class AutoCoupon
{
    const XML_PATH_COUPON_CODE = 'armmage/autocoupon/coupon_code';

    const XML_PATH_MODULE_ENABLED = 'armmage/autocoupon/enable';

    const XML_PATH_PRODUCTS_LIST = 'armmage/autocoupon/products';

    const XML_PATH_CUSTOM_URL = 'armmage/autocoupon/custom_url';

    /**
     * @param ScopeConfigInterface $scopeConfig
     */
    public function __construct(
        private ScopeConfigInterface $scopeConfig
    )
    {
    }

    /**
     * @param int $storeId
     * @return mixed
     */
    public function getCoupenCode(int $storeId): mixed
    {
        return $this->scopeConfig->getValue(self::XML_PATH_COUPON_CODE, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return string[]|null
     */
    public function getProductsList(int $storeId)
    {
        if ($this->isEnabled($storeId)) {
            $productsList = $this->scopeConfig->getValue(self::XML_PATH_PRODUCTS_LIST, ScopeInterface::SCOPE_STORE, $storeId);
            return explode(",", $productsList);
        }
        return null;
    }

    /**
     * @param int $storeId
     * @return bool
     */
    public function isEnabled(int $storeId): bool
    {
        return $this->scopeConfig->isSetFlag(self::XML_PATH_MODULE_ENABLED, ScopeInterface::SCOPE_STORE, $storeId);
    }

    /**
     * @param int $storeId
     * @return mixed|null
     */
    public function getCustomUrl(int $storeId)
    {
        if ($this->isEnabled($storeId)) {
            return $this->scopeConfig->getValue(self::XML_PATH_CUSTOM_URL, ScopeInterface::SCOPE_STORE, $storeId);
        }
        return null;
    }
}
