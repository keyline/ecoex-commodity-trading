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
$segmentCount = $uri->getTotalSegments();
if($segmentCount > 3){
    $paramerId = $uri->getSegment(5);
} else {
    $paramerId = '';
}
$step0_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 0]);
$step1_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 1]);
$step2_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 2]);
$step3_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 3]);
$step4_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 4]);
$step5_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 5]);
$step6_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 6]);
$step7_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 7]);
$step8_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 8]);
$step9_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 9]);
?>
<style type="text/css">
    a.nav-link.active {
        color: green;
    }
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
        <a class="nav-link <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'':'collapsed')?> <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'active':'')?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
            <i class="fa fa-database"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="master-nav" class="nav-content collapse <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'show':'')?>" data-bs-parent="#sidebar-nav">
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
                <a class="<?=(($pageSegment == 'pending-products')?'active':'')?>" href="<?=base_url('admin/pending-products/list')?>">
                    <i class="fa fa-arrow-right"></i><span>Pending Products</span>
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
        <a class="nav-link <?=(($pageSegment == 'companies')?'active':'')?>" href="<?=base_url('admin/companies/list')?>">
            <i class="fa fa-building"></i>
            <span>Companies</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'plants')?'active':'')?>" href="<?=base_url('admin/plants/list')?>">
            <i class="fa fa-industry"></i>
            <span>Plants</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'vendors')?'active':'')?>" href="<?=base_url('admin/vendors/list')?>">
            <i class="fa fa-users"></i>
            <span>Vendors</span>
        </a>
    </li>

    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'enquiry-requests')?'':'collapsed')?> <?=(($pageSegment == 'enquiry-requests')?'active':'')?>" data-bs-target="#enquiry-nav" data-bs-toggle="collapse" href="#">
            <i class="fa fa-question-circle"></i><span>Enquiry Requests</span><i class="bi bi-chevron-down ms-auto"></i>
        </a>
        <ul id="enquiry-nav" class="nav-content collapse <?=(($pageSegment == 'enquiry-requests')?'show':'')?>" data-bs-parent="#sidebar-nav">
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 0))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(0))?>">
                    <i class="fa fa-arrow-right"></i><span>Pending (<?=$step0_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 1))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(1))?>">
                    <i class="fa fa-arrow-right"></i><span>Sent/Submitted (<?=$step1_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 2))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(2))?>">
                    <i class="fa fa-arrow-right"></i><span>Accepted/Rejected (<?=$step2_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 3))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(3))?>">
                    <i class="fa fa-arrow-right"></i><span>Pickup (<?=$step3_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 4))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(4))?>">
                    <i class="fa fa-arrow-right"></i><span>Vehicle Placed (<?=$step4_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 5))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(5))?>">
                    <i class="fa fa-arrow-right"></i><span>Vehicle Ready Despatch (<?=$step5_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 6))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(6))?>">
                    <i class="fa fa-arrow-right"></i><span>Material Lifted (<?=$step6_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 7))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(7))?>">
                    <i class="fa fa-arrow-right"></i><span>Invoiced (<?=$step7_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 8))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(8))?>">
                    <i class="fa fa-arrow-right"></i><span>Completed (<?=$step8_count?>)</span>
                </a>
            </li>
            <li>
                <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 9))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(9))?>">
                    <i class="fa fa-arrow-right"></i><span>Rejected (<?=$step9_count?>)</span>
                </a>
            </li>
        </ul>
    </li>
    <li class="nav-item">
        <a class="nav-link <?=(($pageSegment == 'notifications')?'active':'')?>" href="<?=base_url('admin/notifications/list')?>">
            <i class="fa fa-envelope"></i>
            <span>Notifications</span>
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
            <i class="fa fa-gear"></i>
            <span>Settings</span>
        </a>
    </li>
</ul>