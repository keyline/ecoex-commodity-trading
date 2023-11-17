<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');

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
			$routes->match(['post'], "signup", "ApiController::signup");
			$routes->match(['post'], "forgot-password", "ApiController::forgotPassword");
			$routes->match(['post'], "validate-otp", "ApiController::validateOTP");
			$routes->match(['post'], "resend-otp", "ApiController::resendOtp");
			$routes->match(['post'], "reset-password", "ApiController::resetPassword");
		// authentication
		// after login

		// after login
	});
/* API */