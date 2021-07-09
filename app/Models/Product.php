<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Product extends Model
{
    use HasFactory;
    protected $table = "products";

    protected $appends = [
        'imagePicture'
    ];
    protected $fillable = [
        'name',
        'quantity',
        'sku',
        'price',
        'image',
        'description',
        'content',
        'category_id'
    ];
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function getPriceAttribute($value)
    {
        return number_format($value);
    }
    public function getImagePictureAttribute()
    {
        return asset(Storage::url($this->image));

    }
}
