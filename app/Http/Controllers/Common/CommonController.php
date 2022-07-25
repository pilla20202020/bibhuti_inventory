<?php

namespace App\Http\Controllers\Common;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CommonController extends Controller
{
    public function getProvincesByCountryId(Request $request)
    {
        $provinces= getProvincesByCountryId($request->country_id);
        return response()->json(['provinces' =>$provinces],200);
    }

    public function getDistrictsByProvinceId(Request $request)
    {
        $districts= getDistrictsByProvinceId($request->province_id);
        return response()->json(['districts' =>$districts],200);
    }
}
