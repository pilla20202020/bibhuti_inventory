<?php

namespace App\Modules\Models\PurchaseOrder;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Modules\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;

class PurchaseOrder extends Model
{
    use HasFactory;

    use Sluggable;

    protected $path = 'uploads/purchaseorder';

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable= [
        'requested_stock','invoice','buying_price','buying_date','product_id','image','description', 'status', 'availability','visibility','is_deleted','is_default',
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

    public function product(){
        return $this->belongsTo('App\Modules\Models\Product\Product', 'product_id','id');
    }
}
