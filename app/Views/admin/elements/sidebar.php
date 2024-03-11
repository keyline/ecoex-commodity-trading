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
$userType           = $session->user_type;
$userId             = $session->user_id;
$company_id         = $session->company_id;
$groupBy[0]         = 'sub_enquiry_no';
if($userType == 'MA'){
    $step0_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 0]);
    $step1_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 1]);
    $step2_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 2]);

    $step3_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 3.3], '', '', $groupBy);
    $step4_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 4.4], '', '', $groupBy);
    $step5_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 5.5], '', '', $groupBy);
    $step6_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 6.6], '', '', $groupBy);
    $step7_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 7.7], '', '', $groupBy);
    $step8_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 8.8], '', '', $groupBy);
    $step9_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 9.9], '', '', $groupBy);
    $step10_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 10.10], '', '', $groupBy);
    $step11_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 11.11], '', '', $groupBy);
    $step12_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 12.12], '', '', $groupBy);

    $step13_count       = $common_model->find_data('ecomm_enquires', 'count', ['status' => 13]);
} elseif($userType == 'U'){
    $step0_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 0]);
    $step1_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 1]);
    $step2_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 2]);

    $step3_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 3.3], '', '', $groupBy);
    $step4_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 4.4], '', '', $groupBy);
    $step5_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 5.5], '', '', $groupBy);
    $step6_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 6.6], '', '', $groupBy);
    $step7_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 7.7], '', '', $groupBy);
    $step8_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 8.8], '', '', $groupBy);
    $step9_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 9.9], '', '', $groupBy);
    $step10_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 10.10], '', '', $groupBy);
    $step11_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 11.11], '', '', $groupBy);
    $step12_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 12.12], '', '', $groupBy);

    $step13_count       = $common_model->find_data('ecomm_enquires', 'count', ['status' => 13]);
} else {
    $step0_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 0, 'company_id' => $company_id]);
    $step1_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 1, 'company_id' => $company_id]);
    $step2_count        = $common_model->find_data('ecomm_enquires', 'count', ['status' => 2, 'company_id' => $company_id]);

    $step3_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 3.3, 'company_id' => $company_id], '', '', $groupBy);
    $step4_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 4.4, 'company_id' => $company_id], '', '', $groupBy);
    $step5_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 5.5, 'company_id' => $company_id], '', '', $groupBy);
    $step6_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 6.6, 'company_id' => $company_id], '', '', $groupBy);
    $step7_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 7.7, 'company_id' => $company_id], '', '', $groupBy);
    $step8_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 8.8, 'company_id' => $company_id], '', '', $groupBy);
    $step9_count        = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 9.9, 'company_id' => $company_id], '', '', $groupBy);
    $step10_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 10.10, 'company_id' => $company_id], '', '', $groupBy);
    $step11_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 11.11, 'company_id' => $company_id], '', '', $groupBy);
    $step12_count       = $common_model->find_data('ecomm_sub_enquires', 'count', ['status' => 12.12, 'company_id' => $company_id], '', '', $groupBy);

    $step13_count       = $common_model->find_data('ecomm_enquires', 'count', ['status' => 13, 'company_id' => $company_id]);
}
?>
<style type="text/css">
    a.nav-link.active {
        color: green;
    }
