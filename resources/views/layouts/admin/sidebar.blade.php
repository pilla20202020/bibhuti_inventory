<div class="vertical-menu">

    <div data-simplebar class="h-100">

        <!--- Sidemenu -->
        <div id="sidebar-menu">
            <!-- Left Menu Start -->
            <ul class="metismenu list-unstyled" id="side-menu">
                <li class="menu-title">Main</li>

                <li>
                    <a href="{{route('dashboard')}}" class="waves-effect">
                        <i class="mdi mdi-speedometer"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow" aria-expanded="false">
                        <i class="mdi mdi-share-variant"></i>
                        <span>Admin</span>
                    </a>
                    <ul class="sub-menu mm-collapse" aria-expanded="true">
                        <li><a href="{{ route('user.index')}}" aria-expanded="false"><i class="fas fa-user"></i></i> Users</a></li>
                        <li><a href="{{ route('role.index')}}" aria-expanded="false"><i class="fa fa-tasks"></i> Roles</a></li>
                        <li><a href="{{ route('permission.index')}}" aria-expanded="false"><i class="fa fa-lock"></i> Permissions</a></li>
                    </ul>
                </li>
                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-code-branch"></i>
                        <span>Branch</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('branch.index')}}"><i class="fas fa-hand-point-right"></i> View All Branches</a></li>
                    </ul>
                </li>



                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-users"></i>
                        <span>Supplier</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('supplier.index')}}"><i class="fas fa-hand-point-right"></i> View All Supplier</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="mdi mdi-email-variant"></i>
                        <span>Brand</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('brand.index')}}"><i class="fas fa-hand-point-right"></i> View Brand</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-layer-group"></i>
                        <span>Category</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('category.index')}}"><i class="fas fa-hand-point-right"></i> View Category</a></li>
                    </ul>
                </li>

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-balance-scale"></i>
                        <span>Unit</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('unit.index')}}"><i class="fas fa-hand-point-right"></i> View All Units</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-dollar-sign"></i>
                        <span>Price</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('price.index')}}"><i class="fas fa-hand-point-right"></i> View All Prices</a></li>
                    </ul>
                </li> --}}

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-user"></i>
                        <span>Customer</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('customer.index')}}"><i class="fas fa-hand-point-right"></i> View All Customer</a></li>
                    </ul>
                </li> --}}

                <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fa fa-shopping-cart"></i>
                        <span>Product</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('product.index')}}"><i class="fas fa-hand-point-right"></i> View Product</a></li>
                    </ul>
                </li>

                {{-- <li>
                    <a href="javascript: void(0);" class="has-arrow waves-effect">
                        <i class="fas fa-boxes"></i>
                        <span>Stock Management</span>
                    </a>
                    <ul class="sub-menu" aria-expanded="false">
                        <li><a href="{{route('purchase.index')}}"><i class="fas fa-hand-point-right"></i> Stock-In / Purchase</a></li>
                        <li><a href="{{route('sale.index')}}"><i class="fas fa-hand-point-right"></i> Stock-Out / Sale</a></li>
                    </ul>
                </li> --}}

            </ul>
        </div>
        <!-- Sidebar -->
    </div>
</div>
