<?php
namespace ArmMage\AutoCouponApply\Model;

use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Checkout\Helper\Cart as CartHelper;
use ArmMage\AutoCouponApply\Configuration\AutoCoupon;

/**
 * Purpose of CouponApply is to Check if module enable and
 * automatically apply the coupon code when eligible products
 * are added to the cart.
 */
class CouponApply
{
    /**
     * @param StoreManagerInterface $storeManager
     * @param LoggerInterface $logger
     * @param AutoCoupon $autoCouponConfig
     */
    public  function __construct(
        private StoreManagerInterface $storeManager,
        private LoggerInterface $logger,
        private AutoCoupon $autoCouponConfig
    ) {}

    /**
     * @param $quote
     * @return bool
     */
    public function autoApplyCoupon($quote) {

        try {
            $storeId = (int)$this->storeManager->getStore()->getId();
            $isEnabled = $this->autoCouponConfig->isEnabled($storeId);
            $couponCode = $this->autoCouponConfig->getCoupenCode($storeId);
            $codeLength = strlen($couponCode);
            $isCodeLengthValid = $codeLength && $codeLength <= CartHelper::COUPON_CODE_MAX_LENGTH;
            $oldCouponCode = $quote->getCouponCode();
            $productsList = $this->autoCouponConfig->getProductsList($storeId);
            $items = $quote->getAllItems();
            $exist = false;
            foreach ($items as $item) {
                if(is_array($productsList) && in_array($item->getProductId(), $productsList)){
                    $exist = true;
                    break;
                }
            }
            if ($oldCouponCode && $couponCode==$oldCouponCode) {
                if(!$isEnabled){
                    $quote->setCouponCode('')->setTotalsCollectedFlag(false);
                }
            }
            if ($exist && $isCodeLengthValid) {
                $quote->setCouponCode($couponCode)->setTotalsCollectedFlag(false);
                return true;
            }else{
                $quote->setCouponCode('')->setTotalsCollectedFlag(false);
            }
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
        return false;
    }
}
