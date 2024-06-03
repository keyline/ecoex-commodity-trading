<?php
namespace App\Controllers\admin;
use App\Controllers\BaseController;
use App\Models\CommonModel;
class ReportController extends BaseController {

    private $model;  //This can be accessed by all class methods
	public function __construct()
    {
        $session = \Config\Services::session();
        if(!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }
        $model = new CommonModel();
        $this->data = array(
            'model'                 => $model,
            'session'               => $session,
            'title'                 => 'Reports',
            'controller_route'      => 'reports',
            'controller'            => 'ReportController',
            'table_name'            => 'ecomm_units',
            'primary_key'           => 'id'
        );
    }
    public function industrialCommodityReport()
    {
        $data['moduleDetail']       = $this->data;
        
        $title                      = 'Manage Industrial Commodity Reports';
        $page_name                  = 'reports/industrial-commodity-report';
        $data['search_company_id']  = '';
        $data['search_day_id']      = '';
        $data['is_date_range']      = '';
        $data['search_range_from']  = '';
        $data['search_range_to']    = '';
        $data['companies']          = $this->common_model->find_data('ecoex_companies', 'array', ['type' => 'COMPANY', 'status>=' => 1, 'status<=' => 2], 'id,company_name');
        echo $this->layout_after_login($title,$page_name,$data);
    }
}