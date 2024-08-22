<?php
declare(strict_types=1);
namespace ArmMage\AutoCouponApply\Model\Config;

use Magento\Catalog\Model\ResourceModel\Product\CollectionFactory;
use Magento\Framework\Data\OptionSourceInterface;

/**
 * ProductList class is for products multiselect in configuration
 */
class ProductList implements OptionSourceInterface
{
    public function __construct(
        private CollectionFactory $productCollectionFactory
    ) {}

    /**
     * Retrieve all products options array
     *
     * @return array
     */
    public function toOptionArray()
    {
        $products = $this->productCollectionFactory->create();
        $products
            ->addAttributeToSelect("sku")
            ->addAttributeToSelect('name');

        $options = [];
        foreach ($products as $product) {
            $options[] = [
                'value' => $product->getId(),
                'label' => $product->getName().' ( '. $product->getSku().' )',
            ];
        }

        return $options;
    }
}
