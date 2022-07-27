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
                                <label for="product_id" class="col-form-label pt-0">Product</label>
                                <div class="">
                                    <input class="form-control purchase_product_name" readonly value={{$purchase_entry->product->name}}>

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="available_stock" class="col-form-label pt-0">Available Quantity</label>
                                <div class="">
                                    <input class="form-control" type="number" name="available_stock" placeholder="Enter Quantity" value={{$purchase_entry->available_stock}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="defective_stock" class="col-form-label pt-0">Defective Quntity</label>
                                <div class="">
                                    <input class="form-control" type="number" name="defective_stock" placeholder="Enter Defective Quantity" value={{$purchase_entry->defective_stock}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_price" class="col-form-label pt-0">Buying Price</label>
                                <div class="">
                                    <input class="form-control" type="number" name="buying_price" placeholder="Enter Buying Price" value={{$purchase_entry->buying_price}}>
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Buying Date</label>
                                <div class="">
                                    <input class="form-control" type="date" name="buying_date" placeholder="Enter Buying Date" value={{$purchase_entry->buying_date}}>
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
