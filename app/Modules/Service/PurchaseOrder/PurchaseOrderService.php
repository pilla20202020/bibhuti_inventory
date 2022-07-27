<?php

namespace App\Modules\Service\PurchaseOrder;

use App\Modules\Models\PurchaseOrder\PurchaseOrder;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PurchaseOrderService extends Service
{
    protected $purchaseorder;

    public function __construct(PurchaseOrder $purchaseorder)
    {
        $this->purchaseorder = $purchaseorder;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = "SELECT pe.id,pe.requested_stock,pe.invoice,pe.buying_price,pe.buying_date,pe.is_approved,p.name as product_name,s.name as supplier_name,c.name as category_name FROM purchase_orders pe INNER JOIN products p ON pe.product_id = p.id INNER JOIN suppliers s ON p.supplier_id = s.id INNER JOIN categories c ON p.category_id = c.id";
        $query = DB::select($query);
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('is_approved',function($query) {
                if($query->is_approved == 'approved'){
                    return '<span class="badge badge-info">Approved</span>';
                } else {
                    return '<span class="badge badge-danger">UnApproved</span>';
                }
            })
            ->editcolumn('actions',function($query) {
                $editRoute =  route('purchaseorder.edit',$query->id);
                $deleteRoute =  route('purchaseorder.destroy',$query->id);
                return getTableHtml($query,'actions',$editRoute,$deleteRoute);
            })->rawColumns(['is_approved','actions'])->make(true);
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
            $purchaseorder = $this->purchaseorder->create($data);
            return $purchaseorder;

        } catch (Exception $e) {
            return null;
        }
    }


    /**
     * Paginate all Purchase
     *
     * @param array $filter
     * @return Collection
     */
    public function paginate(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->purchaseorder->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all Purchase
     *
     * @return Collection
     */
    public function all()
    {
        return $this->purchaseorder->whereIsDeleted('no')->all();
    }

    /**
     * Paginate all UnApprvoed Purchase
     *
     * @param array $filter
     * @return Collection
     */
    public function getOnlyUnApproved(array $filter = [])
    {
        $filter['limit'] = 25;

        return $this->purchaseorder->orderBy('id','DESC')->whereIsDeleted('no')->whereIsApproved('unapproved')->paginate($filter['limit']);
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($purchaseorderId)
    {
        try {
            return $this->purchaseorder->whereIsDeleted('no')->find($purchaseorderId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($purchaseorderId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subpurchase'] = (isset($data['has_subpurchase']) ?  $data['has_subpurchase'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $purchaseorder= $this->purchaseorder->find($purchaseorderId);
            $purchaseorder = $purchaseorder->update($data);
            //$this->logger->info(' created successfully', $data);

            return $purchaseorder;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStock($purchaseorderId, $updatepurchase)
    {
        try {
            $data['available_stock'] = $updatepurchase;
            $purchaseorder= $this->purchase->find($purchaseorderId);
            $purchaseorder = $purchaseorder->update($data);


        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStockWhilePurchase($purchaseorderId, $updatepurchase)
    {
        try {
            $purchaseorder= $this->purchase->find($purchaseorderId);
            $data['available_stock'] = $updatepurchase + $purchaseorder['available_stock'];
            $purchaseorder = $purchaseorder->update($data);


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
    public function delete($purchaseorderId)
    {
        try {
            $purchaseorder = $this->purchaseorder->find($purchaseorderId);
            return $purchaseorder = $purchaseorder->delete();

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
        return $this->purchaseorder->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->purchaseorder->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getByProductId($id){
        return $this->purchaseorder->whereIsApproved('approved')->whereProductId($id)->get();
    }

    public function getByProductForUpdate($purchaseorder){
        $purchaseordercreateorupdate = $this->purchaseorder->firstOrNew(['product_id' => $purchaseorder['product_id']]);
        $purchaseordercreateorupdate->available_stock = ($purchaseordercreateorupdate->available_stock + $purchaseorder['available_stock']);
        return $purchaseordercreateorupdate->save();
    }


    function uploadFile($file)
    {
        if (!empty($file)) {
            $this->uploadPath = 'uploads/purchase';
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

    public function updateImage($purchaseorderId, array $data)
    {
        try {
            $purchaseorder = $this->purchaseorder->find($purchaseorderId);
            $purchaseorder = $purchaseorder->update($data);

            return $purchaseorder;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
