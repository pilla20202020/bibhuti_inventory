@extends('layouts.admin.admin')

@section('title', 'Sale')

@section('content')
 <!-- start page title -->
 <div class="row">
    <div class="col-12">
        <div class="page-title-box d-flex align-items-center justify-content-between">
            <h4 class="mb-0 font-size-18">Invoice</h4>
            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);">Sale</a></li>
                    <li class="breadcrumb-item active">Invoice</li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-md-12 col-lg-10 mx-auto">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-lg-6">
                        <img src="assets/images/logo-sm-dark.png" alt="" class="img-fluid" width="75">
                    </div>

                    <div class="col-lg-6  align-self-center">
                        <div class="">
                            <div class="float-right">
                                <h6 class="mb-0"><b>Order Date :</b> {{$sale->buying_date}}</h6>
                                <h6><b>Order ID :</b> # {{$sale->invoice_no}}</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="float-left mt-5">
                            <address class="font-13">
                                <strong class="font-size-14">Customer Info</strong><br>
                                {{$sale->customer->name}}<br>
                                {{$sale->customer->email}}<br>
                                {{$sale->customer->address}}<br>
                                {{$sale->customer->phone1}}
                            </address>
                        </div>
                        {{-- <div class="float-right text-right mt-5">
                            <address class="font-13">
                                <strong class="font-size-14">Shipped To:</strong><br>
                                Joe Smith<br>
                                795 Folsom Ave<br>
                                San Francisco, CA 94107<br>
                                <abbr title="Phone">P:</abbr> (123) 456-7890
                            </address>
                        </div> --}}
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="table-responsive">
                            <table class="table table-bordered mb-0">
                                <thead>
                                    <tr>
                                        <th>Item</th>
                                        <th>Quantity</th>
                                        <th>Discount</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($sale_details as $saledetail)
                                        <tr>
                                            <td>{{$saledetail->product->name}}</td>
                                            <th>{{$saledetail->quantity}}</th>
                                            <td>{{$saledetail->discount}}</td>
                                            <td>{{$saledetail->price}}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td colspan="2" class="border-0"></td>
                                        <td class="border-0 font-size-14"><b>Sub Total</b></td>
                                        <td class="border-0 font-size-14 sub_total">
                                            
                                            
                                        </td>
                                    </tr>
                                    <tr>
                                        <th colspan="2" class="border-0"></th>
                                        <td class="border-0 font-size-14"><b>Tax Rate</b></td>
                                        <td class="border-0 font-size-14"><b>$0.00%</b></td>
                                    </tr>
                                    <tr class="bg-dark text-light">
                                        <th colspan="2" class="border-0"></th>
                                        <td class="border-0 font-size-14"><b>Total</b></td>
                                        <td class="border-0 font-size-14"><b>$2359.00</b></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h5 class="mt-4">Terms And Condition :</h5>
                        <ul class="pl-3">
                            <li><small>All accounts are to be paid within 7 days from receipt of invoice. </small></li>
                            <li><small>To be paid by cheque or credit card or direct payment online.</small></li>
                            <li><small> If account is not paid within 7 days the credits details supplied as confirmation<br> of work undertaken will be charged the agreed quoted fee noted above.</small></li>
                        </ul>
                    </div>
                    <div class="col-lg-6 align-self-end">
                        <div class="w-25 float-right">
                            <img src="assets/images/signature.png" alt="" class="img-fluid">
                            <p class="border-top">Signature</p>
                        </div>
                    </div>
                </div>
                <hr>
                <div class="row d-flex justify-content-center">
                    <div class="col-lg-12 col-xl-4 ml-auto align-self-center">
                        <div class="text-center text-muted"><small>Thank you very much for doing business with us. Thanks !</small></div>
                    </div>
                    <div class="col-lg-12 col-xl-4">
                        <div class="float-right d-print-none">
                            <a href="javascript:window.print()" class="btn btn-info"><i class="fa fa-print"></i></a>
                            <a href="#" class="btn btn-danger">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection


@section('page-specific-scripts')
<script>
    var prices = [
                    @foreach($sale_details as $saledetail)
                        {{($saledetail->price)}},
                    @endforeach
                ];
                sum = prices.reduce((a, b) => {
                    return a + b;
                });

                $('.sub_total').empty().append('Rs ' +sum);
            
</script>
@endsection