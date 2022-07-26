@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
          href="{{ asset('resources/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862')}}"/>
@endsection
@csrf
<div class="row">
    <div class="col-sm-12">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="product_id" class="col-form-label pt-0">Product Order List</label>
                                <div class="">
                                    <select data-placeholder="Select Product Order List" class="tail-select w-full form-control product_order_class">
                                        <option value="" disabled selected> Select Product Order List</option>
                                        @foreach($purchase_order as $product_data)
                                            <option value="{{$product_data->id}}"  @if(isset($category_search)) @if($category_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->invoice)}}</option>
                                        @endforeach
                                        <option value="new"> Add New Product Entry</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>


                    <hr>
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <a class="btn btn-light waves-effect ml-1" href="{{ route('purchase_entry.index') }}">
                                    <i class="md md-arrow-back"></i>
                                    Back
                                </a>
                                <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- From Purchase Order Modal --}}
<div class="modal fade purchase_entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-self-center mt-0 text-center" id="exampleModalLabel">Create a Purchase Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('purchase_entry.store')}}" method="POST" class="form form-validate floating-label">
                    @csrf
                    <div class="from_purchase_order">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="product_id" class="col-form-label pt-0">Product</label>
                                    <div class="">
                                        <input class="form-control purchase_product_name" readonly>
                                        <input type="hidden" class="form-control purchase_product_id" name="product_id" readonly>
                                        <input type="hidden" class="form-control purchase_product_order_id" name="product_order_id" readonly>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="available_stock" class="col-form-label pt-0">Recieved Quantity</label>
                                    <div class="">
                                        <input class="form-control purchase_quantity" type="number" name="available_stock" value="{{ old('available_stock', isset($purchase->available_stock) ? $purchase->available_stock : '') }}" placeholder="Enter Quantity">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                    <div class="">
                                        <input class="form-control purchase_buying" type="number" name="buying_price" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                    <div class="">
                                        <input class="form-control purchase_date" type="date" name="buying_date" >
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="defective_stock" class="col-form-label pt-0">Defective Quntity</label>
                                    <div class="">
                                        <input class="form-control" type="number" name="defective_stock">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <hr>
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

{{-- New Purchase Order Modal --}}
<div class="modal fade new_purchase_entry" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title align-self-center mt-0 text-center" id="exampleModalLabel">Create a Purchase Entry</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{route('purchase_entry.store')}}" method="POST" class="form form-validate floating-label">
                    @csrf
                    <div class="add_new_product">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="product_id" class="col-form-label pt-0">Product</label>
                                    <div class="">
                                        <select data-placeholder="Select Product" class="tail-select w-full form-control purchase_class product_class" name="product_id">
                                            <option value="" disabled selected> Select Product</option>
                                            @foreach($product as $product_data)
                                                <option value="{{$product_data->id}}"  @if(isset($product_search)) @if($product_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="available_stock" class="col-form-label pt-0">Recieved Quantity</label>
                                    <div class="">
                                        <input class="form-control" type="number" name="available_stock" placeholder="Enter Quantity">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                    <div class="">
                                        <input class="form-control" type="number" name="buying_price" placeholder="Enter Buying Price">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                    <div class="">
                                        <input class="form-control" type="date" name="buying_date" placeholder="Enter Buying Price">
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-3">
                                <div class="form-group ">
                                    <label for="defective_stock" class="col-form-label pt-0">Defective Quntity</label>
                                    <div class="">
                                        <input class="form-control" type="number" name="defective_stock" placeholder="Enter Defective Quantity">
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- <div class="row">
                            <h5 class="card-title">Upload Images</h5>
                            <p class="card-title-desc">You can add a default value</p>
                            @if(isset($purchase->image))
                            @if(!empty($purchase->image))
                                <input type="file" name="image" class="dropify"
                                    data-default-file="{{ asset($purchase->image_path) }}"/>
                            @else
                                <input type="file" name="image" class="dropify"/>
                            @endif
                            @else
                                <input type="file" name="image" class="dropify"/>
                            @endif
                        </div> --}}

                    </div>

                    <hr>
                    <div class="row mt-2 justify-content-center">
                        <div class="form-group">
                            <div>
                                <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light" value="Submit">
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div>

@section('page-specific-scripts')
    <script src="{{asset('resources/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });

        $('.product_order_class').change(function(e){
            e.preventDefault();
            var product_order = $(this).val();
            if(product_order != "new") {
                var body;
                $.ajax({
                    url: "{{route('purchase_entry.getproductorder')}}",
                    type: "get",
                    data: {
                        product_order: product_order,
                    },
                    success:function(response){
                        if(typeof(response) != "object"){
                            response = JSON.parse(response);
                        }

                        if(response.data){
                            $('.purchase_product_name').val(response.data.product_name);
                            $('.purchase_product_order_id').val(response.data.id);
                            $('.purchase_product_id').val(response.data.product_id);
                            $('.purchase_quantity').val(response.data.requested_stock);
                            $('.purchase_buying').val(response.data.buying_price);
                            $('.purchase_date').val(response.data.buying_date);
                            $('.purchase_entry').modal('show');

                        }
                    }
                })
            } else {
                $('.new_purchase_entry').modal('show');
            }


        })
    </script>
@endsection
