<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_no',
        'customer_email',
        'date',
        'due_date',
        'subtotal',
        'discount',
        'tax',
        'total',
    ];

    public function invoiceDetails(): HasMany
    {
        return $this->hasMany(InvoiceDetails::class,'invoice_id');
    }
}
