<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $table = 'products';
    protected $fillable = [
        'code',
        'name',
        'category',
        'cost',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }
}