<?php

namespace App\Modules\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolUniversity extends Model
{
    use HasFactory;
    protected $fillable = ['s_u_name','address','description','status'];
}
