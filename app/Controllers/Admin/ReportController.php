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
            $response       = [];
            $requestData    = $this->request->getGet();
            // pr($requestData,0);
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
            $monthList          = $this->getMonthsInRange($from_date, $to_date);
            if(!empty($monthList)){
                for($m=0;$m<count($monthList);$m++){
                    $monthYear          = $monthList[$m]['year'].'-'.$monthList[$m]['month'];
                    $fdate              = $monthList[$m]['year'].'-'.$monthList[$m]['month'].'-01';
                    $tdate              = $monthList[$m]['year'].'-'.$monthList[$m]['month'].'-31';
                    echo $sql           = "SELECT id,enquiry_no,plant_id FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$fdate' AND created_at <= '$tdate' group by plant_id";
                    $enquires           = $this->db->query($sql)->getNumRows();
                    $response[]       = [
                        'month_year_name' => $this->common_model->monthName($monthList[$m]['month']).'-'.$monthList[$m]['year']
                    ];
                    pr($enquires,0);
                    if($enquires){
                        foreach($enquires as $enquiry){

                        }
                    }
                }
            }
            pr($response);
        }

        echo $this->layout_after_login($title,$page_name,$data);
    }
    public function getMonthsInRange($startDate, $endDate)
    {
        $months = array();

        while (strtotime($startDate) <= strtotime($endDate)) {
            $months[] = array(
                'year' => date('Y', strtotime($startDate)),
                'month' => date('m', strtotime($startDate)),
            );

            // Set date to 1 so that new month is returned as the month changes.
            $startDate = date('01 M Y', strtotime($startDate . '+ 1 month'));
        }

        return $months;
    }
}