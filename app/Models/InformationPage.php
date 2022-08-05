<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationPage extends Model
{
    use HasFactory;

    protected $fillable = [
        'cover_photo',
        'release_information',
        'page_start',
        'page_end',
        'position',
        'book_id',
        'donation_amount'
    ];
}
