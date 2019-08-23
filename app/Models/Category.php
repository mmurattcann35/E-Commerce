<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use SoftDeletes;

    protected  $table   = 'categories';

    protected $guarded  = [];

    public function products(){
        return $this->belongsToMany('App\Models\Product','category_product');
    }

    public function ust_category(){
        return $this->belongsTo('App\Models\Category','ust_id')
            ->withDefault(['name' => 'Ana Kategori']);
    }
}
