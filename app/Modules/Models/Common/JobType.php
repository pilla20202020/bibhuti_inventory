<?php

namespace App\Modules\Models\Common;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Models\Category\JobCategory;

class JobType extends Model
{   
    protected $table = "job_types";
    use HasFactory;
    protected $fillable = ['category_id','job_type','description','status','created_by','updated_by'];

    public function category()
    {
        return $this->belongsTo(JobCategory::class,"category_id");
    }
}
