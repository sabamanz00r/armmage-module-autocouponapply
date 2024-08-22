<?php
namespace ArmMage\AutoCouponApply\Plugin;

use Magento\Checkout\Controller\Cart\Add as AddCart;
use Magento\Framework\App\ResponseInterface;
use Magento\Framework\Json\Helper\Data;
use ArmMage\AutoCouponApply\Configuration\AutoCoupon;
use Magento\Framework\Message\MessageInterface;
use Magento\Store\Model\StoreManagerInterface;
use Magento\Checkout\Model\Session as CheckoutSession;
use Magento\Framework\Message\ManagerInterface;

/**
 * Purpose of Add plugin is to check if the current product is
 * in the list of eligible products, if yes then redirect to
 * custom url after add to cart
 */
class AddPlugin
{
    /**
     * @param StoreManagerInterface $storeManager
     * @param Data $jsonHelper
     * @param AutoCoupon $autoCouponConfig
     * @param CheckoutSession $checkoutSession
     * @param ManagerInterface $messageManager
     */
    public function __construct(
        private StoreManagerInterface $storeManager,
        private Data  $jsonHelper,
        private AutoCoupon $autoCouponConfig,
        private CheckoutSession $checkoutSession,
        private ManagerInterface $messageManager
    ) {}

    public function afterExecute(AddCart $subject, $result)
    {
        $storeId = (int)$this->storeManager->getStore()->getId();
        $messages = $this->messageManager->getMessages()->getItemsByType(MessageInterface::TYPE_NOTICE);
        $hasError = false;
        foreach ($messages as $message) {
            if ($message->getType() === MessageInterface::TYPE_ERROR ||
                $message->getType() === MessageInterface::TYPE_WARNING ||
                $message->getType() === MessageInterface::TYPE_NOTICE ) {
                $hasError = true;
                break;
            }
        }

        $lastAddedProduct = $this->checkoutSession->getLastAddedProductId();
        $productsList = $this->autoCouponConfig->getProductsList($storeId);
        $exist = false;
        if(is_array($productsList) && in_array($lastAddedProduct, $productsList)){
            $exist = true;
        }
        $backUrl = $this->autoCouponConfig->getCustomUrl($storeId);
        if($backUrl && $exist && !$hasError){
            $result1['backUrl'] = $backUrl;
            if ($result instanceof  ResponseInterface) {
                return $result->representJson(
                    $this->jsonHelper->jsonEncode($result1)
                );
            }
        }
        return $result;
    }
}
