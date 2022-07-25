@section('page-specific-styles')
    <link href="{{ asset('css/dropify.min.css') }}" rel="stylesheet">
    <link type="text/css" rel="stylesheet"
        href="{{ asset('resources/css/theme-default/libs/bootstrap-tagsinput/bootstrap-tagsinput.css?1424887862') }}" />
@endsection
@csrf
<div class="row">
    <div class="col-sm-9">
        <div class="card">
            <div class="card-underline">
                <div class="card-head">
                    <header class="ml-3 mt-2">{!! $header !!}</header>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12">
                            {{-- <div class="form-group">
                                <input type="text" name="name" class="form-control" required
                                       value="{{ old('name', isset($role->name) ? $role->name : '') }}"/>
                                <span id="textarea1-error" class="text-danger">{{ $errors->first('name') }}</span>
                                <label for="Name">Name</label>
                            </div> --}}

                            <div class="form-group ">
                                <label for="name" class="col-form-label pt-0">Role</label>
                                <div class="">
                                    <input class="form-control" type="text" required name="name"
                                        value="{{ old('name', isset($role->name) ? $role->name : '') }}"
                                        placeholder="Enter Your Name">
                                </div>
                            </div>

                        </div>
                    </div>

                    {{-- <div class="row">
                        <div class="col-sm-12">
                            <div class="form-group ">
                                <label for="permission" class="col-form-label pt-0">Choose a Permission</label>
                                <div class="">
                                    <select data-placeholder="Select Permission"
                                        class="js-example-basic-multiple form-control" name="permissions[]"
                                        multiple="multiple">
                                        @foreach ($permission as $permission_data)
                                            @if (isset($rolePermission))
                                                @foreach ($rolePermission as $role_permission)
                                                    <option value="{{ $permission_data->id }}"
                                                        @if ($role_permission->id == $permission_data->id) selected @endif>
                                                        {{ ucfirst($permission_data->name) }}</option>
                                                @endforeach
                                            @else
                                                <option value="{{ $permission_data->id }}">
                                                    {{ ucfirst($permission_data->name) }}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div> --}}




                    @foreach ($groupPermissions as $chunk)
                        <div class="row">
                            @foreach ($chunk as $title => $group)
                                <div class="col-xs-6 col-sm-4 col-md-4">
                                    <div class="form-group form-check">
                                        <input type="checkbox" class="form-check-input"
                                            data-checkbox-group="{{ Str::slug($title) }}" data-role="selectall">
                                        <label class="form-check-label h5 font-weight-bold text-danger" for="permission">{{ ucfirst($title) }}</label>

                                    </div>
                                    @foreach ($group as $permission)
                                        <div class="form-group form-check">

                                            <input type="checkbox" class="form-check-input"
                                                name="permissions[{{ $permission->name }}]" value="{{$permission->id}}"
                                                {{ isset($role) &&$role->permissions()->whereName($permission->name)->first()? 'checked': '' }}
                                                data-checkbox-group="{{ Str::slug($title) }}" data-role="select">
                                            <label class="form-check-label"
                                                for="{{ $permission->name }}">{{ $permission->name }}</label>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>
                    @endforeach


                </div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card">
            <div class="card-body">
                <div class="row mt-2 justify-content-center">
                    <div class="form-group">
                        <div>
                            <a class="btn btn-light waves-effect ml-1" href="{{ route('role.index') }}">
                                <i class="md md-arrow-back"></i>
                                Back
                            </a>
                            <input type="submit" name="pageSubmit" class="btn btn-danger waves-effect waves-light"
                                value="Submit">
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


@section('page-specific-scripts')
    <script src="{{ asset('resources/js/ckeditor/ckeditor.js') }}"></script>
    <script src="{{ asset('js/dropify.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/bootstrap-tagsinput/bootstrap-tagsinput.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('resources/js/libs/jquery-validation/dist/additional-methods.min.js') }}"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            $('.dropify').dropify();

            $("[data-role=selectall]").change(function() {
                var $thisgroup = $("[data-checkbox-group=" + $(this).data('checkbox-group') +
                    "][data-role=select]");
                if (this.checked) {
                    $thisgroup.each(function() {
                        this.checked = true;
                    })
                } else {
                    $thisgroup.each(function() {
                        this.checked = false;
                    })
                }
            });

            $("[data-checkbox-group]").change(function() {
                var $thisgroup = $("[data-checkbox-group=" + $(this).data('checkbox-group') +
                    "][data-role=select]");
                var $thisselectall = $("[data-checkbox-group=" + $(this).data('checkbox-group') +
                    "][data-role=selectall]");
                if ($(this).is(":checked")) {
                    var isAllChecked = 0;
                    $thisgroup.each(function() {
                        if (!this.checked)
                            isAllChecked = 1;
                    });
                    if (isAllChecked == 0) {
                        $thisselectall.prop("checked", true);
                    }
                } else {
                    $thisselectall.prop("checked", false);
                }
            });

            $('.card-body').on('click', function(e) {
                $('[data-toggle="popover"]').each(function() {
                    if (!$(this).is(e.target) && $(this).has(e.target).length === 0 && $('.popover')
                        .has(e.target).length === 0) {
                        $(this).popover('hide');
                    }
                });
            });

            $("[data-checkbox-group][data-role=select]").trigger('change');
        });
    </script>
@endsection
