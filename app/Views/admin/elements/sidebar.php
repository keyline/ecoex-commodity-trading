<?php
$baseUrl    = base_url();
if($baseUrl == 'https://commodity.ecoex.market/'){
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(2);
} else {
    $currentLink    = current_url();
    $uri            = new \CodeIgniter\HTTP\URI($currentLink);
    $pageSegment    = $uri->getSegment(3);
}
// echo $pageSegment;
?>
<style type="text/css">
    /*.active{
        color:green !important;
    }*/
</style>
<ul class="sidebar-nav" id="sidebar-nav">
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'dashboard')?'active':'')?>" href="<?=base_url('admin/dashboard')?>">
            <i class="fa fa-home"></i>
            <span>Dashboard</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'':'collapsed')?> <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'active':'')?>" data-bs-target="#access-nav" data-bs-toggle="collapse" href="#">
            <i class="fa fa-lock"></i><span>Access & Permission</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="access-nav" class="nav-content collapse <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'show':'')?>" data-bs-parent="#sidebar-nav">
            <li>
                <a class="<?=(($pageSegment == 'features')?'active':'')?>" href="<?=base_url('admin/features/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Features</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'modules')?'active':'')?>" href="<?=base_url('admin/modules/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Modules</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'roles')?'active':'')?>" href="<?=base_url('admin/roles/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Roles</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'sub-users')?'active':'')?>" href="<?=base_url('admin/sub-users/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Admin Sub Users</span>
                </a>
            </li>
        </ul>
    </li>
    
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'':'collapsed')?> <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'active':'')?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
            <i class="fa fa-database"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-nav" class="nav-content collapse <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'show':'')?>" data-bs-parent="#sidebar-nav">
            <li>
                <a class="<?=(($pageSegment == 'product-category')?'active':'')?>" href="<?=base_url('admin/product-category/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Product Category</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'products')?'active':'')?>" href="<?=base_url('admin/products/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Products</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'units')?'active':'')?>" href="<?=base_url('admin/units/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Units</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'states')?'active':'')?>" href="<?=base_url('admin/states/list')?>">
                    <i class="fa fa-arrow-right"></i><span>States</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'districts')?'active':'')?>" href="<?=base_url('admin/districts/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Districts</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'member-types')?'active':'')?>" href="<?=base_url('admin/member-types/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Vendor Types</span>
                </a>
            </li>
            <li>
                <a class="<?=(($pageSegment == 'pages')?'active':'')?>" href="<?=base_url('admin/pages/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Pages</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'vendors')?'active':'')?>" href="<?=base_url('admin/vendors/list')?>">
            <i class="fa fa-users"></i>
            <span>Vendors</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'companies')?'active':'')?>" href="<?=base_url('admin/companies/list')?>">
            <i class="fa fa-users"></i>
            <span>Companies</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'email-logs')?'active':'')?>" href="<?=base_url('admin/email-logs')?>">
            <i class="fa fa-envelope"></i>
            <span>Email Logs</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'login-logs')?'active':'')?>" href="<?=base_url('admin/login-logs')?>">
            <i class="fa fa-list"></i>
            <span>Login Logs</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'settings')?'active':'')?>" href="<?=base_url('admin/settings')?>">
            <i class="fa fa-list"></i>
            <span>Settings</span>
        </a>
    </li>
</ul>