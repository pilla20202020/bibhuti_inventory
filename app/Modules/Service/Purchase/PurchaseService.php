<?php

namespace App\Modules\Service\Purchase;

use App\Modules\Models\Purchase\Purchase;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PurchaseService extends Service
{
    protected $purchase;

    public function __construct(Purchase $purchase)
    {
        $this->purchase = $purchase;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->purchase->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('supplier',function(Purchase $purchase) {
                if($purchase->supplier->name) {
                    return $purchase->supplier->name;
                }
            })
            ->editColumn('category',function(Purchase $purchase) {
                if($purchase->category->name) {
                    return $purchase->category->name;
                }
            })
            ->editColumn('product',function(Purchase $purchase) {
                if($purchase->product->name) {
                    return $purchase->product->name;
                }
            })
            ->editColumn('visibility',function(Purchase $purchase) {
                if($purchase->visibility == 'visible'){
                    return '<span class="badge badge-info">Visible</span>';
                } else {
                    return '<span class="badge badge-danger">In-Visible</span>';
                }
            })
            ->editColumn('availability',function(Purchase $purchase) {
                if($purchase->availability == 'available'){
                    return '<span class="badge badge-info">Available</span>';
                } else {
                    return '<span class="badge badge-danger">Un-Available</span>';
                }
            })
            ->editColumn('status',function(Purchase $purchase) {
                if($purchase->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(Purchase $purchase) {
                if(isset($purchase->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($purchase->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(Purchase $purchase) {
                $editRoute =  route('purchase.edit',$purchase->id);
                $deleteRoute =  route('purchase.destroy',$purchase->id);
                return getTableHtml($purchase,'actions',$editRoute,$deleteRoute);
                return getTableHtml($purchase,'image');
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
            $purchase = $this->purchase->create($data);
            return $purchase;

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

        return $this->purchase->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->purchase->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($purchaseId)
    {
        try {
            return $this->purchase->whereIsDeleted('no')->find($purchaseId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($purchaseId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subpurchase'] = (isset($data['has_subpurchase']) ?  $data['has_subpurchase'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $purchase= $this->purchase->find($purchaseId);
            $purchase = $purchase->update($data);
            //$this->logger->info(' created successfully', $data);

            return $purchase;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStock($purchaseId, $updatepurchase)
    {
        try {
            $data['available_stock'] = $updatepurchase;
            $purchase= $this->purchase->find($purchaseId);
            $purchase = $purchase->update($data);


        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStockWhilePurchase($purchaseId, $updatepurchase)
    {
        try {
            $purchase= $this->purchase->find($purchaseId);
            $data['available_stock'] = $updatepurchase + $purchase['available_stock'];
            $purchase = $purchase->update($data);


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
    public function delete($purchaseId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $purchase = $this->purchase->find($purchaseId);
            $data['is_deleted']='yes';
            return $purchase = $purchase->update($data);

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
        return $this->purchase->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->purchase->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getByProductId($id){
        return $this->purchase->whereIsDeleted('no')->whereProductId($id)->first();
    }

    public function getByProductForUpdate($purchase){
        $purchasecreateorupdate = $this->purchase->firstOrNew(['product_id' => $purchase['product_id']]);
        $purchasecreateorupdate->available_stock = ($purchasecreateorupdate->available_stock + $purchase['available_stock']);
        return $purchasecreateorupdate->save();
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

    public function updateImage($purchaseId, array $data)
    {
        try {
            $purchase = $this->purchase->find($purchaseId);
            $purchase = $purchase->update($data);

            return $purchase;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
