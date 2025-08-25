<?php

namespace App\Common;

class CommonAdminView
{

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