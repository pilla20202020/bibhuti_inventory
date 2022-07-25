<?php

namespace App\Modules\Models\Sale;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    use HasFactory;

    use Sluggable;

    protected $path = 'uploads/sale';

    public function sluggable() : array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }

    protected $fillable= [
        'buying_stock','buying_price','invoice_no','buying_date','customer_id','image','description', 'status', 'availability','visibility','is_deleted','is_default',
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

    public function customer(){
        return $this->belongsTo('App\Modules\Models\Customer\Customer', 'customer_id','id');
    }

    public function product(){
        return $this->belongsTo('App\Modules\Models\Product\Product', 'product_id','id');
    }
}
