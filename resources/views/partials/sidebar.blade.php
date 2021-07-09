<aside id="sidebar-wrapper">
    <div class="sidebar-brand">
        <a href="">{{ config('app.name') }}</a>
    </div>
    <div class="sidebar-brand sidebar-brand-sm">
        <a href="#">{{ strtoupper(substr(config('app.name'), 0, 2)) }}</a>
    </div>
    <ul class="sidebar-menu">
        <li class="menu-header">Categories</li>
        <li class="@routeis('admin.categories.index') active @endrouteis"><a class="nav-link"
                href="{{ route('admin.categories.index') }}"><i class="fas fa-columns"></i> <span>Category List</span></a></li>

        <li class="menu-header">Customers</li>
        <li class="@routeis('admin.customers.index') active @endrouteis"><a class="nav-link"
                href="{{ route('admin.customers.index') }}"><i class="fas fa-columns"></i> <span>Customer List</span></a></li>

        <li class="menu-header">Products</li>
        <li class="@routeis('admin.products.index') active @endrouteis"><a class="nav-link"
                href="{{ route('admin.products.index') }}"><i class="fas fa-columns"></i> <span>Product List</span></a></li>
</aside>
