<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invoice extends Model
{
    use HasFactory;
    
    protected $fillable = ['total','discount','vat','user_id','payable','customer_id'];
    function customer():BelongsTo{
        return $this->belongsTo(Customer::class);
    }
    public function invoice()
    {
        return $this->hasOne(InvoiceProduct::class);
    }
    

}
