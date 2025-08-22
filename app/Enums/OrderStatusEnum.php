<?php
namespace App\Enums;

enum OrderStatusEnum: string
{
    case PAID = 'paid';
    case UNPAID = 'unpaid';
}