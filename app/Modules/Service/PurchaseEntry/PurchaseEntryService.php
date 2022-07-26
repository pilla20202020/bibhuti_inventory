<?php

namespace App\Modules\Service\PurchaseEntry;

use App\Modules\Models\PurchaseEntry\PurchaseEntry;
use App\Modules\Service\Service;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PurchaseEntryService extends Service
{
    protected $purchase_entry_entry;

    public function __construct(PurchaseEntry $purchase_entry_entry)
    {
        $this->purchase_entry = $purchase_entry_entry;

    }


    /*For DataTable*/
    public function getAllData()

    {
        $query = $this->purchase_entry->whereIsDeleted('no');
        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('supplier',function(PurchaseEntry $purchase_entry) {
                if($purchase_entry->product->supplier->name) {
                    return $purchase_entry->product->supplier->name;
                }
            })
            ->editColumn('category',function(PurchaseEntry $purchase_entry) {
                if($purchase_entry->product->category->name) {
                    return $purchase_entry->product->category->name;
                }
            })
            ->editColumn('product',function(PurchaseEntry $purchase_entry) {
                if($purchase_entry->product->name) {
                    return $purchase_entry->product->name;
                }
            })
            ->editColumn('status',function(PurchaseEntry $purchase_entry) {
                if($purchase_entry->status == 'active'){
                    return '<span class="badge badge-info">Active</span>';
                } else {
                    return '<span class="badge badge-danger">In-Active</span>';
                }
            })
            ->editColumn('image',function(PurchaseEntry $purchase_entry) {
                if(isset($purchase_entry->image_path)){
                    return '<img src="http://127.0.0.1:8000/'.($purchase_entry->image_path).'" width="100px">';
                } else {
                    ;
                }
            })
            ->editcolumn('actions',function(PurchaseEntry $purchase_entry) {
                $editRoute =  route('purchase_entry.edit',$purchase_entry->id);
                $deleteRoute =  route('purchase_entry.destroy',$purchase_entry->id);
                return getTableHtml($purchase_entry,'actions',$editRoute,$deleteRoute);
                return getTableHtml($purchase_entry,'image');
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
            $purchase_entry = $this->purchase_entry->create($data);
            return $purchase_entry;

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

        return $this->purchase_entry->orderBy('id','DESC')->whereIsDeleted('no')->paginate($filter['limit']);
    }

    /**
     * Get all User
     *
     * @return Collection
     */
    public function all()
    {
        return $this->purchase_entry->whereIsDeleted('no')->all();
    }

    /**
     * Get all users with supervisor type
     *
     * @return Collection
     */


    public function find($purchase_entryId)
    {
        try {
            return $this->purchase_entry->whereIsDeleted('no')->find($purchase_entryId);
        } catch (Exception $e) {
            return null;
        }
    }


    public function update($purchase_entryId, array $data)
    {
        try {

            $data['visibility'] = (isset($data['visibility']) ?  $data['visibility'] : '')=='on' ? 'visible' : 'invisible';
            $data['status'] = (isset($data['status']) ?  $data['status'] : '')=='on' ? 'active' : 'in_active';
            $data['availability'] = (isset($data['availability']) ?  $data['availability'] : '')=='on' ? 'available' : 'not_available';
            $data['has_subpurchase'] = (isset($data['has_subpurchase']) ?  $data['has_subpurchase'] : '')=='on' ? 'yes' : 'no';
            $data['last_updated_by']= Auth::user()->id;
            $purchase_entry= $this->purchase->find($purchase_entryId);
            $purchase_entry = $purchase_entry->update($data);
            //$this->logger->info(' created successfully', $data);

            return $purchase_entry;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStock($purchase_entryId, $updatepurchase)
    {
        try {
            $data['available_stock'] = $updatepurchase;
            $purchase_entry= $this->purchase_entry->find($purchase_entryId);
            $purchase_entry = $purchase_entry->update($data);


        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }

    public function updateStockWhilePurchase($purchase_entryId, $updatepurchase, $defective_stock = null)
    {
        try {
            $purchase_entry= $this->purchase_entry->find($purchase_entryId);
            $data['available_stock'] = $updatepurchase + $purchase_entry['available_stock'];
            $data['defective_stock'] = $defective_stock + $purchase_entry['defective_stock'];
            $purchase_entry = $purchase_entry->update($data);


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
    public function delete($purchase_entryId)
    {
        try {

            $data['last_deleted_by']= Auth::user()->id;
            $data['deleted_at']= Carbon::now();
            $purchase_entry = $this->purchase->find($purchase_entryId);
            $data['is_deleted']='yes';
            return $purchase_entry = $purchase_entry->update($data);

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
        return $this->purchase_entry->whereIsDeleted('no')->whereName($name);
    }

    public function getBySlug($slug){
        return $this->purchase_entry->whereIsDeleted('no')->whereSlug($slug)->first();
    }

    public function getByProductId($id){
        return $this->purchase_entry->whereIsDeleted('no')->whereProductId($id)->first();
    }

    public function getByProductForUpdate($purchase_entry){
        $purchase_entrycreateorupdate = $this->purchase_entry->firstOrNew(['product_id' => $purchase_entry['product_id']]);
        $purchase_entrycreateorupdate->available_stock = ($purchase_entrycreateorupdate->available_stock + $purchase_entry['available_stock']);
        return $purchase_entrycreateorupdate->save();
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

    public function updateImage($purchase_entryId, array $data)
    {
        try {
            $purchase_entry = $this->purchase->find($purchase_entryId);
            $purchase_entry = $purchase_entry->update($data);

            return $purchase_entry;
        } catch (Exception $e) {
            //$this->logger->error($e->getMessage());
            return false;
        }
    }
}
