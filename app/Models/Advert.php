<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;

class Advert extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'data',
    ];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }

    public function pages()
    {
        return $this->belongsToMany(User::class, 'page_advert', 'advert_id', 'page_id');
    }
}
