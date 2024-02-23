<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/enquiry-request/(:any)', 'Home::enquiryRequest/$1');
$routes->get('/delete-account-request', 'Home::deleteAccountRequest');
$routes->post('/delete-account-request', 'Home::deleteAccountRequest');
$routes->post('/get-email-otp', 'Home::getEmailOTP');
$routes->post('/get-phone-otp', 'Home::getPhoneOTP');
/* ADMIN PANEL */
	$routes->group("admin", ["namespace" => "App\Controllers\Admin"], function($routes){
		// authentication
			$routes->match(['get', 'post'], "/", "User::login");
			$routes->match(['get', 'post'], "signout", "User::signout");
			$routes->match(['get', 'post'], "forgot-password", "User::forgotPassword");
			$routes->match(['get', 'post'], "verify-otp/(:any)", "User::verifyOtp/$1");
			$routes->match(['get', 'post'], "reset-password/(:any)", "User::resetPassword/$1");
		// authentication
		// dashboard
			$routes->match(['get', 'post'], "dashboard", "User::dashboard");
			$routes->match(['get', 'post'], "email-logs", "User::emailLogs");
			$routes->match(['get', 'post'], "email-logs-details/(:any)", "User::emailLogsDetails/$1");
			$routes->match(['get', 'post'], "login-logs", "User::loginLogs");
		// dashboard
		// settings
			$routes->match(['get', 'post'], "settings", "User::settings");
			$routes->match(['post'], "profile-settings", "User::profileSetting");
			$routes->match(['post'], "general-settings", "User::generalSetting");
			$routes->match(['post'], "change-password", "User::changePassword");
			$routes->match(['post'], "email-settings", "User::emailSetting");
			$routes->match(['post'], "sms-settings", "User::smsSetting");
			$routes->match(['post'], "footer-settings", "User::footerSetting");
			$routes->match(['post'], "seo-settings", "User::seoSetting");
			$routes->match(['post'], "payment-settings", "User::paymentSetting");
			$routes->match(['post'], "bank-settings", "User::bankSetting");
			$routes->match(['get','post'], "test-email", "User::testEmail");
		// settings
		// access & permission
			/* features */
				$routes->match(['get'], "features/list", "FeatureController::list");
				$routes->match(['get', 'post'], "features/add", "FeatureController::add");
				$routes->match(['get', 'post'], "features/edit/(:any)", "FeatureController::edit/$1");
				$routes->match(['get', 'post'], "features/delete/(:any)", "FeatureController::confirm_delete/$1");
				$routes->match(['get', 'post'], "features/change-status/(:any)", "FeatureController::change_status/$1");
			/* features */
			/* modules */
				$routes->match(['get'], "modules/list", "ModuleController::list");
				$routes->match(['get', 'post'], "modules/add", "ModuleController::add");
				$routes->match(['get', 'post'], "modules/edit/(:any)", "ModuleController::edit/$1");
				$routes->match(['get', 'post'], "modules/delete/(:any)", "ModuleController::confirm_delete/$1");
				$routes->match(['get', 'post'], "modules/change-status/(:any)", "ModuleController::change_status/$1");
			/* modules */
			/* roles */
				$routes->match(['get'], "roles/list", "RoleController::list");
				$routes->match(['get', 'post'], "roles/add", "RoleController::add");
				$routes->match(['get', 'post'], "roles/edit/(:any)", "RoleController::edit/$1");
				$routes->match(['get', 'post'], "roles/delete/(:any)", "RoleController::confirm_delete/$1");
				$routes->match(['get', 'post'], "roles/change-status/(:any)", "RoleController::change_status/$1");
			/* roles */
			/* admin sub users */
				$routes->match(['get'], "sub-users/list", "AdminSubUserController::list");
				$routes->match(['get', 'post'], "sub-users/add", "AdminSubUserController::add");
				$routes->match(['get', 'post'], "sub-users/edit/(:any)", "AdminSubUserController::edit/$1");
				$routes->match(['get', 'post'], "sub-users/delete/(:any)", "AdminSubUserController::confirm_delete/$1");
				$routes->match(['get', 'post'], "sub-users/change-status/(:any)", "AdminSubUserController::change_status/$1");
				$routes->match(['get', 'post'], "sub-users/send-credentials/(:any)", "AdminSubUserController::send_credentials/$1");
			/* admin sub users */
		// access & permission
		// master
			/* product category */
				$routes->match(['get'], "product-category/list", "ProductCategoryController::list");
				$routes->match(['get', 'post'], "product-category/add", "ProductCategoryController::add");
				$routes->match(['get', 'post'], "product-category/edit/(:any)", "ProductCategoryController::edit/$1");
				$routes->match(['get', 'post'], "product-category/delete/(:any)", "ProductCategoryController::confirm_delete/$1");
				$routes->match(['get', 'post'], "product-category/change-status/(:any)", "ProductCategoryController::change_status/$1");
			/* product category */
			/* products */
				$routes->match(['get'], "products/list", "ProductController::list");
				$routes->match(['get', 'post'], "products/add", "ProductController::add");
				$routes->match(['get', 'post'], "products/edit/(:any)", "ProductController::edit/$1");
				$routes->match(['get', 'post'], "products/delete/(:any)", "ProductController::confirm_delete/$1");
				$routes->match(['get', 'post'], "products/change-status/(:any)", "ProductController::change_status/$1");
			/* products */
			/* pending products */
				$routes->match(['get'], "pending-products/list", "PendingProductController::list");
				$routes->match(['get', 'post'], "pending-products/add", "PendingProductController::add");
				$routes->match(['get', 'post'], "pending-products/edit/(:any)", "PendingProductController::edit/$1");
				$routes->match(['get', 'post'], "pending-products/delete/(:any)", "PendingProductController::confirm_delete/$1");
				$routes->match(['get', 'post'], "pending-products/change-status/(:any)", "PendingProductController::change_status/$1");
			/* pending products */
			/* units */
				$routes->match(['get'], "units/list", "UnitController::list");
				$routes->match(['get', 'post'], "units/add", "UnitController::add");
				$routes->match(['get', 'post'], "units/edit/(:any)", "UnitController::edit/$1");
				$routes->match(['get', 'post'], "units/delete/(:any)", "UnitController::confirm_delete/$1");
				$routes->match(['get', 'post'], "units/change-status/(:any)", "UnitController::change_status/$1");
			/* units */
			/* states */
				$routes->match(['get'], "states/list", "StateController::list");
				$routes->match(['get', 'post'], "states/add", "StateController::add");
				$routes->match(['get', 'post'], "states/edit/(:any)", "StateController::edit/$1");
				$routes->match(['get', 'post'], "states/delete/(:any)", "StateController::confirm_delete/$1");
				$routes->match(['get', 'post'], "states/change-status/(:any)", "StateController::change_status/$1");
			/* states */
			/* districts */
				$routes->match(['get'], "districts/list", "DistrictController::list");
				$routes->match(['get', 'post'], "districts/add", "DistrictController::add");
				$routes->match(['get', 'post'], "districts/edit/(:any)", "DistrictController::edit/$1");
				$routes->match(['get', 'post'], "districts/delete/(:any)", "DistrictController::confirm_delete/$1");
				$routes->match(['get', 'post'], "districts/change-status/(:any)", "DistrictController::change_status/$1");
			/* districts */
			/* member type */
				$routes->match(['get'], "member-types/list", "MemberTypeController::list");
				$routes->match(['get', 'post'], "member-types/add", "MemberTypeController::add");
				$routes->match(['get', 'post'], "member-types/edit/(:any)", "MemberTypeController::edit/$1");
				$routes->match(['get', 'post'], "member-types/delete/(:any)", "MemberTypeController::confirm_delete/$1");
				$routes->match(['get', 'post'], "member-types/change-status/(:any)", "MemberTypeController::change_status/$1");
			/* member type */
			/* page */
				$routes->match(['get'], "pages/list", "PageController::list");
				$routes->match(['get', 'post'], "pages/add", "PageController::add");
				$routes->match(['get', 'post'], "pages/edit/(:any)", "PageController::edit/$1");
				$routes->match(['get', 'post'], "pages/delete/(:any)", "PageController::confirm_delete/$1");
				$routes->match(['get', 'post'], "pages/change-status/(:any)", "PageController::change_status/$1");
			/* page */
		// master
		// companies
			$routes->match(['get'], "companies/list", "CompanyController::list");
			$routes->match(['get', 'post'], "companies/add", "CompanyController::add");
			$routes->match(['get', 'post'], "companies/edit/(:any)", "CompanyController::edit/$1");
			$routes->match(['get', 'post'], "companies/view/(:any)", "CompanyController::view/$1");
			$routes->match(['get', 'post'], "companies/delete/(:any)", "CompanyController::confirm_delete/$1");
			$routes->match(['get', 'post'], "companies/change-status/(:any)", "CompanyController::change_status/$1");
			$routes->match(['get', 'post'], "companies/check-email", "CompanyController::check_email");
			$routes->match(['get', 'post'], "companies/check-phone", "CompanyController::check_phone");
			$routes->match(['get', 'post'], "companies/assign-category/(:any)", "CompanyController::assignCategory/$1");
			$routes->match(['get', 'post'], "companies/manage-item/(:any)", "CompanyController::manageItem/$1");
			$routes->match(['get', 'post'], "companies/approve-item", "CompanyController::approveItem");
			$routes->match(['get', 'post'], "companies/send-credentials/(:any)", "CompanyController::send_credentials/$1");
		// companies
		// plants
			$routes->match(['get'], "plants/list", "PlantController::list");
			$routes->match(['get', 'post'], "plants/add", "PlantController::add");
			$routes->match(['get', 'post'], "plants/edit/(:any)", "PlantController::edit/$1");
			$routes->match(['get', 'post'], "plants/view/(:any)", "PlantController::view/$1");
			$routes->match(['get', 'post'], "plants/delete/(:any)", "PlantController::confirm_delete/$1");
			$routes->match(['get', 'post'], "plants/change-status/(:any)", "PlantController::change_status/$1");
			$routes->match(['get', 'post'], "plants/check-email", "PlantController::check_email");
			$routes->match(['get', 'post'], "plants/check-phone", "PlantController::check_phone");
		// plants
		// vendors
			$routes->match(['get'], "vendors/list", "VendorController::list");
			$routes->match(['get', 'post'], "vendors/add", "VendorController::add");
			$routes->match(['get', 'post'], "vendors/edit/(:any)", "VendorController::edit/$1");
			$routes->match(['get', 'post'], "vendors/view/(:any)", "VendorController::view/$1");
			$routes->match(['get', 'post'], "vendors/delete/(:any)", "VendorController::confirm_delete/$1");
			$routes->match(['get', 'post'], "vendors/change-status/(:any)", "VendorController::change_status/$1");
			$routes->match(['get', 'post'], "vendors/check-email", "VendorController::check_email");
			$routes->match(['get', 'post'], "vendors/check-phone", "VendorController::check_phone");
		// vendors
		// delete account requests
			$routes->match(['get'], "delete-account-request/list", "DeleteAccountRequestController::list");
			$routes->match(['get', 'post'], "delete-account-request/delete/(:any)", "DeleteAccountRequestController::confirm_delete/$1");
			$routes->match(['get', 'post'], "delete-account-request/change-status/(:any)", "DeleteAccountRequestController::change_status/$1");
		// delete account requests
		// enquiry requests
			$routes->match(['get'], "enquiry-requests/list/(:any)", "EnquiryRequestController::list/$1");
			$routes->match(['get', 'post'], "enquiry-requests/view-detail/(:any)", "EnquiryRequestController::viewDetail/$1");
			$routes->match(['get', 'post'], "enquiry-requests/delete/(:any)/(:any)", "EnquiryRequestController::confirm_delete/$1/$2");
			$routes->match(['get', 'post'], "enquiry-requests/accept-request/(:any)", "EnquiryRequestController::accept_request/$1");
			$routes->match(['get', 'post'], "enquiry-requests/reject-request/(:any)", "EnquiryRequestController::reject_request/$1");
			$routes->match(['post'], "get-reject-modal", "EnquiryRequestController::getRejectModal");
			$routes->match(['post'], "get-image-modal", "EnquiryRequestController::getImageModal");
			$routes->match(['get', 'post'], "enquiry-requests/quotation-access/(:any)/(:any)", "EnquiryRequestController::quotation_access/$1/$2");
			$routes->match(['get', 'post'], "enquiry-requests/view-quotation-logs/(:any)/(:any)", "EnquiryRequestController::viewQuotationLogs/$1/$2");
			$routes->match(['get', 'post'], "enquiry-requests/vendor-allocation/(:any)/(:any)/(:any)", "EnquiryRequestController::vendorAllocation/$1/$2/$3");

			$routes->match(['get'], "enquiry-requests/process-request-list/(:any)", "EnquiryRequestController::processRequestList/$1");
		// enquiry requests
		// notifications
			$routes->match(['get'], "notifications/list", "NotificationController::list");
			$routes->match(['get', 'post'], "notifications/add", "NotificationController::add");
			$routes->match(['get', 'post'], "notifications/edit/(:any)", "NotificationController::edit/$1");
			$routes->match(['get', 'post'], "notifications/delete/(:any)", "NotificationController::confirm_delete/$1");
			$routes->match(['get', 'post'], "notifications/change-status/(:any)", "NotificationController::change_status/$1");
			$routes->match(['get', 'post'], "notifications/send/(:any)", "NotificationController::send/$1");
			$routes->match(['get'], "notifications/list_from_app", "NotificationController::list_from_app");
		// notifications
	});
