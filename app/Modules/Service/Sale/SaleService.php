<?php

namespace App\Modules\Service\Sale;

use App\Modules\Models\Sale\Sale;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class SaleService extends Service
{
    protected $sale;

    public function __construct(Sale $sale)
    {
        $this->sale = $sale;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->sale->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('customer',function(Sale $sale) {
                if($sale->customer->name) {
                    return $sale->customer->name;
                }
            })
            ->editColumn('visibility',function(Sale $sale) {
                if($sale->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(Sale $sale) {
                if($sale->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(Sale $sale) {
                if($sale->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Sale $sale) {
                if(isset($sale->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($sale->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Sale $sale) {
                $editRoute =  route('sale.edit',$sale->id);
                $deleteRoute =  route('sale.destroy',$sale->id);
                $printRoute =  route('sale.show',$sale->id);
                return getTableHtml($sale,'actions',$editRoute,$deleteRoute,$printRoute);
                return getTableHtml($sale,'image');
            })->rawColumns(['visibility','availability','status','image'])->make(true);
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
            $sale = $this->sale->create($data);
            return $sale;

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

        return $this->sale->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->sale->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($saleId)
    {
        try {
            return $this->sale->whereIsDeleted('no')->find($saleId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($saleId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subsale'] = (isset($data['has_subsale']) ?  $data['has_subsale'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $sale= $this->sale->find($saleId);
            $sale = $sale->update($data);
            //$this->logger->info(' created successfully', $data);

            return $sale;
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
    public function delete($saleId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $sale = $this->sale->find($saleId);
            $data['is_deleted']='yes';
            return $sale = $sale->update($data);

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
        return $this->sale->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->sale->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getByProductId($id){
        return $this->purchase->whereIsDeleted('no')->whereProductId($id)->first();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/sale';
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

    public function updateImage($saleId, array $data)
    {
        try {
            $sale = $this->sale->find($saleId);
            $sale = $sale->update($data);

            return $sale;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
