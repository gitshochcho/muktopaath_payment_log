<?php

namespace App\Models\Myaccount;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    use HasFactory;
    protected $connection = 'mysql_account';
    protected $table = 'muktopaath_v3_myaccount.users';
}
