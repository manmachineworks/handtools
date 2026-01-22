<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProcessedTransaction extends Model
{
    use HasFactory;

    protected $table = 'processed_transactions';

    protected $fillable = [
        'transaction_id',
    ];
}
