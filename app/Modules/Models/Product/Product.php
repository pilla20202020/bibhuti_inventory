<?php

namespace App\Modules\Models\Product;

use App\Modules\Models\Supplier\Supplier;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    use Sluggable;

    protected $path = 'uploads/product';

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable= [
        'name','productcode', 'slug', 'description', 'branch_id','price', 'category_id','supplier_id','unit_id', 'keywords','image', 'visibility', 'image','status', 'availability','is_deleted',
        'deleted_at','created_by','last_updated_by','last_deleted_by'
    ];

    protected $appends = [
        'visibility_text', 'status_text', 'availability_text', 'thumbnail_path', 'image_path'
    ];

    function getVisibilityTextAttribute(){
        return ucwords(str_replace('_', ' ', $this->visibility));
    }

    function getStatusTextAttribute(){
        return ucwords(str_replace('_', ' ', $this->status));
    }

    function getAvailabilityTextAttribute(){
        return ucwords(str_replace('_', ' ', $this->availability));
    }

    function creator(){
        return $this->belongsTo(User::class,'created_by');
    }

    function getImagePathAttribute(){
        return $this->path.'/'. $this->image;
    }

    function getThumbnailPathAttribute(){
        return $this->path.'/thumb/'. $this->image;
    }

    public function brand(){
        return $this->belongsTo('App\Modules\Models\Brand\Brand', 'brand_id','id');
    }

    public function category(){
        return $this->belongsTo('App\Modules\Models\Category\Category', 'category_id','id');
    }

    public function unit(){
        return $this->belongsTo('App\Modules\Models\Unit\Unit', 'unit_id','id');
    }

    public function supplier(){
        return $this->belongsTo(Supplier::class);
    }

    public function price(){
        return $this->hasMany('App\Modules\Models\Price\Price');
    }
}
