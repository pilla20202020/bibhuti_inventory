<?php

namespace App\Modules\Models\Province;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    use HasFactory;
    protected $fillable = [
        'province_name',
        'country_id',
        'status',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class);
    }

    public static function getProvinces()
    {
        return self::select('id','province_name')->where('status','Active')->get();
    }

    public static function getProvincesByCountryId($country_id)
    {
        return self::select('id','province_name')->where('status','Active')->where('country_id',$country_id)->get();
    }
}
