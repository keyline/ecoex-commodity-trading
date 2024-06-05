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
        $data['moduleDetail']               = $this->data;
        
        $title                              = 'Manage Analytics Reports';
        $page_name                          = 'reports/analytics-report';
        
        $data['companies']                  = $this->common_model->find_data('ecoex_companies', 'array', ['type' => 'COMPANY', 'status>=' => 1, 'status<=' => 2], 'id,company_name');
        $data['is_search']                  = 0;
        $data['search_day_id']              = '';
        $data['is_date_range']              = 0;
        $data['search_company_id']          = '';
        $data['search_range_from']          = '';
        $data['search_range_to']            = '';
        $data['response']                   = [];

        if($this->request->getGet('mode') == 'advance_search'){
            $records        = [];
            $requestData    = $this->request->getGet();
            $search_company_id      = $requestData['search_company_id'];
            $getCompany             = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $search_company_id]);
            if(array_key_exists('is_date_range', $requestData)){
                $search_range_from  = explode("-", $requestData['search_range_from']);
                $search_range_to    = explode("-", $requestData['search_range_to']);
                $currentMonth       = (int)$search_range_to[1];
                $lastDay            = lastdayMonth($currentMonth);
                $from_date          = $search_range_from[0] . '-'.$search_range_from[1].'-01';
                $to_date            = $search_range_to[0] . '-'.$search_range_to[1].'-'.$lastDay;
                $is_date_range      = 1;
                $graph_title        = (($getCompany)?$getCompany->company_name:'')." ".$this->common_model->monthShortName($search_range_from[1])."-".$search_range_from[0]." to ".$this->common_model->monthShortName($search_range_to[1])."-".$search_range_to[0];
            } else {
                $search_day_id      = $requestData['search_day_id'];
                if($search_day_id == 'this_month'){
                    $currentMonth       = (int)date('m');
                    $lastDay            = lastdayMonth($currentMonth);
                    $from_date          = date('Y') . '-' . date('m').'-01';
                    $to_date            = date('Y') . '-' . date('m').'-'.$lastDay;
                    $graph_title        = (($getCompany)?$getCompany->company_name:'')." ".$this->common_model->monthShortName(date('m'))."-".date('Y');
                } elseif($search_day_id == 'last_month'){
                    $from_date          = date("Y-m-d", mktime(0, 0, 0, date("m")-1, 1));
                    $to_date            = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
                    $graph_title        = (($getCompany)?$getCompany->company_name:'')." ".$this->common_model->monthShortName(date("m", mktime(0, 0, 0, date("m")-1, 1)))."-".date('Y');
                }
                $is_date_range      = 0;
            }
            $monthList          = $this->getMonthsInRange($from_date, $to_date);
            if(!empty($monthList)){
                for($m=0;$m<count($monthList);$m++){
                    $currentMonth       = (int)$monthList[$m]['month'];
                    $lastDay            = lastdayMonth($currentMonth);
                    $monthYear          = $monthList[$m]['year'].'-'.$monthList[$m]['month'];
                    $fdate              = $monthList[$m]['year'].'-'.$monthList[$m]['month'].'-01';
                    $tdate              = $monthList[$m]['year'].'-'.$monthList[$m]['month'].'-'.$lastDay;
                    $sql                = "SELECT id,enquiry_no,plant_id FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$fdate' AND created_at <= '$tdate' group by plant_id";
                    $plantCount         = $this->db->query($sql)->getNumRows();
                    $enquires           = $this->db->query("SELECT id FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$fdate' AND created_at <= '$tdate'")->getResult();
                    $vehicles           = [];
                    if($enquires){
                        foreach($enquires as $enquiry){
                            $subEnquiries = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enquiry->id], 'vehicle_registration_nos');
                            if($subEnquiries){
                                foreach($subEnquiries as $subEnquiry){
                                    $vehicle_registration_nos = json_decode($subEnquiry->vehicle_registration_nos);
                                    if(!empty($vehicle_registration_nos)){
                                        for($v=0;$v<count($vehicle_registration_nos);$v++){
                                            if(!in_array($vehicle_registration_nos[$v], $vehicles)){
                                                $vehicles[] = $vehicle_registration_nos[$v];
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                    $records[]         = [
                        'month_year_name'   => "'".$this->common_model->monthShortName($monthList[$m]['month'])."-".$monthList[$m]['year']."'",
                        'scrap_qty'         => $plantCount,
                        'no_of_plant'       => $plantCount,
                        'vehicle_count'     => count($vehicles)
                    ];
                }
            }
            $response = [
                'graph_title'       => $graph_title,
                'records'           => $records,
            ];
            // pr($response);
            $data['is_search']                  = 1;
            $data['search_day_id']              = $requestData['search_day_id'];
            $data['is_date_range']              = $is_date_range;
            $data['search_company_id']          = $search_company_id;
            $data['search_range_from']          = $requestData['search_range_from'];
            $data['search_range_to']            = $requestData['search_range_to'];
            $data['response']                   = $response;
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