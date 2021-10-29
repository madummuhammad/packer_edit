<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Outbound extends Model
{

    use HasFactory, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'outbounds';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'platform_id',
        'warehouse_id',
        'invoice_number',
        'total_amount',
        'courier',
        'name',
        'address',
        'kabupaten_id',
        'phone',
        'awb',
        'note',
        'dropshipper_name',
        'dropshipper_phone',
        'status_id',
    ];

}
