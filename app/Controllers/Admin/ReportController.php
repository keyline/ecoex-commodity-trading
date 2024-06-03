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
    public function analyticsReport()
    {
        $data['moduleDetail']       = $this->data;
        
        $title                      = 'Manage Analytics Reports';
        $page_name                  = 'reports/analytics-report';
        $data['search_company_id']  = '';
        $data['search_day_id']      = '';
        $data['is_date_range']      = '';
        $data['search_range_from']  = '';
        $data['search_range_to']    = '';
        $data['companies']          = $this->common_model->find_data('ecoex_companies', 'array', ['type' => 'COMPANY', 'status>=' => 1, 'status<=' => 2], 'id,company_name');
        $data['response']           = [];

        if($this->request->getGet('mode') == 'advance_search'){
            $requestData = $this->request->getGet();
            $search_company_id      = $requestData['search_company_id'];
            if(array_key_exists('is_date_range', $requestData)){
                $search_range_from  = explode("-", $requestData['search_range_from']);
                $search_range_to    = explode("-", $requestData['search_range_to']);
                $from_date          = $search_range_from[0] . '-'.$search_range_from[1].'-01';
                $to_date            = $search_range_to[0] . '-'.$search_range_to[1].'-31';
            } else {
                $search_day_id      = $requestData['search_day_id'];
                if($search_day_id == 'this_month'){
                    $from_date  = date('Y') . '-' . date('m').'-01';
                    $to_date    = date('Y') . '-' . date('m').'-31';
                } elseif($search_day_id == 'last_month'){
                    $from_date  = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
                    $to_date    = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
                }
            }
            echo $sql = "SELECT id,enquiry_no FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$from_date' AND created_at <= '$to_date'";
            $enquires           = $this->db->query($sql)->getResult();
            echo $from_date . '||' . $to_date;
            pr($enquires);
        }

        echo $this->layout_after_login($title,$page_name,$data);
    }
}