<?php

namespace App\Modules\Service\Unit;

use App\Modules\Models\Unit\Unit;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class unitService extends Service
{
    protected $unit;

    public function __construct(Unit $unit)
    {
        $this->unit = $unit;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->unit->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()

            ->editColumn('status',function(unit $unit) {
                if($unit->status == 'active'){
                    return '<span class="badge badge-warning">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editcolumn('actions',function(unit $unit) {
                $editRoute =  route('unit.edit',$unit->id);
                $deleteRoute =  route('unit.destroy',$unit->id);
                return getTableHtml($unit,'actions',$editRoute,$deleteRoute);
            })->rawColumns(['status'])->make(true);
    }

    public function create(array $data)
    {
        try {
            /* $data['keywords'] = '"'.$data['keywords'].'"';*/
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['created_by']= Auth::user()->id;
            //dd($data);
            $unit = $this->unit->create($data);
            return $unit;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all User
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;
        return $this->unit->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->unit->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($unitId)
    {
        try {
            return $this->unit->whereIsDeleted('no')->find($unitId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($unitId, array $data)
    {
        try {
            $data['slug'] = Str::slug($data['name']);
            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subunit'] = (isset($data['has_subunit']) ?  $data['has_subunit'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $unit= $this->unit->find($unitId);

            $unit = $unit->update($data);
            //$this->logger->info(' created successfully', $data);

            return $unit;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    /**
     * Delete a User
     *
     * @param Id
     * @return bool
     */
    public function delete($unitId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $unit = $this->unit->find($unitId);
            $data['is_deleted']='yes';
            return $unit = $unit->update($data);

        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * write brief description
     * @param $name
     * @return mixed
     */
    public function getByName($name){
        return $this->unit->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->unit->whereIsDeleted('no')->whereSlug($slug)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/unit';
            return $fileName = $this->uploadFromAjax($file);
        }
    }

    public function __deleteImages($subCat)
    {
        try {
            if (is_file($subCat->image_path))
                unlink($subCat->image_path);

            if (is_file($subCat->thumbnail_path))
                unlink($subCat->thumbnail_path);
        } catch (\Exception $e) {

        }
    }

    public function updateImage($unitId, array $data)
    {
        try {
            $unit = $this->unit->find($unitId);
            $unit = $unit->update($data);

            return $unit;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
