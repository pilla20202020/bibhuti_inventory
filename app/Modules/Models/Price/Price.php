<?php

namespace App\Modules\Models\Price;

use App\Modules\Models\User;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Price extends Model
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
        'name', 'slug', 'value', 'product_id','is_default', 'status', 'availability','is_deleted','is_default',
        'deleted_at','created_by','last_updated_by','last_deleted_by'
    ];

    protected $appends = [
        'visibility_text', 'status_text', 'availability_text'
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

    public function product(){
        return $this->belongsTo('App\Modules\Models\Product\Product', 'product_id','id');
    }

}
