<?php

namespace App\Common;

class CommonPublicView
{
    public static function getAboutView(): string
    {
        return self::baseView().'about.about';
    }
    public static function getHomeView(): string
    {
        return self::baseView().'home.home';
    }
    private static function baseView(): string
    {
        return "public.";
    }
}