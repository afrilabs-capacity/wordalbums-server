<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PageAdvert extends \Illuminate\Database\Eloquent\Relations\Pivot
{
    use HasFactory;

    protected $table = 'page_advert';

    public function advert()
    {
        return $this->belongsTo('Advert');
    }
}
