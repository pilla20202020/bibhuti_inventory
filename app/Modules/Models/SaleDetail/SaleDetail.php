<?php

namespace App\Modules\Models\SaleDetail;

use App\Modules\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleDetail extends Model
{
    use HasFactory;
    
    use Sluggable;

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable= [
        'product_id','sale_id','quantity','price','discount','totalprice','status', 'availability','visibility','is_deleted','is_default',
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

    public function sale(){
        return $this->belongsTo('App\Modules\Models\Sale\Sale', 'sale_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Modules\Models\Product\Product', 'product_id','id');
    }

}
