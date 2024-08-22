<?php
declare(strict_types=1);

namespace ArmMage\AutoCouponApply\Test\Unit\Model;

use Magento\Catalog\Model\Product;
use Magento\Store\Api\Data\StoreInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use ArmMage\AutoCouponApply\Model\CouponApply;
use Magento\Store\Model\StoreManagerInterface;
use Psr\Log\LoggerInterface;
use Magento\Quote\Model\Quote;
use ArmMage\AutoCouponApply\Configuration\AutoCoupon;

class CouponApplyTest extends TestCase
{
    /**
     * @var StoreManagerInterface|MockObject
     */
    private $storeManagerMock;

    /**
     * @var LoggerInterface|MockObject
     */
    private $loggerMock;

    /**
     * @var AutoCoupon|MockObject
     */
    private $autoCouponConfigMock;


    /**
     * Setup method to initialize mocks and class under test.
     */
    protected function setUp(): void
    {
        $this->storeManagerMock = $this->createMock(StoreManagerInterface::class);
        $this->loggerMock = $this->createMock(LoggerInterface::class);
        $this->autoCouponConfigMock = $this->createMock(AutoCoupon::class);
        $this->productMock = $this->createMock(Product::class);
    }

    /**
     * Test that a coupon is applied when eligible.
     */
    public function testAutoApplyCoupon()
    {
        $storeId = 1;

        $quoteMock = $this->getMockBuilder(Quote::class)
            ->addMethods(['getCouponCode', 'setCouponCode'])
            ->onlyMethods(['getId'])
            ->disableOriginalConstructor()
            ->getMock();

        $storeMock = $this->createMock(StoreInterface::class);
        $this->storeManagerMock->method('getStore')->willReturn($storeMock);
        $storeMock->method('getId')->willReturn($storeId);
        $couponApply = new CouponApply(
            $this->storeManagerMock,
            $this->loggerMock,
            $this->autoCouponConfigMock
        );

        $couponApply->autoApplyCoupon($quoteMock);
    }
}
