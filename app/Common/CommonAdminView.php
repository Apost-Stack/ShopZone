<?php

namespace App\Common;

class CommonAdminView
{

    //-------------------------------------------------Customer
    public static function getCustomerListView(): string
    {
        return self::baseView().'user.customer.list';
    }
    public static function getCustomerShowView(): string
    {
        return self::baseView().'user.customer.show';
    }
    public static function getCustomerEditOrCreateView(): string
    {
        return self::baseView().'user.customer.createOrEdit';
    }
    //-----------------------------------------------------
    //-------------------------------------------------User
    public static function getUserListView(): string
    {
        return self::baseView().'user.user.list';
    }
    public static function getUserShowView(): string
    {
        return self::baseView().'user.user.show';
    }
    public static function getUserEditOrCreateView(): string
    {
        return self::baseView().'user.user.createOrEdit';
    }
    //-----------------------------------------------------
    //------------------------------------------------- Employee
    public static function getEmployeeListView(): string
    {
        return self::baseView().'user.employees.list';
    }

    public static function getEmployeeShowView(): string
    {
        return self::baseView().'user.employees.show';
    }

    public static function getEmployeeEditOrCreateView(): string
    {
        return self::baseView().'user.employees.createOrEdit';
    }
    //-------------------------------------------------------
    //------------------------------------------------- Delivery
    public static function getDeliveryListView(): string
    {
        return self::baseView(). 'action.delivery.index';
    }

    public static function getDeliveryFormView(): string
    {
        return self::baseView(). 'action.delivery.form';
    }

    public static function getDeliveryShowView(): string
    {
        return self::baseView(). 'action.delivery.show';
    }
    //--------------------------------------------------------
    //------------------------------------------------- Orders
    public static function getOrderListView(): string
    {
        return self::baseView().'action.order.index';
    }

    public static function getOrderFormView(): string
    {
        return self::baseView().'action.order.form';
    }

    public static function getOrderShowView(): string
    {
        return self::baseView().'action.order.show';
    }
    //----------------------------------------------------------
    //------------------------------------------------- Discount
    public static function getDiscountListView(): string
    {
        return self::baseView() ."sel.discounts.list";
    }
    public static function getDiscountEditOrCreateView(): string
    {
        return self::baseView() ."sel.discounts.createOrEdit";
    }

    public static function getDiscountShowView(): string
    {
        return self::baseView() ."sel.discounts.show";
    }
    //----------------------------------------------------------
    //------------------------------------------------- Product 
    public static function getProductListView(): string
    {
        return self::baseView() ."sel.product.products.list";
    }

    public static function getProductEditOrCreateView(): string
    {
        return self::baseView() ."sel.product.products.createOrEdit";
    }

    public static function getProductShowView(): string
    {
        return self::baseView() ."sel.product.products.show";
    }
    //----------------------------------------------------------
    //------------------------------------------------- Category
    public static function getCategoryListView(): string
    {
        return self::baseView() ."sel.product.category.list";
    }

    public static function getCategoryEditOrCreateView(): string
    {
        return self::baseView() ."sel.product.category.createOrEdit";
    }

    public static function getCategoryShowView(): string
    {
        return self::baseView() ."sel.product.category.show";
    }

    //----------------------------------------------------------
    // ------------------------------------------------ Province
    public static function getProvinceListView(): string
    {
        return self::baseView() ."base.province.list";
    }
    public static function getProvinceEditOrCreateView(): string
    {
        return self::baseView() ."base.province.createOrEdit";
    }
    public static function getProvinceShowView(): string
    {
        return self::baseView() ."base.province.show";
    }
    // ------------------------------------------------ End Province

    // ------------------------------------------------ Status
    public static function getStatusListView(): string
    {
        return self::baseView() ."base.status.list";
    }
    public static function getStatusEditOrCreateView(): string
    {
        return self::baseView() ."base.status.createOrEdit";
    }
    public static function getStatusShowView(): string
    {
        return self::baseView() ."base.status.show";
    }
    // ------------------------------------------------ End Status
    

    private static function baseView(): string
    {
        return "admin.";
    }
}