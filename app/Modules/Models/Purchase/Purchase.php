<?php

namespace App\Modules\Models\Purchase;

use App\Modules\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    use Sluggable;

    protected $path = 'uploads/purchase';

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable= [
        'available_stock', 'defective_stock','buying_price','buying_date','category_id','supplier_id','product_id','image','description', 'status', 'availability','visibility','is_deleted','is_default',
        'deleted_at','created_by','last_updated_by','last_deleted_by'
    ];

    protected $appends = [
        'visibility_text', 'status_text', 'availability_text' , 'thumbnail_path', 'image_path'
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

    public function supplier(){
        return $this->belongsTo('App\Modules\Models\Supplier\Supplier', 'supplier_id','id');
    }

    public function category(){
        return $this->belongsTo('App\Modules\Models\Category\Category', 'category_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Modules\Models\Product\Product', 'product_id','id');
    }


}
