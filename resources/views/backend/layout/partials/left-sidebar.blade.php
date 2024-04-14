<!-- Main Sidebar Container -->
<aside class="@if(!empty($defaultShareData['theme']) && !empty($defaultShareData['theme']->aside_class)){{ $defaultShareData['theme']->aside_class }} @else main-sidebar main-sidebar-custom sidebar-light-primary elevation-4 @endif">
<!-- Brand Logo -->
<a href="#" class="@if(!empty($defaultShareData['theme']) && !empty($defaultShareData['theme']->brand_class)){{ $defaultShareData['theme']->brand_class }} @else brand-link bg-primary @endif">
    <img src="{{ asset('public') }}/images/logo-navbar-32.png" alt="Master Lte" class="brand-image"><!-- img-circle -->
    <span class="brand-text font-weight-light" style="margin-left: 16px;"><strong>{{ $defaultShareData['crm']->name }}</strong></span>
</a>

<!-- Sidebar -->
<div class="sidebar" style="margin-bottom: 16px;">
    <!-- Vendor Logo -->
    {{--<div class="mt-3 pb-3 mb-3 d-flex justify-content-center" style="border-bottom: 1px solid #ddd;">
        <img src="{{ asset('public/images/onex-crm-logo2.png') }}" class="img-fluid" style="max-height: 96px;">
    </div>--}}

    <!-- Sidebar Menu -->
    <nav class="mt-3">
        <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact text-sm" data-widget="treeview" role="menu" data-accordion="false">
            <li class="nav-item">
                <a href="{{ route('dashboard.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'dashboard') active @endif">
                    <i class="nav-icon fas fa-tachometer-alt"></i>
                    <p>Dashboard</p>
                </a>
            </li>
            @if(Helper::canAccess(array('super-admin')))
            <li class="nav-item @if(!empty($sidebar_parent) && $sidebar_parent == 'user_management') menu-open @endif">
                <a href="#" class="nav-link @if(!empty($sidebar_parent) && $sidebar_parent == 'user_management') active @endif">
                    <i class="nav-icon fas fa-users"></i>
                    <p>User Management<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('user.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'users') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.vendor.allVendors') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'vendors') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Vendors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.customer.allCustomer') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'customers') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Customers</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('user.salesman.allSalesman') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'salesmans') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>All Salesmans</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            <li class="nav-item @if(!empty($sidebar_parent) && $sidebar_parent == 'stock_management') menu-open @endif">
                <a href="#" class="nav-link @if(!empty($sidebar_parent) && $sidebar_parent == 'stock_management') active @endif">
                    <i class="nav-icon fas fa-layer-group"></i>
                    <p>Stock Management<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('stock.in') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'stock-in') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Stock-In</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('stock.out') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'stock-out') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Stock-Out</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('stock.report') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'stock-report') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Report</p>
                        </a>
                    </li>
                </ul>
            </li>
            @if(Helper::canAccess(array('super-admin', 'admin')))
            <li class="nav-header">MASTER ENTRIES</li>
            <li class="nav-item @if(!empty($sidebar_parent) && $sidebar_parent == 'product_management') menu-open @endif">
                <a href="#" class="nav-link @if(!empty($sidebar_parent) && $sidebar_parent == 'product_management') active @endif">
                    <i class="nav-icon fas fa-cubes"></i>
                    <p>Product Management<i class="right fas fa-angle-left"></i></p>
                </a>
                <ul class="nav nav-treeview">
                    <li class="nav-item">
                        <a href="{{ route('unit.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'units') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Units</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('brand.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'brands') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Brands</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'products') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Products</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.variant.allVariants') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'productvariants') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Product Variants</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.category.allCategories') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'categories') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('product.subcategory.allSubCategories') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'subcategories') active @endif">
                            <i class="far fa-circle nav-icon"></i>
                            <p>Subcategories</p>
                        </a>
                    </li>
                </ul>
            </li>
            @endif
            @if(Helper::canAccess(array('super-admin')))
            <li class="nav-header">SETTINGS</li>
            <li class="nav-item">
                <a href="{{ route('theme.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'theme') active @endif">
                    <i class="nav-icon far fa-circle text-info"></i>
                    <p>Theme Settings</p>
                </a>
            </li>
            <li class="nav-item">
                <a href="{{ route('crm.index') }}" class="nav-link @if(!empty($sidebar_child) && $sidebar_child == 'crm') active @endif">
                    <i class="nav-icon far fa-circle text-warning"></i>
                    <p>CRM Settings</p>
                </a>
            </li>
            @endif
        </ul>
    </nav>
    <!-- /.sidebar-menu -->
</div>
<!-- /.sidebar -->
<div class="sidebar-custom">
    <!--a href="#" class="btn btn-link"><i class="fas fa-cogs"></i></a>
    <a href="#" class="btn btn-sm btn-secondary hide-on-collapse pos-right">Help</a-->
</div>
<!-- /.sidebar-custom -->
</aside>