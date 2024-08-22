# ArmMage_AutoCouponApply module

<font color='red'>**The following is a complete README for module ArmMage_AutoCouponApply:** </font>
# ArmMage_AutoCouponApply module
The ArmMage_AutoCouponApply module enables you to apply Auto Coupon on specific products in crat.

The ArmMage_AutoCouponApply module automatically apply a coupon code to the cart and allow for a custom redirect URL on add to cart.

## Installation details

Install the extension by executing the following command:

`composer require armmage/module-autocouponapply`

OR

Download the extension and Unzip the files in app/code/ArmMage/AutoCouponApply directory

Execute the following commands respectively:

1.  php bin/magento module:enable ArmMage_AutoCouponApply

2.  php bin/magento setup:upgrade

3.  php bin/magento setup:di:compile

4.  php bin/magento cache:flush  OR Refresh the Cache under System ⇾ Cache Management


**Configuration**

1. Navigate to **ARMMAGE ⇾ AutoCoupon** and click on **ARMMAGE ⇾ Auto Coupon Apply** tab in the left panel.

![Configuration](https://i.ibb.co/WpJJrVJ/Screenshot-from-2024-08-22-01-09-27.png)

**Apply Auto Coupon Configuration**

**Module Enable**

This is module main enable/disable selct. This will decide either module is enable or disabled.

**Coupon Code**

Here you will enter the Coupon Code you want to auto apply.

**Select Products**

Here you will select products you want to auto apply coupon code. You can select multiple products from the list.

**Custom Redirect URL**

Here you can add custom url you want to redirect to, the product on add to cart.
Note(Do not add baseurl in custom url field)

## Functionalities

* The module check if the added product matches the selected products for coupon application.If a match is found, apply the specified coupon code to the cart.
* Redirect the user to a custom URL after the coupon is applied.
