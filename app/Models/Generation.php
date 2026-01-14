<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Generation extends Model
{
    use HasFactory;

    protected $fillable = [
        'family_branch_id',
        'generation_number',
        'generation_name',
        'description',
    ];

    public function branch()
    {
        return $this->belongsTo(FamilyBranch::class, 'family_branch_id');
    }

    public function people()
    {
        return $this->hasMany(Person::class, 'generation_id');
    }
}
