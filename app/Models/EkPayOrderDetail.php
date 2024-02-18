<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EkPayOrderDetail extends Model
{
    use HasFactory;
    protected $connection = 'mysql';
    protected $fillable = [
        "id",
        "user_id",
        "tran_amount",
        "tran_data",
        "transactionid",
        "pre_transactionid",
        "val_id",
        "order_number",
        "amount",
        "share",
        "muktopaath",
        "payment_method",
        "card_or_bank_number",
        "bank_info",
        "transaction_number",
        "coupons_id",
        "payment_status",
        "type",
        "discount",
        "payment_gatway",
        "order_created_at",
        "order_update_at",
        "pib_course",
        "ekpay_detail",
    ];
}
