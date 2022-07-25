@if(!empty($editRoute))
    <a href="{{$editRoute}}"><button type="button" class="btn btn-icon-toggle btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Edit"><i class="mdi mdi-pencil"></i></button></a>
@endif

@if(!empty($printRoute))
    <a href="{{$printRoute}}" target="_blank"><button type="button" class="btn btn-icon-toggle btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Print"><i class="mdi mdi-printer"></i></button></a>
@endif

@if(!empty($viewRoute))
    <a href="{{$viewRoute}}" target="__blank"><button type="button" class="btn btn-icon-toggle btn-sm" data-toggle="tooltip"  data-placement="top" data-original-title="View"><i class="far fa-eye"></i></button></a>
@endif

@if(!empty($resumeRoute))
    <a href="{{$resumeRoute}}"><button type="button" class="btn btn-icon-toggle btn-sm" data-toggle="tooltip"  data-placement="top" data-original-title="View Resume"><i class="fa fa-file"></i></button></a>
@endif

@if(!empty($showRoute))
    <a href="{{$showRoute}}" ><button type="button" class="btn btn-icon-toggle" data-toggle="tooltip" data-placement="top" data-original-title="Show"><i class="far fa-eye"></i></button></a>
@endif

@if(!empty($deleteRoute))
    <a href="#"><button type="button" data-route="{{$deleteRoute}}" class="btn btn-icon-toggle btn-delete p-1" data-toggle="tooltip" id="sa-warning" data-placement="top" data-original-title="Delete"><i class="far fa-trash-alt"></i></button></a>
@endif

@if(!empty($checklist))
    <button type="button" class="btn btn-primary btn-approve btn-sm mb-1" onclick="approvedthis({{$checklist}})" value="1">Add Check Out</button>
@endif

@if(!empty($billRoute))
    <a href="{{$billRoute}}" ><button type="button" class="btn btn-warning btn-reject btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Generate Bill">Add Bill</button></a>
@endif

@if(!empty($invoiceRoute))
    <a href="{{$invoiceRoute}}" ><button type="button" class="btn btn-danger btn-reject btn-sm" data-toggle="tooltip" data-placement="top" data-original-title="Generate Bill">Generate Invoice</button></a>
@endif




