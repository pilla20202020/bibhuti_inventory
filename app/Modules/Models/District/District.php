<?php

namespace App\Modules\Models\District;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class District extends Model
{
    use HasFactory;
    protected $fillable = [
        'district_name',
        'country_id',
        'province_id',
        'status',
    ];
    
    public static function getDistricts()
    {
        return self::select('id', 'district_name')->where('status', 'Active')->get();
    }

    public static function getDistrictsByProvinceId($province_id)
    {
        return self::select('id', 'district_name')->where('status', 'Active')->where('province_id',$province_id)->get();
    }

    public static function getPermDistrictsByProvinceId($province_id)
    {
        return self::select('id', 'district_name')->where('status', 'Active')->where('province_id',$province_id)->get();
    }

    public static function getTempDistrictsByProvinceId($province_id)
    {
        return self::select('id', 'district_name')->where('status', 'Active')->where('province_id',$province_id)->get();
    }
}
