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
                                <label for="customer_id" class="col-form-label pt-0">Customer</label>
                                <div class="">
                                    <select data-placeholder="Select Supplier" class="tail-select w-full form-control" name="customer_id">
                                        @foreach($customer as $customer_data)
                                            <option value="{{$customer_data->id}}"  @if(isset($supplier_search)) @if($supplier_search->id==$customer_data->id) selected @endif @endif>{{ucfirst($customer_data->name)}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>


                    </div>

                    <div class="row">

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Invoice Number</label>
                                <div class="">
                                    <input class="form-control" type="number" required name="invoice_no" value="{{ old('invoice_no', isset($purchase->invoice_no) ? $purchase->invoice_no : '') }}" placeholder="Enter Invoice Number">
                                </div>
                            </div>
                        </div>

                        <div class="col-sm-6">
                            <div class="form-group ">
                                <label for="buying_date" class="col-form-label pt-0">Invoice Date</label>
                                <div class="">
                                    <input class="form-control" type="date" required name="buying_date" value="{{ old('buying_date', isset($purchase->buying_date) ? $purchase->buying_date : '') }}" placeholder="Enter Buying Price">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" name="sub_total" id="" value="">
                    </div>


                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead>
                            <tr>
                                {{-- <th width="16.66667%">Category Name</th> --}}
                                <th width="16.66667%">Product</th>
                                <th width="16.66667%">Qty</th>
                                <th width="16.66667%">Price</th>
                                <th width="16.66667%">Discount</th>
                                <th>Total</th>
                            </tr>
                            </thead>
                        </table>
                        {{-- <div class="repeater-default col-md-12 mt-1">
                            <div data-repeater-list="sale">
                                <div data-repeater-item="">
                                    <div class="form-group row d-flex align-items-end">
                                        <div class="col-sm-2">
                                            <select data-placeholder="Select Product" class="js-example-basic-single product_id" name="product_id" id="product_id">
                                                @foreach($product as $product_data)
                                                    <option value="{{$product_data->id}}"  @if(isset($category_search)) @if($category_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                                @endforeach
                                            </select>
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="number" name="quantity" class="form-control quantity">
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="number" name="price" class="form-control price">
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" name="discount" class="form-control">
                                        </div>

                                        <div class="col-sm-2">
                                            <input type="text" name="totalprice" class="form-control totalprice">
                                        </div>

                                        <div class="col-sm-1">
                                            <span data-repeater-delete="" class="btn btn-danger btn-sm">
                                                <i class="fa fa-trash"></i>
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="form-group mb-2 row">
                                <div class="col-sm-12">
                                    <span data-repeater-create="" class="btn btn-light mr-1" id="repeater-button">
                                        <span class="fa fa-plus mr-1"></span> Add Product
                                    </span>
                                </div>
                            </div>
                        </div> --}}
                    </div>

                        <div class="form-group row mt-2" id="my_package_id">
                            <div class="col-md-2">
                                <select data-placeholder="Select Product" class="js-example-basic-single product_id" name="product_id[]" id="product_id">
                                    @foreach($product as $product_data)
                                        <option value="{{$product_data->id}}"  @if(isset($category_search)) @if($category_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2">
                                <input class="form-control quantity" id="quantity" name="quantity[]" type="number">
                                <p class="quntitytitle"></p>
                            </div>

                            <div class="col-md-2 thisprice">
                                <input type="number" name="price[]" class="form-control price">
                            </div>

                            <div class="col-md-2">
                                <input type="number" name="discount[]" class="form-control">
                            </div>

                            <div class="col-md-2">
                                <input type="number" name="totalprice[]" class="form-control totalprice">
                            </div>
                        </div>
                        <input type="hidden" id="temp" value="0" name="temp">
                        <div class="row g-3 mt-2">
                            <div class="col-md-2">
                                <input id="additemrow" type="button" class="btn btn-round btn-outline-primary mr-1" value="Add Row">
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6">
                            <div class="card mb-1">
                                <div class="card-body">
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
                                </div>
                            </div>
                        </div>
                        <div class="card col-md-6" >
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group d-flex">
                                            <span class="pl-1">Status</span>
                                            <input type="checkbox" id="switch1" switch="none" name="status" {{ old('status', isset($purchase->status) ? $purchase->status : '')=='active' ? 'checked':'' }}/>
                                            <label for="switch1" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                        <div class="form-group d-flex" >
                                            <span class="pl-1">Availability</span>
                                            <input type="checkbox" id="switch2" switch="none" name="availability" {{ old('availability', isset($purchase->availability) ? $purchase->availability : '')=='available' ? 'checked':'' }}/>
                                            <label for="switch2" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                        <div class="form-group d-flex">
                                            <span class="pl-1" >Featured</span>
                                            <input type="checkbox" id="switch3" switch="none" name="visibility" {{ old('visibility', isset($purchase->visibility) ? $purchase->visibility : '')=='visible' ? 'checked':'' }}/>
                                            <label for="switch3" class="ml-auto" data-on-label="On" data-off-label="Off"></label>
                                        </div>
                                    </div>
                                </div>
                                <hr>
                                <div class="row mt-2 justify-content-center">
                                    <div class="form-group">
                                        <div>
                                            <a class="btn btn-light waves-effect ml-1" href="{{ route('sale.index') }}">
                                                <i class="md md-arrow-back"></i>
                                                Back
                                            </a>
                                            <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light btn-submit" value="Submit">
                                        </div>
                                    </div>
                                </div>
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
    <script src="{{asset('js/jquery.repeater.min.js')}}"></script>
    <script src="{{asset('js/form-repeater.init.js')}}"></script>
    <script src="{{ asset('resources/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js')}}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function () {
            $('.dropify').dropify();
        });


        // Add new Row
        var append = 1;
        $(document).on('click', '#additemrow', function () {
            var b=parseFloat($("#temp").val());
            b=b+1;
            $("#temp").val(b);
            var temp=$("#temp").val();
            var tst=$('<div class="row mt-2 ml-1" id="my_package_id">' +
                '<div class="col-md-2">' +
                '<select data-placeholder="Select Product" class="dasad product_id" name="product_id[]" id="product_id'+append+'">' +
                '@foreach($product as $product_data)' +
                '<option value="{{$product_data->id}}"  @if(isset($category_search)) @if($category_search->id==$product_data->id) selected @endif @endif>{{ucfirst($product_data->name)}}</option>' +
                '@endforeach' +
                '</select>' +
                '</div>' +
                '<div class="col-md-2">' +
                '<input placeholder="quantity" class="form-control quantity" id="quantity" name="quantity[]" type="number">' +
                '</div>' +
                '<div class="col-md-2">' +
                '<input placeholder="price" type="number" name="price[]" class="form-control price">' +
                '</div>' +
                '<div class="col-md-2">' +
                '<input placeholder="discount" type="number" name="discount[]" class="form-control">' +
                '</div>' +
                '<div class="col-md-2" >' +
                '<input type="number" placeholder="total price" class="form-control totalprice" id="totalprice" name="totalprice[]">' +
                '</div>' +
                '<div class="col-md-1">' +
                '<a href="javascript:;" class="btn btn-sm btn-danger" onclick="remove_product(this)"><i class="fa fa-trash" ></i></a>' +
                '</div>' +
                '</div>'
            );
            $('#my_package_id').append(tst);
            $('#product_id'+append).select2();
            append++;

        });



        function remove_product(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
        function remove_productforedit(o) {
            var p = o.parentNode.parentNode;
            p.parentNode.removeChild(p);
        }
        // Add new Row

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
        });

        $("body").on('focus','.js-example-basic-single',function(){
            $(this).select2();
        });



        $(document).ready(function(){
            $(".quantity").change(function(){
                var quantity = parseInt($(this).val());
                var price = parseInt($('.price').val());
                var totalprice = parseInt(quantity * price);
                $('.totalprice').val(totalprice);
            });
            $(".price").change(function(){
                var quantity = parseInt($('.quantity').val());
                var price = parseInt($(this).val());
                var totalprice = parseInt(quantity * price);
                $('.totalprice').val(totalprice);
            });
        });

        $(document).ready(function(){
            $(".totalprice").change(function(){
                var totalprice = parseInt($(this).val());
                var total = parseInt(0);
                var sub_total = total + totalprice;
                console.log(sub_total);
            });
        });

        // Available Quantity Check
        $('.quantity').change(function(e){
            e.preventDefault();
            var quantity = $(this).val();
            var product_id = $('.product_id').val();
            $.ajax({
                url: "{{route('purchase.quntitycheckajax')}}",
                type: "post",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    product_id: product_id,
                    quantity: quantity
                },

                success:function(response){
                    if(typeof(response) != "object"){
                        response = JSON.parse(response);
                    }
                    if(response.status){
                        $('.quntitytitle').empty();
                        $('.quantity').css("border","1px solid #ced4da");
                        $('.btn-submit').removeAttr("disabled","disabled");

                    } else {
                        $('.quntitytitle').empty().append(response.message);
                        $('.quantity').css("border","1px solid red");
                        $('.btn-submit').attr("disabled","disabled");
                    }
                }

            })
        });

        // Available Quantity Check




        // Default Price
        $(document).ready(function () {
            $('.js-example-basic-single').on('change', do_something);
        });
        function do_something(e) {
            e.preventDefault();
            var that = $(this);
            var product_id = $(this).val();
            $.ajax({
                // url: "{{route('product.categoryproductajax')}}",
                url: "{{route('price.productpriceajax')}}",
                type: "post",
                data: {
                    _token: $("meta[name='csrf-token']").attr('content'),
                    product_id: product_id,
                },
                success:function(response){
                    if(typeof(response) != "object"){
                        response = JSON.parse(response);
                    }

                    if(response.data != null){
                        var default_price = response.data.value;
                        that.parent().next().next().children().val(default_price);
                    } else {
                        $('.price').val(0);
                    }

                }
            })
        }


        // Sweet Alert

        $('.btn-submit').on('click', function (event) {
            Swal.fire(
                        'Form Submitted Successfully',
                        '',
                        'success'
                    )
        });
    </script>
@endsection
