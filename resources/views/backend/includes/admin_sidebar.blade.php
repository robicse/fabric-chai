<aside class="main-sidebar sidebar-dark-primary elevation-4" style="background: #303641;  min-height: 690px!important;border-radius: 0px 25px 25px 0px;">
    <!-- Brand Logo -->
{{--<a href="#" class="brand-link">
    <img src="{{asset('backend/images/logo.png')}}" width="150" height="100" alt="Aamar Bazar" class="brand-image img-circle elevation-3"
         style="opacity: .8">
    --}}{{--<span class="brand-text font-weight-light">Farazi Home Care</span>--}}{{--
</a>--}}
<!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-2 pl-2 mb-2 d-flex">
            <div class="">
                <img src="{{asset('/backend/images/fabric-lagbe.png')}}" class="" alt="User Image" style="width: 50%;">
            </div>
        </div>

    @if (Auth::check()  && (Auth::user()->user_type == 'admin' || Auth::user()->user_type == 'staff')  )
        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                    data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->
                    <li class="nav-item">
                        <a href="{{route('admin.dashboard')}}"
                           class="nav-link {{Request::is('admin/dashboard') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-home"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.visitor_report')}}"
                           class="nav-link {{Request::is('admin/visitor-report') ? 'active' : ''}}">
                            <i class="nav-icon fas fa-male"></i>
                            <p>
                                Visitor Report
                            </p>
                        </a>
                    </li>


                    <li class="nav-item has-treeview {{(Request::is('admin/categories*')
                        || Request::is('admin/sub-categories*')
                        || Request::is('admin/sub-sub-categories*')
                        || Request::is('admin/sub-sub-child-categories*')
                        || Request::is('admin/sub-sub-child-child-categories*')
                        || Request::is('admin/category-six*')
                        || Request::is('admin/category-seven*')
                        || Request::is('admin/category-eight*')
                        || Request::is('admin/category-nine*')
                        || Request::is('admin/category-ten*'))
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Category Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">

                            <li class="nav-item">
                                <a href="{{route('admin.categories.index')}}"
                                   class="nav-link {{Request::is('admin/categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Categories</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.sub-categories.index')}}"
                                   class="nav-link {{Request::is('admin/sub-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Sub categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.sub-sub-categories.index')}}"
                                   class="nav-link {{Request::is('admin/sub-sub-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sub-sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Sub Sub Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.sub-sub-child-categories.index')}}"
                                   class="nav-link {{Request::is('admin/sub-sub-child-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sub-sub-child-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Sub Sub Child Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.sub-sub-child-child-categories.index')}}"
                                   class="nav-link {{Request::is('admin/sub-sub-child-child-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/sub-sub-child-child-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Sub Sub Child Child Cat</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.category-six.index')}}"
                                   class="nav-link {{Request::is('admin/category-six*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/category-six*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Category Six</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.category-seven.index')}}"
                                   class="nav-link {{Request::is('admin/category-seven*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/category-seven*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Category Seven</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.category-eight.index')}}"
                                   class="nav-link {{Request::is('admin/category-eight*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/category-eight*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Category Eight</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.category-nine.index')}}"
                                   class="nav-link {{Request::is('admin/category-nine*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/category-nine*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Category Nine</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.category-ten.index')}}"
                                   class="nav-link {{Request::is('admin/category-ten*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/category-ten*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Category Ten</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/brands*')
                        || Request::is('admin/units*')
                        || Request::is('admin/currencies*')
                        || Request::is('admin/yarn-product*')
                        || Request::is('admin/dying-categories*')
                        || Request::is('admin/dying-sub-categories*')
                        || Request::is('admin/test-parameters*')
                        || Request::is('admin/methods*')
                        || Request::is('admin/color-fastness*')
                        || Request::is('admin/color-staining*'))
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p>
                                Product Management
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.units.index')}}"
                                   class="nav-link {{Request::is('admin/units*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/units*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Units</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.currencies.index')}}"
                                   class="nav-link {{Request::is('admin/currencies*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/currencies*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Currency</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.yarn-product.index')}}"
                                   class="nav-link {{Request::is('admin/yarn-product*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/yarn-product*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Yarn Product</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.dying-categories.index')}}"
                                   class="nav-link {{Request::is('admin/dying-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/dying-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Dying Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.dying-sub-categories.index')}}"
                                   class="nav-link {{Request::is('admin/dying-sub-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/dying-sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Dying Subcategory</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.test-parameters.index')}}"
                                   class="nav-link {{Request::is('admin/test-parameters*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/test-parameters*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Test Parameter</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.methods.index')}}"
                                   class="nav-link {{Request::is('admin/methods*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/methods*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Method Names</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.color-fastness.index')}}"
                                   class="nav-link {{Request::is('admin/color-fastness*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/color-fastness*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Color Fastness</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.color-staining.index')}}"
                                   class="nav-link {{Request::is('admin/color-staining*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/color-staining*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Color Staining</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{(Request::is('admin/home-categories*')) || (Request::is('admin/admin-products*')) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cart-plus"></i>
                            <p>
                                Admin Products
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.home-categories.index')}}"
                                   class="nav-link {{Request::is('admin/home-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/home-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Home Category</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.admin-products.index')}}"
                                   class="nav-link {{Request::is('admin/admin-products*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/admin-products*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Product</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @if(Auth::user()->user_type == 'admin')
                    <li class="nav-item has-treeview {{(Request::is('admin/profile*') ) ? 'menu-open' : '' }}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-circle"></i>
                            <p>
                                Admin
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.profile.index')}}"
                                   class="nav-link {{Request::is('admin/profile') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/profile') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Profile</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    @endif

                    <li class="nav-item has-treeview {{(Request::is('admin/seller*'))? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-plus"></i>
                            <p>
                                Seller
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.seller-list')}}"
                                   class="nav-link {{Request::is('admin/seller-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/seller-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Seller List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller-product-list')}}"
                                   class="nav-link {{Request::is('admin/seller-product-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/seller-product-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Seller Product List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller-unapproved-product-list')}}"
                                   class="nav-link {{Request::is('admin/seller-unapproved-product-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/seller-unapproved-product-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Seller Unapproved Product List</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <li class="nav-item has-treeview {{(Request::is('admin/buyer*'))? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Buyer
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.buyer-list')}}"
                                   class="nav-link {{Request::is('admin/buyer-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/buyer-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Buyer List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.buyer-product-list')}}"
                                   class="nav-link {{Request::is('admin/buyer-product-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/buyer-product-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Buyer Requested Product List</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.buyer-unapproved-product-list')}}"
                                   class="nav-link {{Request::is('admin/buyer-unapproved-product-list*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/buyer-unapproved-product-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Buyer Requested Unapproved Product List</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/employee*')
|| Request::is('admin/employer*')
|| Request::is('admin/education-levels*')
|| Request::is('admin/education-degrees*')
|| Request::is('admin/salary-range*')
)? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-user-graduate"></i>
                            <p>
                                Job
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item has-treeview {{(Request::is('admin/employee*')
|| Request::is('admin/education-levels*')
|| Request::is('admin/education-degrees*')
|| Request::is('admin/salary-range*')
|| Request::is('admin/un-approve-employee-list*')
|| Request::is('admin/un-approve-employer-list*')
)? 'menu-open' : ''}}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        Employee
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.employee.index')}}"
                                           class="nav-link {{Request::is('admin/employee*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/employee*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Employee List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.un-approve-employee-list')}}"
                                           class="nav-link {{Request::is('admin/un-approve-employee-list*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/un-approve-employee-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Un-Approved Employee List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.education-levels.index')}}"
                                           class="nav-link {{Request::is('admin/education-levels*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/education-levels*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Education Levels</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.education-degrees.index')}}"
                                           class="nav-link {{Request::is('admin/education-degrees*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/education-degrees*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Education Degrees</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.salary-range.index')}}"
                                           class="nav-link {{Request::is('admin/salary-range*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/salary-range*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Salary Range</p>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item has-treeview {{(Request::is('admin/employer*'))? 'menu-open' : ''}}">
                                <a href="#" class="nav-link">
                                    <i class="nav-icon fas fa-user-tie"></i>
                                    <p>
                                        Employer
                                        <i class="right fa fa-angle-left"></i>
                                    </p>
                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.employer.index')}}"
                                           class="nav-link {{Request::is('admin/employer*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/employer*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Employer List</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.employer.un-approve-employer-list')}}"
                                           class="nav-link {{Request::is('admin/employer/un-approve-employer-list*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/employer/un-approve-employer-list*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Un Approive Employer List</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>

                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/seller-work-order-list*')
|| Request::is('admin/buyer-work-order-list*')
|| Request::is('admin/work-order-categories*')
|| Request::is('admin/work-order-sub-categories*')
|| Request::is('admin/work-order-sub-sub-categories*')
|| Request::is('admin/wo-sub-sub-child-categories*')
|| Request::is('admin/wo-sub-sub-child-child-categories*')
|| Request::is('admin/wo-category-six*')
|| Request::is('admin/wo-category-seven*')
|| Request::is('admin/wo-category-eight*')
|| Request::is('admin/wo-category-nine*')
|| Request::is('admin/wo-category-ten*')
)? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Work Order
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item has-treeview {{(Request::is('admin/work-order-categories*')
|| Request::is('admin/work-order-sub-categories*')
|| Request::is('admin/work-order-sub-sub-categories*')
|| Request::is('admin/wo-sub-sub-child-categories*')
|| Request::is('admin/wo-sub-sub-child-child-categories*')
|| Request::is('admin/wo-category-six*')
|| Request::is('admin/wo-category-seven*')
|| Request::is('admin/wo-category-eight*')
|| Request::is('admin/wo-category-nine*')
|| Request::is('admin/wo-category-ten*')
|| Request::is('admin/un-approve-seller-work-order-list*')
) ? 'menu-open' : ''}}">
                                <a href="#" class="nav-link">
                                    <i class="fa fa-list nav-icon"></i>
                                    <p>Work Order Category
                                        <i class="right fa fa-angle-left"></i>
                                    </p>

                                </a>
                                <ul class="nav nav-treeview">
                                    <li class="nav-item">
                                        <a href="{{route('admin.work-order-categories.index')}}"
                                           class="nav-link {{Request::is('admin/work-order-categories*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/work-order-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.work-order-sub-categories.index')}}"
                                           class="nav-link {{Request::is('admin/work-order-sub-categories*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/work-order-sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Sub Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.work-order-sub-sub-categories.index')}}"
                                           class="nav-link {{Request::is('admin/work-order-sub-sub-categories*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/work-order-sub-sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Sub Sub Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-sub-sub-child-categories.index')}}"
                                           class="nav-link {{Request::is('admin/wo-sub-sub-child-categories*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-sub-sub-child-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Sub Sub Child Categories</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-sub-sub-child-child-categories.index')}}"
                                           class="nav-link {{Request::is('admin/wo-sub-sub-child-child-categories*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-sub-sub-child-child-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Sub Sub Child Child Cat</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-category-six.index')}}"
                                           class="nav-link {{Request::is('admin/wo-category-six*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-category-six*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Category Six</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-category-seven.index')}}"
                                           class="nav-link {{Request::is('admin/wo-category-seven*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-category-seven*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Category Seven</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-category-eight.index')}}"
                                           class="nav-link {{Request::is('admin/wo-category-eight*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-category-eight*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Category Eight</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-category-nine.index')}}"
                                           class="nav-link {{Request::is('admin/wo-category-nine*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-category-nine*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Category Nine</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{route('admin.wo-category-ten.index')}}"
                                           class="nav-link {{Request::is('admin/wo-category-ten*') ? 'active' :''}}">
                                            <i class="fa fa-{{Request::is('admin/wo-category-ten*') ? 'folder-open':'folder'}} nav-icon"></i>
                                            <p>Category Ten</p>
                                        </a>
                                    </li>

                                </ul>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.seller-work-order.list')}}"
                                   class="nav-link {{Request::is('admin/seller-work-order-list') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/seller-work-order-list') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Manufacturer Work Orders</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.un-approve-seller-work-order-list')}}"
                                   class="nav-link {{Request::is('admin/un-approve-seller-work-order-list') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/un-approve-seller-work-order-list') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Un Approve Manufacturer Work Orders</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/membership_packages*')) || (Request::is('admin/membership-package*') )? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-box"></i>
                            <p>
                                Membership Packages
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.membership_packages.index')}}"
                                   class="nav-link {{Request::is('admin/membership_packages*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/membership_packages*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p title="Membership Package List">M. P. List</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.membership-package-details.index')}}"
                                   class="nav-link {{Request::is('admin/membership-package-details*')  ? 'active' : ''}} ">
                                    <i class="fa fa-{{Request::is('admin/membership-package-details*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p title="Membership Package Details">M. P. Details</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.membership-package-other-benefit.index')}}"
                                   class="nav-link {{Request::is('admin/membership-package-other-benefit*')  ? 'active' : ''}} ">
                                    <i class="fa fa-{{Request::is('admin/membership-package-other-benefit*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p title="Membership Package Other Benefits">M. P. Other Benefits</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item ">
                        <a href="{{route('admin.membership-users.index')}}" class="nav-link {{Request::is('admin/membership-users*') ? 'active' :''}}">
                            <i class="nav-icon fas fa-users-cog"></i>
                            <p>MemberShip Users</p>
                        </a>
                    </li>


                    <li class="nav-item ">
                        <a href="{{route('admin.notification')}}" class="nav-link {{Request::is('admin/notification*')  ? 'active' : ''}} ">
                            <i class="nav-icon fas fa-newspaper-o"></i>
                            <p>
                                Notifications <span style="color: red;font-weight: bold;">{{notViewAdminNotificationCount()->count}}</span>
                            </p>
                        </a>
                    </li>

                    <li class="nav-item">
                        <a href="{{route('admin.seller.payment')}}" class="nav-link {{Request::is('admin/seller-payment*')  ? 'active' : ''}} ">
                            <i class="nav-icon fas fa-newspaper-o"></i>
                            <p>
                                Seller Partial Paid <span style="color: red;font-weight: bold;">{{pendingSellerPaymentCount()->count}}</span>
                            </p>
                        </a>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/sales-report*')
                              || Request::is('admin/total-sales*')
                              || Request::is('admin/total-revenue*')
                              || Request::is('admin/total-vat*')
                              || Request::is('admin/total-package-sell*')
                              || Request::is('admin/total-transaction*')
                              || Request::is('admin/total-bid-accepted*')
                              || Request::is('admin/total-bid-rejected*')
                              || Request::is('admin/total-products*')
                              || Request::is('admin/total-buy-requested-products*')
                              || Request::is('admin/total-advertisements*')
                              || Request::is('admin/total-manufacturer-posts*')
                              || Request::is('admin/total-job-seekers*')
                              || Request::is('admin/total-job-provider*')
                              || Request::is('admin/total-work-order-received*')
                              || Request::is('admin/total-work-order-provided*')
                              || Request::is('admin/total-sms-history*')
                               || Request::is('admin/referral-code-report*')
                              || Request::is('admin/monthly-earning-report*')
                              || Request::is('admin/top-sellers*')
                              || Request::is('admin/commission-report*')
                              || Request::is('admin/sms-report*')
                              || Request::is('admin/transaction-report*')
                               )? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-chart-area"></i>
                            <p>
                                Report
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.total-sales')}}"
                                   class="nav-link {{Request::is('admin/total-sales*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-sales*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Sales/GMV</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-revenue')}}"
                                   class="nav-link {{Request::is('admin/total-revenue*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-revenue*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Revenue/Commission</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-vat')}}"
                                   class="nav-link {{Request::is('admin/total-vat*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-vat*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total VAT</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-package-sell')}}"
                                   class="nav-link {{Request::is('admin/total-package-sell*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-package-sell*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Package Sale</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-transaction')}}"
                                   class="nav-link {{Request::is('admin/total-transaction*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-transaction*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Transaction</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-bid-accepted')}}"
                                   class="nav-link {{Request::is('admin/total-bid-accepted*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-bid-accepted*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Bid Accepted</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-bid-rejected')}}"
                                   class="nav-link {{Request::is('admin/total-bid-rejected*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-bid-rejected*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Bid Rejected</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-products')}}"
                                   class="nav-link {{Request::is('admin/total-products*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-products*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Products Entry</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-buy-requested-products')}}"
                                   class="nav-link {{Request::is('admin/total-buy-requested-products*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-buy-requested-products*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Buy Requested Products</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-advertisements')}}"
                                   class="nav-link {{Request::is('admin/total-advertisements*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-advertisements*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Branding</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-manufacturer-posts')}}"
                                   class="nav-link {{Request::is('admin/total-manufacturer-posts*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-manufacturer-posts*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Manufacturer Posts</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-job-seekers')}}"
                                   class="nav-link {{Request::is('admin/total-job-seekers*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-job-seekers*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Job Seekers</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-job-provider')}}"
                                   class="nav-link {{Request::is('admin/total-job-provider*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-job-provider*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Job Provider</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-work-order-received')}}"
                                   class="nav-link {{Request::is('admin/total-work-order-received*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-work-order-received*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Work order Received</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.total-work-order-provided')}}"
                                   class="nav-link {{Request::is('admin/total-work-order-provided*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-work-order-provided*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total Work order Provide</p>
                                </a>
                            </li>

                            <li class="nav-item">
                                <a href="{{route('admin.total-sms-history')}}"
                                   class="nav-link {{Request::is('admin/total-sms-history*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/total-sms-history*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Total SMS History</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.referral-code-report')}}"
                                   class="nav-link {{Request::is('admin/referral-code-report*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/referral-code-report*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Referral Code Report</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.registration-user-report')}}"
                                   class="nav-link {{Request::is('admin/registration-user-report*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/registration-user-report*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Registration  User Report</p>
                                </a>
                            </li>
                  <!--          <li class="nav-item">
                                <a href="{{route('admin.monthly-registration-user-report')}}"
                                   class="nav-link {{Request::is('admin/monthly-registration-user-report*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/monthly-registration-user-report*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Monthly Registration  User Report</p>
                                </a>
                            </li> -->
                            <li class="nav-item">
                                <a href="{{route('admin.bidder-list-report')}}"
                                   class="nav-link {{Request::is('admin/bidder-list-report*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/bidder-list-report*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Bidder List Report</p>
                                </a>
                            </li>

