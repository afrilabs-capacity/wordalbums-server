<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use AjCastro\EagerLoadPivotRelations\EagerLoadPivotTrait;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Ramsey\Uuid\Uuid;
use App\Models\PageAdvert;


class Page extends Model
{
    use HasFactory, EagerLoadPivotTrait;


    protected $with = ['adverts', 'visitors'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }

    protected $fillable = [
        'uuid',
        'name',
        'file',
        'book_id',
        'user_id',
        'position'
    ];

    public function adverts()
    {
        // return $this->belongsToMany(User::class, 'page_advert', 'page_id', 'advert_id');
        return  $this->belongsToMany(Advert::class, 'page_advert')->using(PageAdvert::class)
            // make sure to include the necessary foreign key in this case the `unit_id`
            ->withPivot('advert_id');
    }

    public function visitors(): HasMany
    {
        return $this->hasMany(Visitor::class, 'page_uuid', 'uuid');
    }
}
