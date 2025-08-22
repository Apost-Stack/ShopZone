<?php
namespace App\Enums;

enum PayementMethodEnum: string
{
    case CASH = 'cash';
    case MVOLA = 'mvola';
    case ORANGE_MONEY = 'orange_money';
    case AIRTEL_MONEY = 'airtel_money';
}