{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.sales-report')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/sales-report*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/sales-report*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Sales Report</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.monthly-earning-report')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/monthly-earning-report*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/monthly-earning-report*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Monthly Earning Report</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.top-sellers')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/top-sellers*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/top-sellers*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Top Sellers</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.commission-report')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/commission-report*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/commission-report*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Commission Report</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.sms-report')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/sms-report*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/sms-report*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>SMS Report</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
{{--                            <li class="nav-item">--}}
{{--                                <a href="{{route('admin.transaction-report')}}"--}}
{{--                                   class="nav-link {{Request::is('admin/transaction-report*') ? 'active' :''}}">--}}
{{--                                    <i class="fa fa-{{Request::is('admin/transaction-report*') ? 'folder-open':'folder'}} nav-icon"></i>--}}
{{--                                    <p>Transaction Report</p>--}}
{{--                                </a>--}}
{{--                            </li>--}}
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/sales-report*')
                              || Request::is('admin/advertisements*')
                              || Request::is('admin/sliders*')
                              || Request::is('admin/blogs*')
                              || Request::is('admin/pop-ups*')
                              || Request::is('admin/transaction-report*')
                              || Request::is('admin/machine-type*')
                              || Request::is('admin/about-us*')
                              || Request::is('admin/dynamic_pages*')
                              || Request::is('admin/faqs*')
                               )? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-cog"></i>
                            <p>
                                Settings
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.machine-type.index')}}"
                                   class="nav-link {{Request::is('admin/machine-type*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/machine-type*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Machine Type</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.message-charge.index')}}"
                                   class="nav-link {{Request::is('admin/message-charge*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/message-charge*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Message Charge</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.advertisements.index')}}" class="nav-link {{Request::is('admin/advertisements*') ? 'active' :''}}">
                                    <i class="nav-icon fas fa-{{Request::is('admin/advertisements*') ? 'folder-open':'folder'}}"></i>
                                    <p>Advertisements</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.sliders.index')}}" class="nav-link {{Request::is('admin/sliders*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/sliders*') ? 'folder-open':'folder'}}"></i>
                                    <p>Sliders</p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.blogs.index')}}" class="nav-link {{Request::is('admin/blogs*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/blogs*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                        Blogs
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.pop-ups.index')}}" class="nav-link {{Request::is('admin/pop-ups*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/pop-ups*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                        Pop Ups
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.about-us.index')}}" class="nav-link {{Request::is('admin/about-us*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/about-us*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                        About Us
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.faqs.index')}}" class="nav-link {{Request::is('admin/faqs*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/faqs*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                     FAQS
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.dynamic_pages.index')}}" class="nav-link {{Request::is('admin/dynamic_pages*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/dynamic_pages*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                        Dynamic Pages
                                    </p>
                                </a>
                            </li>
                            <li class="nav-item ">
                                <a href="{{route('admin.city-corporations.index')}}" class="nav-link {{Request::is('admin/city-corporations*')  ? 'active' : ''}} ">
                                    <i class="nav-icon fas fa-{{Request::is('admin/city-corporations*') ? 'folder-open':'folder'}}"></i>
                                    <p>
                                        City Corporations
                                    </p>
                                </a>
                            </li>
                        </ul>
                    </li>


                    <li class="nav-item ">
                        <a href="{{route('admin.priority-buyers.index')}}" class="nav-link {{Request::is('admin/priority-buyers*')  ? 'active' : ''}} ">
                            <i class="nav-icon fas fa-user-friends"></i>
                            <p>
                                Priority Buyers
                            </p>
                        </a>
                    </li>

                    <li class="nav-item has-treeview {{(Request::is('admin/industry-categories*')
                        || Request::is('admin/industry-sub-categories*')
                        || Request::is('admin/industry-employee-types*'))
                    ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-shopping-cart"></i>
                            <p title="Industry Category Management">
                                Industry Category...
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.industry-categories.index')}}"
                                   class="nav-link {{Request::is('admin/industry-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/industry-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Industry Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.industry-sub-categories.index')}}"
                                   class="nav-link {{Request::is('admin/industry-sub-categories*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/industry-sub-categories*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Industry Sub Categories</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.industry-employee-types.index')}}"
                                   class="nav-link {{Request::is('admin/industry-employee-types*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/industry-employee-types*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Industry Employee Types</p>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li class="nav-item has-treeview {{(Request::is('admin/roles*')
|| Request::is('admin/departments*')
|| Request::is('admin/staffs*')
) ? 'menu-open' : ''}}">
                        <a href="#" class="nav-link">
                            <i class="nav-icon fas fa-users"></i>
                            <p>
                                Role & permission
                                <i class="right fa fa-angle-left"></i>
                            </p>
                        </a>
                        <ul class="nav nav-treeview">
                            <li class="nav-item">
                                <a href="{{route('admin.departments.index')}}"
                                   class="nav-link {{Request::is('admin/departments*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/departments*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Department Manage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.roles.index')}}"
                                   class="nav-link {{Request::is('admin/role*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/roles*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Role Manage</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{route('admin.staffs.index')}}"
                                   class="nav-link {{Request::is('admin/staffs*') ? 'active' :''}}">
                                    <i class="fa fa-{{Request::is('admin/staffs*') ? 'folder-open':'folder'}} nav-icon"></i>
                                    <p>Staff Manage</p>
                                </a>
                            </li>
                        </ul>
                    </li>

                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        @endif
    </div>
    <!-- /.sidebar -->
</aside>


