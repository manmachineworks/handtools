<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Address extends Model
{
    use HasFactory;

    // Define the table name if it's not the plural form of the model name
    protected $table = 'addresses';

    // Specify the primary key if it's not 'id'
    protected $primaryKey = 'id';

    // Specify if the primary key is not auto-incrementing
    public $incrementing = true;

    // Specify if the primary key is non-numeric
    protected $keyType = 'int';

    // Specify the attributes that are mass assignable
    protected $fillable = [
        'user_id',
        'contact',
        'country',
        'first_name',
        'last_name',
        'address',
        'apartment',
        'city',
        'pin_code',
        'phone',
        'save_info',
        'address_id',
        'state',
    ];

    // Define the relationship with the User model
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