</style>
<ul class="sidebar-nav" id="sidebar-nav">
    <?php if($common_model->checkModuleAccess(1)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'dashboard')?'active':'')?>" href="<?=base_url('admin/dashboard')?>">
                <i class="fa fa-home"></i>
                <span>Dashboard</span>
            </a>
        </li>
    <?php }?>
    <?php if($userType == 'MA'){?>
        <?php if(($common_model->checkModuleAccess(3)) || ($common_model->checkModuleAccess(4)) || ($common_model->checkModuleAccess(5)) || ($common_model->checkModuleAccess(6))){?>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'':'collapsed')?> <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'active':'')?>" data-bs-target="#access-nav" data-bs-toggle="collapse" href="#">
                    <i class="fa fa-lock"></i><span>Access & Permission</span><i class="bi bi-chevron-down ms-auto"></i>
                </a>
                <ul id="access-nav" class="nav-content collapse <?=(($pageSegment == 'features' || $pageSegment == 'modules' || $pageSegment == 'roles' || $pageSegment == 'sub-users')?'show':'')?>" data-bs-parent="#sidebar-nav">
                    <?php if($common_model->checkModuleAccess(3)){?>
                        <li>
                            <a class="<?=(($pageSegment == 'features')?'active':'')?>" href="<?=base_url('admin/features/list')?>">
                                <i class="fa fa-arrow-right"></i><span>Features</span>
                            </a>
                        </li>
                    <?php }?>
                    <?php if($common_model->checkModuleAccess(4)){?>
                        <li>
                            <a class="<?=(($pageSegment == 'modules')?'active':'')?>" href="<?=base_url('admin/modules/list')?>">
                                <i class="fa fa-arrow-right"></i><span>Modules</span>
                            </a>
                        </li>
                    <?php }?>
                    <?php if($common_model->checkModuleAccess(5)){?>
                        <li>
                            <a class="<?=(($pageSegment == 'roles')?'active':'')?>" href="<?=base_url('admin/roles/list')?>">
                                <i class="fa fa-arrow-right"></i><span>Roles</span>
                            </a>
                        </li>
                    <?php }?>
                    <?php if($common_model->checkModuleAccess(6)){?>
                        <li>
                            <a class="<?=(($pageSegment == 'sub-users')?'active':'')?>" href="<?=base_url('admin/sub-users/list')?>">
                                <i class="fa fa-arrow-right"></i><span>Admin Sub Users</span>
                            </a>
                        </li>
                    <?php }?>
                </ul>
            </li>
        <?php }?>
    <?php }?>
    
    <?php if(($common_model->checkModuleAccess(8)) || ($common_model->checkModuleAccess(9)) || ($common_model->checkModuleAccess(10)) || ($common_model->checkModuleAccess(11)) || ($common_model->checkModuleAccess(12)) || ($common_model->checkModuleAccess(13))){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'':'collapsed')?> <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'active':'')?>" data-bs-target="#master-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-database"></i><span>Masters</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="master-nav" class="nav-content collapse <?=(($pageSegment == 'product-category' || $pageSegment == 'products' || $pageSegment == 'pending-products' || $pageSegment == 'units' || $pageSegment == 'states' || $pageSegment == 'districts' || $pageSegment == 'member-types' || $pageSegment == 'pages')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <?php if($common_model->checkModuleAccess(8)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'product-category')?'active':'')?>" href="<?=base_url('admin/product-category/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Item Category</span>
                        </a>
                    </li>
                <?php }?>
                <!-- <li>
                    <a class="<?=(($pageSegment == 'products')?'active':'')?>" href="<?=base_url('admin/products/list')?>">
                        <i class="fa fa-arrow-right"></i><span>Products</span>
                    </a>
                </li>
                <li>
                    <a class="<?=(($pageSegment == 'pending-products')?'active':'')?>" href="<?=base_url('admin/pending-products/list')?>">
                        <i class="fa fa-arrow-right"></i><span>Pending Products</span>
                    </a>
                </li> -->
                <?php if($common_model->checkModuleAccess(9)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'units')?'active':'')?>" href="<?=base_url('admin/units/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Units</span>
                        </a>
                    </li>
                <?php }?>
                <?php if($common_model->checkModuleAccess(10)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'states')?'active':'')?>" href="<?=base_url('admin/states/list')?>">
                            <i class="fa fa-arrow-right"></i><span>States</span>
                        </a>
                    </li>
                <?php }?>
                <?php if($common_model->checkModuleAccess(11)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'districts')?'active':'')?>" href="<?=base_url('admin/districts/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Districts</span>
                        </a>
                    </li>
                <?php }?>
                <?php if($common_model->checkModuleAccess(12)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'member-types')?'active':'')?>" href="<?=base_url('admin/member-types/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Vendor Types</span>
                        </a>
                    </li>
                <?php }?>
                <?php if($common_model->checkModuleAccess(13)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'pages')?'active':'')?>" href="<?=base_url('admin/pages/list')?>">
                            <i class="fa fa-arrow-right"></i><span>Pages</span>
                        </a>
                    </li>
                <?php }?>
            </ul>
        </li>
    <?php }?>
    
    <?php if($common_model->checkModuleAccess(14)){?>
        <li class="nav-item">
            <?php if($userType == 'MA'){?>
                <a class="nav-link <?=(($pageSegment == 'companies')?'active':'')?>" href="<?=base_url('admin/companies/list')?>">
            <?php } elseif($userType == 'U'){?>
                <a class="nav-link <?=(($pageSegment == 'companies')?'active':'')?>" href="<?=base_url('admin/companies/list')?>">
            <?php } else {?>
                <a class="nav-link <?=(($pageSegment == 'companies')?'active':'')?>" href="<?=base_url('admin/companies/edit/'.encoded($company_id))?>">
            <?php }?>
                <i class="fa fa-building"></i>
                <span><?=(($userType == 'COMPANY')?'Settings':'Companies')?></span>
            </a>
        </li>
        <?php if($userType == 'COMPANY'){?>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'companies/assign-category')?'active':'')?>" href="<?=base_url('admin/companies/assign-category/'.encoded($company_id))?>">
                    <i class="fa fa-list-alt"></i><span>Item Categories</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?=(($pageSegment == 'companies/manage-item')?'active':'')?>" href="<?=base_url('admin/companies/manage-item/'.encoded($company_id))?>">
                    <i class="fa-solid fa-list"></i><span>Items</span>
                </a>
            </li>
        <?php }?>
    <?php }?>
    <?php if($common_model->checkModuleAccess(15)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'plants')?'active':'')?>" href="<?=base_url('admin/plants/list')?>">
                <i class="fa fa-industry"></i>
                <span>Plants</span>
            </a>
        </li>
    <?php }?>
    
    <?php if($common_model->checkModuleAccess(16)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'vendors')?'active':'')?>" href="<?=base_url('admin/vendors/list')?>">
                <i class="fa fa-users"></i>
                <span>Vendors</span>
            </a>
        </li>
    <?php }?>


    <?php if($common_model->checkModuleAccess(17)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'delete-account-request')?'active':'')?>" href="<?=base_url('admin/delete-account-request/list')?>">
                <i class="fa fa-trash"></i>
                <span>Delete Account Requests</span>
            </a>
        </li>
    <?php }?>
    <?php if($common_model->checkModuleAccess(23)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'enquiry-requests')?'':'collapsed')?> <?=(($pageSegment == 'enquiry-requests')?'active':'')?>" data-bs-target="#enquiry-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-question-circle"></i><span>Enquiry Requests</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="enquiry-nav" class="nav-content collapse <?=(($pageSegment == 'enquiry-requests')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 0))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(0))?>">
                        <i class="fa fa-arrow-right"></i><span>Request Submitted (<?=$step0_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 1))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(1))?>">
                        <i class="fa fa-arrow-right"></i><span>Accept Request (<?=$step1_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 2))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(2))?>">
                        <i class="fa fa-arrow-right"></i><span>Vendor Allocated (<?=$step2_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 3.3))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(3.3))?>">
                        <i class="fa fa-arrow-right"></i><span>Vendor Assigned (<?=$step3_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 4.4))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(4.4))?>">
                        <i class="fa fa-arrow-right"></i><span>Pickup Scheduled (<?=$step4_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 5.5))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(5.5))?>">
                        <i class="fa fa-arrow-right"></i><span>Vehicle Placed (<?=$step5_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 6.6))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(6.6))?>">
                        <i class="fa fa-arrow-right"></i><span>Material Weighed (<?=$step6_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 7.7))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(7.7))?>">
                        <i class="fa fa-arrow-right"></i><span>Invoice From HO (<?=$step7_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 8.8))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(8.8))?>">
                        <i class="fa fa-arrow-right"></i><span>Invoice to Vendor (<?=$step8_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 9.9))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(9.9))?>">
                        <i class="fa fa-arrow-right"></i><span>Payment received from Vendor (<?=$step9_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 10.10))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(10.10))?>">
                        <i class="fa fa-arrow-right"></i><span>Vehicle Dispatched (<?=$step10_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 11))?'active':'')?>" href="javascript:void(0);">
                        <i class="fa fa-arrow-right"></i><span>Payment to HO (<?=$step11_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 12.12))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/process-request-list/'.encoded(12.12))?>">
                        <i class="fa fa-arrow-right"></i><span>Order Complete (<?=$step12_count?>)</span>
                    </a>
                </li>
                <li>
                    <a class="<?=((($pageSegment == 'enquiry-requests') && (decoded($paramerId) == 13))?'active':'')?>" href="<?=base_url('admin/enquiry-requests/list/'.encoded(13))?>">
                        <i class="fa fa-arrow-right"></i><span>Reject Request (<?=$step13_count?>)</span>
                    </a>
                </li>
            </ul>
        </li>
    <?php }?>
    <?php if(($common_model->checkModuleAccess(19)) || ($common_model->checkModuleAccess(20))){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'':'collapsed')?> <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'active':'')?>" data-bs-target="#notification-nav" data-bs-toggle="collapse" href="#">
                <i class="fa fa-bell"></i><span>Notifications</span><i class="bi bi-chevron-down ms-auto"></i>
            </a>
            <ul id="notification-nav" class="nav-content collapse <?=(($pageSegment == 'notifications' || $pageSegment == 'notifications')?'show':'')?>" data-bs-parent="#sidebar-nav">
                <?php if($common_model->checkModuleAccess(19)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'notifications')?'active':'')?>" href="<?=base_url('admin/notifications/list')?>">
                            <i class="fa fa-arrow-right"></i><span>From Admin</span>
                        </a>
                    </li>
                <?php }?>
                <?php if($common_model->checkModuleAccess(20)){?>
                    <li>
                        <a class="<?=(($pageSegment == 'notifications')?'active':'')?>" href="<?=base_url('admin/notifications/list_from_app')?>">
                            <i class="fa fa-arrow-right"></i><span>From App</span>
                        </a>
                    </li>
                <?php }?>
            </ul>
        </li>
    <?php }?>
    <?php if($common_model->checkModuleAccess(21)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'email-logs')?'active':'')?>" href="<?=base_url('admin/email-logs')?>">
                <i class="fa fa-envelope"></i>
                <span>Email Logs</span>
            </a>
        </li>
    <?php }?>
    <?php if($common_model->checkModuleAccess(22)){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'login-logs')?'active':'')?>" href="<?=base_url('admin/login-logs')?>">
                <i class="fa fa-list"></i>
                <span>Login Logs</span>
            </a>
        </li>
    <?php }?>
    <?php if($userType == 'MA'){?>
        <li class="nav-item">
            <a class="nav-link <?=(($pageSegment == 'settings')?'active':'')?>" href="<?=base_url('admin/settings')?>">
                <i class="fa fa-gear"></i>
                <span>Settings</span>
            </a>
        </li>
    <?php }?>
</ul>