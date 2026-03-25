<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class PaymentStatus extends Model
{
    protected $table = 'payment_statuses';
    protected $guarded = ['id'];

    const PENDING = 1;
    const PAID = 2;
    const REFUNDED = 3;
    const DISPUTED = 4;

}
