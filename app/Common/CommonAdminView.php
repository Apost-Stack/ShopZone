<?php

namespace App\Common;

class CommonAdminView
{

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