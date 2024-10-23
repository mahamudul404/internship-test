<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        'product_id',
        'feature_name',
        'feature_description',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
