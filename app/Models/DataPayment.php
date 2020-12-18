<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataPayment extends Model
{
    use HasFactory;
    protected $table = 'data_payment';
    protected $fillable = ['payment_name'];

}
