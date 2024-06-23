<?php
namespace App\Enums;

enum VersionObjectStatus: string
{
    case ACTIVE = 'active';
    case INACTIVE = 'inactive';
    case DELETED = 'deleted';
}