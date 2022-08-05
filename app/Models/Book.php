<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Mockery\Matcher\Any;
use Ramsey\Uuid\Uuid;
use App\Models\Payment;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Book extends Model
{
    use HasFactory;

    protected $fillable = [
        'uuid',
        'name',
        'price',
        'user_id',
        'series_id',
        'cover_photo',
    ];

    protected $with = ['buyers', 'infopage'];

    public static function boot()
    {
        parent::boot();
        self::creating(function ($model) {
            $model->uuid = (string) Uuid::uuid4();
        });
    }

    public function pages(): HasMany
    {
        return $this->hasMany(Page::class)->orderBy('position', 'asc');
    }

    public function buyers()
    {
        return  $this->hasMany(Payment::class);
    }

    public function infopage(): HasOne
    {
        return $this->hasOne(InformationPage::class);
    }
}
