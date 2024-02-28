<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'slug', 'category_id', 'subcategory_id', 'buy_price', 'price', 'sku', 'description', 'image', 'user_id'];

    function setTitleAttributes($title)
    {
        $this->attributes['title'] = $title;
        $this->attributes['slug'] = Str::slug($title);
    }

    function author()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    function Category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    function Subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }

    // Book.php
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_book_favorite', 'product_id', 'user_id');
    }
}
