<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class fileTransferModel extends Model
{
    public static function getFiles()
    {
        return request()->files();
    }
}
