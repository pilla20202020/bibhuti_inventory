<?php

namespace App\Modules\Models\Country;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;

    protected $fillable = [
        'country_name',
        'phone_code',
        'country_code',
        'status'
    ];

    public function provinces()
    {
        return $this->hasMany(Province::class);
    }

    public static function getCountries()
    {
        return self::select('id','country_name')->where('status','Active')->get();
    }
}
