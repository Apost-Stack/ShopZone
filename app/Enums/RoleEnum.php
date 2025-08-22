<?php
namespace App\Enums;


enum RoleEnum: string
{
    case CUSTOMER = 'customer';
    case ADMIN = 'admin';
    case EMPLOYEE = 'employee';
}