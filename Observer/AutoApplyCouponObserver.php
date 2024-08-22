<?php
namespace ArmMage\AutoCouponApply\Observer;

use Magento\Framework\Event\Observer;
use Magento\Framework\Event\ObserverInterface;
use Magento\Checkout\Model\Cart;
use Psr\Log\LoggerInterface;
use ArmMage\AutoCouponApply\Model\CouponApply;

/**
 * Observes the `sales_quote_collect_totals_before` event.
 * Apply coupon code if valid for cart
 */
class AutoApplyCouponObserver implements ObserverInterface
{
    /**
     * @param Cart $cart
     * @param LoggerInterface $logger
     * @param CouponApply $couponApply
     */
    public  function __construct(
        private Cart $cart,
        private LoggerInterface $logger,
        private CouponApply $couponApply
    ) {}

    /**
     * Observer for sales_quote_collect_totals_before.
     *
     * @param Observer $observer
     *
     */
    public function execute(Observer $observer)
    {
        try {
            $this->couponApply->autoApplyCoupon($this->cart->getQuote());
        } catch (\Exception $e) {
            $this->logger->error($e->getMessage());
        }
    }

}
