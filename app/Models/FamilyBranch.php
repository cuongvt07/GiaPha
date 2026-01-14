<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FamilyBranch extends Model
{
    use HasFactory;

    protected $fillable = [
        'root_ancestor_id',
        'parent_branch_id',
        'branch_name',
        'branch_location',
        'description',
        'branch_order',
    ];

    public function rootAncestor()
    {
        return $this->belongsTo(Person::class, 'root_ancestor_id');
    }

    public function parentBranch()
    {
        return $this->belongsTo(FamilyBranch::class, 'parent_branch_id');
    }

    public function subBranches()
    {
        return $this->hasMany(FamilyBranch::class, 'parent_branch_id');
    }

    public function members()
    {
        return $this->hasMany(Person::class, 'family_branch_id');
    }
}
