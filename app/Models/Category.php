<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Category
 */
class Category extends Model
{
    protected $table = 'categories';

    protected $primaryKey = 'category_id';

	public $timestamps = false;

    protected $fillable = [
        'category'
    ];

    protected $guarded = [];

        
}