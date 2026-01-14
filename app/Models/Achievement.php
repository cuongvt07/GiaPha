<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = [
        'person_id',
        'title',
        'achievement_type',
        'achievement_date',
        'description',
        'display_order',
    ];

    protected $casts = [
        'achievement_date' => 'date',
    ];

    public function person()
    {
        return $this->belongsTo(Person::class);
    }
}