/* ADMIN PANEL */
/* API */
	$routes->group("api", ["namespace" => "App\Controllers\Api"], function($routes){
		// before login
			$routes->match(['post'], "get-app-setting", "ApiController::getAppSetting");
			$routes->match(['post'], "get-static-pages", "ApiController::getStaticPages");
			$routes->match(['post'], "get-product-category", "ApiController::getProductCategory");
			$routes->match(['post'], "get-member-type", "ApiController::getMemberType");
		// before login
		// authentication
			$routes->match(['post'], "get-company-details", "ApiController::getCompanyDetails");
			$routes->match(['post'], "get-company-details2", "ApiController::getCompanyDetails2");
			$routes->match(['post'], "signup", "ApiController::signup");
			$routes->match(['post'], "signup-otp-resend", "ApiController::signupOTPResend");
			$routes->match(['post'], "signup-otp-verify", "ApiController::signupOTPVerify");

			$routes->match(['post'], "forgot-password", "ApiController::forgotPassword");
			$routes->match(['post'], "validate-otp", "ApiController::validateOTP");
			$routes->match(['post'], "resend-otp", "ApiController::resendOtp");
			$routes->match(['post'], "reset-password", "ApiController::resetPassword");

			$routes->match(['post'], "signin", "ApiController::signin");
			$routes->match(['post'], "signin-with-mobile", "ApiController::signinWithMobile");
			$routes->match(['post'], "signin-validate-mobile", "ApiController::signinValidateMobile");
		// authentication
		// after login
			$routes->match(['post'], "signout", "ApiController::signout");
			$routes->match(['post'], "change-password", "ApiController::changePassword");
			$routes->match(['post'], "get-profile", "ApiController::getProfile");
			$routes->match(['post'], "update-profile", "ApiController::updateProfile");
			$routes->match(['post'], "send-email-otp", "ApiController::sendEmailOTP");
			$routes->match(['post'], "verify-email", "ApiController::verifyEmail");
			$routes->match(['post'], "send-mobile-otp", "ApiController::sendMobileOTP");
			$routes->match(['post'], "verify-mobile", "ApiController::verifyMobile");
			$routes->match(['post'], "delete-account", "ApiController::deleteAccount");
			$routes->match(['post'], "update-profile-image", "ApiController::updateProfileImage");
			
			$routes->match(['post'], "get-product", "ApiController::getProduct");
			$routes->match(['post'], "get-hsncode-product", "ApiController::getHSNCodeProduct");
			$routes->match(['post'], "get-notifications", "ApiController::getNotifications");

			/* plant panel */
				$routes->match(['post'], "dashboard", "ApiController::dashboard");
				// process request
					$routes->match(['get', 'post'], "get-units", "ApiController::getUnits");
					$routes->match(['get', 'post'], "process-request-list", "ApiController::processRequestList");
					$routes->match(['get', 'post'], "process-request-add", "ApiController::processRequestAdd");
					$routes->match(['get', 'post'], "process-request-delete", "ApiController::processRequestDelete");
					$routes->match(['get', 'post'], "process-request-edit", "ApiController::processRequestEdit");
					$routes->match(['get', 'post'], "process-request-update", "ApiController::processRequestUpdate");
				// process request
				// completed request
					$routes->match(['get', 'post'], "completed-request-list", "ApiController::completedRequestList");
				// completed request
				// rejected request
					$routes->match(['get', 'post'], "rejected-request-list", "ApiController::rejectedRequestList");
					$routes->match(['get', 'post'], "convert-rejected-to-pending", "ApiController::convertRejectedToPending");
				// rejected request
			/* plant panel */
			/* vendor panel */
				$routes->match(['post'], "vendor-dashboard", "ApiController::vendorDashboard");
				// pending request
					$routes->match(['post'], "pending-quotation-request-list", "ApiController::vendorPendingRequestList");
					$routes->match(['post'], "pending-quotation-request-accept-reject", "ApiController::vendorPendingRequestAcceptReject");
					$routes->match(['get', 'post'], "get-enquiry-request-for-vendor-quotation", "ApiController::getEnquiryRequestForVendorQuotation");
				// pending request
				// accepted request
					$routes->match(['post'], "accepted-quotation-request-list", "ApiController::vendorAcceptedRequestList");
				// accepted request
				// completed request
					$routes->match(['post'], "completed-quotation-request-list", "ApiController::vendorCompletedRequestList");
				// completed request
				// rejected request
					$routes->match(['post'], "rejected-quotation-request-list", "ApiController::vendorRejectedRequestList");
				// rejected request
				// quotation
					$routes->match(['post'], "submit-quotation", "ApiController::submitQuotation");
				// quotation
				// assigned request
					$routes->match(['post'], "vendor-process-request", "ApiController::vendorProcessRequest");
				// assigned request
			/* vendor panel */
		// after login
	});
/* API */