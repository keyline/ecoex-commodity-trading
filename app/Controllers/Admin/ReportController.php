<?php

namespace App\Controllers\admin;

use App\Controllers\BaseController;
use App\Models\CommonModel;
use App\Services\Report\PlantReportService;
use Dompdf\Dompdf;
use Dompdf\Options;
use Dompdf\Exception as DompdfException;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Border;

class ReportController extends BaseController
{
    protected $plantService;
    private $model;  //This can be accessed by all class methods
    public function __construct()
    {
        $session = \Config\Services::session();
        if (!$session->get('is_admin_login')) {
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

        $this->plantService = new PlantReportService();
    }
    public function analyticsReport()
    {
        $data['moduleDetail']               = $this->data;

        $title                              = 'Manage Analytics Reports';
        $page_name                          = 'reports/analytics-report';

        $orderBy1[0]                        = ['field' => 'company_name', 'type' => 'ASC'];
        $data['companies']                  = $this->common_model->find_data('ecoex_companies', 'array', ['type' => 'COMPANY', 'status>=' => 1, 'status<=' => 2], 'id,company_name', '', '', $orderBy1);
        $orderBy2[0]                        = ['field' => 'name', 'type' => 'ASC'];
        $data['units']                      = $this->common_model->find_data('ecomm_units', 'array', ['status' => 1, 'in_report_dropdown' => 1], 'id,name', '', '', $orderBy2);
        $data['is_search']                  = 0;
        $data['search_day_id']              = '';
        $data['is_date_range']              = 0;
        $data['search_company_id']          = '';
        $data['search_unit_id']             = '';
        $data['search_product_id']          = '';
        $data['convertedUnit']              = '';
        $data['search_range_from']          = '';
        $data['search_range_to']            = '';
        $data['response']                   = [];

        if ($this->request->getGet('mode') == 'advance_search') {
            $records                = [];
            $details_data           = [];
            $requestData            = $this->request->getGet();
            $search_company_id      = $requestData['search_company_id'];
            $search_unit_id         = $requestData['search_unit_id'];
            $search_product_id      = $requestData['search_product_id'];
            $getCompany             = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $search_company_id]);

            if (array_key_exists('is_date_range', $requestData)) {
                $search_range_from  = explode("-", $requestData['search_range_from']);
                $search_range_to    = explode("-", $requestData['search_range_to']);
                $currentMonth       = (int)$search_range_to[1];
                $lastDay            = lastdayMonth($currentMonth);
                $from_date          = $search_range_from[0] . '-' . $search_range_from[1] . '-01';
                $to_date            = $search_range_to[0] . '-' . $search_range_to[1] . '-' . $lastDay;
                $is_date_range      = 1;
                $graph_title        = (($getCompany) ? $getCompany->company_name : '') . " " . $this->common_model->monthShortName($search_range_from[1]) . "-" . $search_range_from[0] . " to " . $this->common_model->monthShortName($search_range_to[1]) . "-" . $search_range_to[0];
            } else {
                $search_day_id      = $requestData['search_day_id'];
                if ($search_day_id == 'this_month') {
                    $currentMonth       = (int)date('m');
                    $lastDay            = lastdayMonth($currentMonth);
                    $from_date          = date('Y') . '-' . date('m') . '-01';
                    $to_date            = date('Y') . '-' . date('m') . '-' . $lastDay;
                    $graph_title        = (($getCompany) ? $getCompany->company_name : '') . " " . $this->common_model->monthShortName(date('m')) . "-" . date('Y');
                } elseif ($search_day_id == 'last_month') {
                    $from_date          = date("Y-m-d", mktime(0, 0, 0, date("m") - 1, 1));
                    $to_date            = date("Y-m-d", mktime(0, 0, 0, date("m"), 0));
                    $graph_title        = (($getCompany) ? $getCompany->company_name : '') . " " . $this->common_model->monthShortName(date("m", mktime(0, 0, 0, date("m") - 1, 1))) . "-" . date('Y');
                }
                $is_date_range      = 0;
            }
            $monthList          = $this->getMonthsInRange($from_date, $to_date);
            if (!empty($monthList)) {
                for ($m = 0; $m < count($monthList); $m++) {
                    $currentMonth       = (int)$monthList[$m]['month'];
                    $lastDay            = lastdayMonth($currentMonth);
                    $monthYear          = $monthList[$m]['year'] . '-' . $monthList[$m]['month'];
                    $fdate              = $monthList[$m]['year'] . '-' . $monthList[$m]['month'] . '-01';
                    $tdate              = $monthList[$m]['year'] . '-' . $monthList[$m]['month'] . '-' . $lastDay;

                    $sql                = "SELECT id,enquiry_no,plant_id FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$fdate' AND created_at <= '$tdate' group by plant_id";
                    $plantCount         = $this->db->query($sql)->getNumRows();
                    $enquires           = $this->db->query("SELECT id FROM ecomm_enquires where company_id = '$search_company_id' AND created_at >= '$fdate' AND created_at <= '$tdate' AND status < 13")->getResult();
                    // pr($enquires);
                    $vehicles           = [];
                    $weightMatQty       = [];
                    $convertedUnit      = 'MT';
                    if ($enquires) {
                        foreach ($enquires as $enquiry) {
                            if ($search_product_id == 'all') {
                                if ($search_unit_id == 'PCS') {
                                    $subEnquiries = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enquiry->id, 'weighted_unit' => $search_unit_id], 'vehicle_registration_nos,weighted_qty,item_id,weighted_unit,enquiry_no,sub_enquiry_no,enq_id');
                                } else {
                                    $subEnquiries = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enquiry->id, 'weighted_unit!=' => 'PCS'], 'vehicle_registration_nos,weighted_qty,item_id,weighted_unit,enquiry_no,sub_enquiry_no,enq_id');
                                }
                            } else {
                                if ($search_unit_id == 'PCS') {
                                    $subEnquiries = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enquiry->id, 'weighted_unit' => $search_unit_id, 'item_id' => $search_product_id], 'vehicle_registration_nos,weighted_qty,item_id,weighted_unit,enquiry_no,sub_enquiry_no,enq_id');
                                } else {
                                    $subEnquiries = $this->common_model->find_data('ecomm_sub_enquires', 'array', ['enq_id' => $enquiry->id, 'weighted_unit!=' => 'PCS', 'item_id' => $search_product_id], 'vehicle_registration_nos,weighted_qty,item_id,weighted_unit,enquiry_no,sub_enquiry_no,enq_id');
                                }
                            }

                            if ($subEnquiries) {
                                foreach ($subEnquiries as $subEnquiry) {
                                    $vehicle_registration_nos = json_decode($subEnquiry->vehicle_registration_nos);
                                    if (!empty($vehicle_registration_nos)) {
                                        for ($v = 0; $v < count($vehicle_registration_nos); $v++) {
                                            if (!in_array($vehicle_registration_nos[$v], $vehicles)) {
                                                $vehicles[] = $vehicle_registration_nos[$v];
                                            }
                                        }
                                    }

                                    if ($search_unit_id == 'PCS') {
                                        $weightMatQty[]         = $subEnquiry->weighted_qty;
                                        $convertedUnit          = $search_unit_id;
                                    } else {
                                        if ($subEnquiry->weighted_unit == 'MT') {
                                            $weightMatQty[]         = $subEnquiry->weighted_qty;
                                            $convertedUnit          = $search_unit_id;
                                        } else {
                                            if ($search_unit_id == 'MT') {
                                                $weightMatQty[]         = weightConversion($subEnquiry->weighted_qty, 'KG', 'MT');
                                            } else {
                                                $weightMatQty[]         = $subEnquiry->weighted_qty;
                                            }
                                            $convertedUnit          = $search_unit_id;
                                        }
                                    }
                                    // if($search_unit_id == 'KG'){
                                    //     $weightMatQty[]         = weightConversion($subEnquiry->weighted_qty, 'KG', 'MT');
                                    //     // $weightMatQty[]         = $subEnquiry->weighted_qty;
                                    //     $convertedUnit          = $search_unit_id;
                                    // } elseif($search_unit_id == 'MT'){
                                    //     $weightMatQty[]         = $subEnquiry->weighted_qty;
                                    //     $convertedUnit          = $search_unit_id;
                                    // } elseif($search_unit_id == 'PCS'){
                                    //     $weightMatQty[]         = $subEnquiry->weighted_qty;
                                    //     $convertedUnit          = $search_unit_id;
                                    // }

                                    /* details data for table */
                                    $getItem        = $this->common_model->find_data('ecomm_company_items', 'row', ['id' => $subEnquiry->item_id], 'item_name_ecoex');
                                    $details_data[] = [
                                        'enq_id'            => $subEnquiry->enq_id,
                                        'enquiry_no'        => $subEnquiry->enquiry_no,
                                        'sub_enquiry_no'    => $subEnquiry->sub_enquiry_no,
                                        'item_name'         => (($getItem) ? $getItem->item_name_ecoex : ''),
                                        'weighted_qty'      => (($subEnquiry->weighted_unit == 'KG') ? $subEnquiry->weighted_qty : weightConversion($subEnquiry->weighted_qty, 'MT', 'KG')),
                                        // 'weighted_unit'     => $subEnquiry->weighted_unit,
                                        'weighted_unit'     => 'KG',
                                    ];
                                    /* details data for table */
                                }
                            }
                        }
                    }
                    $records[]         = [
                        'month_year_name'   => "'" . $this->common_model->monthShortName($monthList[$m]['month']) . "-" . $monthList[$m]['year'] . "'",
                        'scrap_qty'         => round(array_sum($weightMatQty)),
                        'no_of_plant'       => $plantCount,
                        'vehicle_count'     => count($vehicles)
                    ];
                }
            }
            $response = [
                'graph_title'       => $graph_title,
                'records'           => $records,
                'details_data'      => $details_data,
            ];
            // pr($response);
            $data['is_search']                  = 1;
            $data['search_day_id']              = $requestData['search_day_id'];
            $data['is_date_range']              = $is_date_range;
            $data['search_company_id']          = $search_company_id;
            $data['search_unit_id']             = $search_unit_id;
            $data['search_product_id']          = $search_product_id;
            $data['convertedUnit']              = $convertedUnit;
            $data['search_range_from']          = $requestData['search_range_from'];
            $data['search_range_to']            = $requestData['search_range_to'];
            $data['response']                   = $response;
            // pr($response);
        }

        echo $this->layout_after_login($title, $page_name, $data);
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
    public function getCompanyProduct()
    {
        $apiStatus          = TRUE;
        $apiMessage         = '';
        $apiResponse        = [];
        $apiExtraField      = '';
        $apiExtraData       = '';
        $requestData        = $this->request->getPost();
        $company_id         = $requestData['company_id'];
        $orderBy[0]         = ['field' => 'item_name_ecoex', 'type' => 'ASC'];
        $rows               = $this->common_model->find_data('ecomm_company_items', 'array', ['status' => 1, 'company_id' => $company_id], 'id,item_name_ecoex,unit', '', '', $orderBy);
        if ($rows) {
            foreach ($rows as $row) {
                $getUnit = $this->common_model->find_data('ecomm_units', 'row', ['id' => $row->unit], 'id,name');
                $apiResponse[] = [
                    'id'                => $row->id,
                    'name'              => $row->item_name_ecoex,
                    'unit'              => (($getUnit) ? $getUnit->name : ''),
                ];
            }
        }
        http_response_code(200);
        $apiStatus          = TRUE;
        $apiMessage         = 'Data Available !!!';
        $apiExtraField      = 'response_code';
        $apiExtraData       = http_response_code();
        $this->response_to_json($apiStatus, $apiMessage, $apiResponse, $apiExtraField, $apiExtraData);
    }


    // @Shubha75
    public function companyReport()
    {
        $user_type                          = session('user_type');
        $company_id                         = session('company_id');
        $title                              = 'Manage Company Reports';
        $page_name                          = 'reports/plants-report';

        if($user_type == 'COMPANY'){
            $data['companies']  = $this->common_model->find_data('ecoex_companies', 'result-array', ['status>=' => 2, 'id' => $company_id], 'id,company_name');
        } else {
            $data['companies']                  = $this->plantService->getCompanies();
        }

        $data['is_search']                  = 0;
        $data['search_day_id']              = '';
        $data['is_date_range']              = 0;
        $data['search_company_id']          = '';


        $data['search_range_from']          = '';
        $data['search_range_to']            = '';
        $data['response']                   = [];

        if ($this->request->getGet('mode') == 'advance_search') {
            $records                = [];
            $details_data           = [];
            $requestData            = $this->request->getGet();
            $search_company_id      = $requestData['search_company_id'];
            $date_param             = $this->plantService->buildReportParams($requestData);
            $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);

            // pr($details_data);

            $response = [
                'graph_title'       => $date_param['graph_title'],
                'details_data'      => $details_data,
            ];
            // pr($response);
            $data['is_search']                  = 1;
            $data['search_day_id']              = $requestData['search_day_id'];
            $data['is_date_range']              = $date_param['is_date_range'];
            $data['search_company_id']          = $search_company_id;
            $data['search_range_from']          = $requestData['search_range_from'];
            $data['search_range_to']            = $requestData['search_range_to'];
            $data['response']                   = $response;
        }

        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function enquiryReport()
    {
        $user_type                          = session('user_type');        
        $title                              = 'Manage Enquiry Reports';
        $page_name                          = 'reports/enquiry-report'; 

        $data['is_search']                  = 0;        
        $data['is_date_range']              = 0;        


        $data['search_range_from']          = '';
        $data['search_range_to']            = '';
        $data['response']                   = [];

        if ($this->request->getGet('mode') == 'advance_search') {
            $records                = [];
            $details_data           = [];
            $requestData            = $this->request->getGet();  
            // pr($requestData);   
            $from_date = $requestData['search_range_from'];
            $to_date   = $requestData['search_range_to'];                           

            $sql2 = '
                    SELECT 
                        eq.plant_id, eq.company_id, eq.enquiry_no, 
                        eup.plant_name AS plant_name,
                        ec.company_name AS company_name,
                        esq.vendor_id, esq.item_id, esq.weighted_qty, esq.weighted_unit, esq.vehicle_registration_nos,
                        euv.company_name AS vendor_name,
                        eci.item_name_ecoex AS item_name,
                        eau.name AS assigned_user
                    FROM ecomm_enquires eq 
                    LEFT JOIN ecomm_users eup ON eq.plant_id = eup.id
                    LEFT JOIN ecoex_companies ec ON eq.company_id = ec.id 
                    LEFT JOIN ecomm_sub_enquires esq ON eq.id = esq.enq_id
                    LEFT JOIN ecomm_users euv ON esq.vendor_id = euv.id
                    LEFT JOIN ecomm_company_items eci ON esq.item_id = eci.id
                    LEFT JOIN ecoex_admin_user eau ON eau.plant_ids LIKE CONCAT(\'%"\', eq.plant_id, \'"%\')
                    WHERE DATE(eq.created_at) BETWEEN \'' . $from_date . '\' AND \'' . $to_date . '\'                     
                    ORDER BY eq.enquiry_no DESC';                     

            $query = $this->db->query($sql2);
            $results = $query->getResult();
            // $date_param             = $this->plantService->buildReportParams($requestData);
            // $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);

            // pr($results);

            $mergedData = [];

            foreach ($results as $row) {
                $enquiryNo = $row->enquiry_no;

                if (!isset($mergedData[$enquiryNo])) {
                    // initialize
                    $mergedData[$enquiryNo] = [                        
                        'enquiry_no' => $row->enquiry_no, 
                        'assigned_user' => $row->assigned_user,                                         
                        'plant_names' => $row->plant_name,
                        'company_names' => $row->company_name,
                        'vendor_names' => [],
                        'item_names' => [],
                        'weighted_qtys' => [],
                        'weighted_units' => [],
                        'vehicle_registration_nos' => [],
                    ];
                }

                // push array values
                $mergedData[$enquiryNo]['vendor_names'][] = $row->vendor_name;                
                $mergedData[$enquiryNo]['item_names'][] = $row->item_name;
                $mergedData[$enquiryNo]['weighted_qtys'][] = $row->weighted_qty;
                $mergedData[$enquiryNo]['weighted_units'][] = $row->weighted_unit;

                $vehicles = json_decode($row->vehicle_registration_nos, true);
                if (!empty($vehicles)) {
                    $mergedData[$enquiryNo]['vehicle_registration_nos'][] = !empty($vehicles) ? $vehicles : [];
                }
            }

            // ✅ Remove duplicates from repeated fields
            // foreach ($mergedData as &$data) {
            //     $data['vendor_names'] = array_values(array_unique($data['vendor_names']));
            //     $data['plant_names'] = array_values(array_unique($data['plant_names']));
            //     $data['company_names'] = array_values(array_unique($data['company_names']));
            //     $data['item_names'] = array_values(array_unique($data['item_names']));
            //     $data['vehicle_registration_nos'] = array_values(array_unique($data['vehicle_registration_nos']));
            // }

            // reset to numeric array
            $finalData = array_values($mergedData);

            // pr($finalData);

            $response = [
            // 'graph_title'       => $date_param['graph_title'],
            'details_data'      => $finalData,
        ];

            
            // pr($response);
            $data['is_search']                  = 1;                                  
            $data['search_range_from']          = $requestData['search_range_from'];
            $data['search_range_to']            = $requestData['search_range_to'];
            $data['response']                   = $response;                                               

        }
         

        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function companyReportExportPdf()
    {
        $page_name              = 'Views/admin/maincontents/reports/pdf_report_template';
        $requestData            = $this->request->getGet();
        $search_company_id      = $requestData['search_company_id'];
        $date_param             = $this->plantService->buildReportParams($requestData);
        $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);
        $response = [
            'graph_title'       => $date_param['graph_title'],
            'details_data'      => $details_data,
        ];



        $html = view($page_name, ['response' => $response]);
        $html .= '<style>tr, td { page-break-inside: avoid; }</style>';
        // pr($html);

        try {
            // Initialize Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);


            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();


            // Output the PDF as a download
            $dompdf->stream($date_param['file_title'] . ".pdf", ["Attachment" => 1]); # 1 = download, 0 = view in browser
            exit; // important — prevents CI4 from appending its own HTML wrapper

        } catch (DompdfException $e) {
            log_message('error', 'PDF generation failed: ' . $e->getMessage());
        } catch (\Throwable $e) {
            log_message('critical', 'Unexpected error in PDF export: ' . $e->getMessage());
        }
    }

    public function companyReportExportExcel()
    {
        $requestData            = $this->request->getGet();
        $search_company_id      = $requestData['search_company_id'];
        $date_param             =  $this->plantService->buildReportParams($requestData);
        $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);
        $response = [
            'graph_title'       => $date_param['graph_title'],
            'details_data'      => $details_data,
        ];



        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // the header row
        $headers = [
            'Sr. No.',
            'Enquiry No.',
            'Plant Name',
            'Invoice Date',
            'Invoice No.',
            'Sub Enquiry No.',
            'Vendor',
            'Vendor Invoice Date',
            'Vendor Invoice No',
            'Item',
            'Weight',
            'Unit',
            'Vehicle No.'
        ];
        foreach ($headers as $colIndex => $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex + 1) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Fill data rows
        $row       = 2;
        $serialNum = 1;

        foreach ($response['details_data'] as $enquiry) {
            // Prepare main-level values
            $mainInvDate = date('d-m-Y', strtotime($enquiry['invoice_date']));
            $mainInvNums = implode(', ', array_map('esc', json_decode($enquiry['invoice_numbers'], true)));

            foreach ($enquiry['sub_enquires'] as $subIdx => $sub) {
                // Prepare sub-enquiry–level values
                $vendorDates = array_map(function ($inv) {
                    return date('d-m-Y', strtotime($inv['date']));
                }, $sub['invoice']);
                $vendorNums  = array_map(fn($inv) => esc($inv['number']), $sub['invoice']);
                $vehicles    = implode(', ', array_map('esc', $sub['vehicles']));

                $vendorDatesStr = implode(', ', $vendorDates);
                $vendorNumsStr  = implode(', ', $vendorNums);

                foreach ($sub['items'] as $itemIdx => $item) {
                    // Main enquiry columns only once per enquiry (first sub, first item)
                    if ($subIdx === 0 && $itemIdx === 0) {
                        $sheet->setCellValue("A{$row}", $serialNum++);
                        $sheet->setCellValue("B{$row}", $enquiry['enquiry_no']);
                        $sheet->setCellValue("C{$row}", $enquiry['plant_name']);
                        $sheet->setCellValue("D{$row}", $mainInvDate);
                        $sheet->setCellValue("E{$row}", $mainInvNums);
                    }

                    // Sub-enquiry columns once per sub-enquiry
                    if ($itemIdx === 0) {
                        $sheet->setCellValue("F{$row}", $sub['sub_enquiry_no']);
                        $sheet->setCellValue("G{$row}", $sub['vendor_name']);
                        $sheet->setCellValue("H{$row}", $vendorDatesStr);
                        $sheet->setCellValue("I{$row}", $vendorNumsStr);
                        $sheet->setCellValue("M{$row}", $vehicles);
                    }

                    // Item columns
                    $sheet->setCellValue("J{$row}", $item['item_name']);
                    $sheet->setCellValue("K{$row}", $item['weighted_qty']);
                    $sheet->setCellValue("L{$row}", $item['weighted_unit']);

                    $row++;
                }
            }
        }

        // Apply thin black border around every cell in A1:M<lastRow>
        $lastRow   = $row - 1;
        $fullRange = "A1:M{$lastRow}";
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle($fullRange)
            ->applyFromArray($borderStyle, false);

        // Output to browser
        $filename = $date_param['file_title'] . '.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function EnquiryReportExportPdf()
    {
        $page_name              = 'Views/admin/maincontents/reports/pdf_enquiry_report_template';
        $requestData            = $this->request->getGet();
        $from_date = $requestData['search_range_from'];
        $to_date   = $requestData['search_range_to'];                           

        $sql2 = '
                SELECT 
                    eq.plant_id, eq.company_id, eq.enquiry_no, 
                    eup.plant_name AS plant_name,
                    ec.company_name AS company_name,
                    esq.vendor_id, esq.item_id, esq.weighted_qty, esq.weighted_unit, esq.vehicle_registration_nos,
                    euv.company_name AS vendor_name,
                    eci.item_name_ecoex AS item_name,
                    eau.name AS assigned_user
                FROM ecomm_enquires eq 
                LEFT JOIN ecomm_users eup ON eq.plant_id = eup.id
                LEFT JOIN ecoex_companies ec ON eq.company_id = ec.id 
                LEFT JOIN ecomm_sub_enquires esq ON eq.id = esq.enq_id
                LEFT JOIN ecomm_users euv ON esq.vendor_id = euv.id
                LEFT JOIN ecomm_company_items eci ON esq.item_id = eci.id
                LEFT JOIN ecoex_admin_user eau ON eau.plant_ids LIKE CONCAT(\'%"\', eq.plant_id, \'"%\')
                WHERE DATE(eq.created_at) BETWEEN \'' . $from_date . '\' AND \'' . $to_date . '\'                     
                ORDER BY eq.enquiry_no DESC';                     

        $query = $this->db->query($sql2);
        $results = $query->getResult();
        // $date_param             = $this->plantService->buildReportParams($requestData);
        // $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);

        // pr($results);

        $mergedData = [];

        foreach ($results as $row) {
            $enquiryNo = $row->enquiry_no;

            if (!isset($mergedData[$enquiryNo])) {
                // initialize
                $mergedData[$enquiryNo] = [                        
                    'enquiry_no' => $row->enquiry_no, 
                    'assigned_user' => $row->assigned_user,                                         
                    'plant_names' => $row->plant_name,
                    'company_names' => $row->company_name,
                    'vendor_names' => [],
                    'item_names' => [],
                    'weighted_qtys' => [],
                    'weighted_units' => [],
                    'vehicle_registration_nos' => [],
                ];
            }

            // push array values
            $mergedData[$enquiryNo]['vendor_names'][] = $row->vendor_name;                
            $mergedData[$enquiryNo]['item_names'][] = $row->item_name;
            $mergedData[$enquiryNo]['weighted_qtys'][] = $row->weighted_qty;
            $mergedData[$enquiryNo]['weighted_units'][] = $row->weighted_unit;

            $vehicles = json_decode($row->vehicle_registration_nos, true);
            if (!empty($vehicles)) {
                $mergedData[$enquiryNo]['vehicle_registration_nos'][] = !empty($vehicles) ? $vehicles : [];
            }
        }
        $finalData = array_values($mergedData);
        $response = [
            // 'graph_title'       => $date_param['graph_title'],
            'details_data'      => $finalData,
        ];



        $html = view($page_name, ['response' => $response]);
        $html .= '<style>tr, td { page-break-inside: avoid; }</style>';
        // pr($html);

        try {
            // Initialize Dompdf
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isRemoteEnabled', true);


            $dompdf = new Dompdf($options);
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();


            // Output the PDF as a download
            $dompdf->stream("Enquiry_report.pdf", ["Attachment" => 1]); # 1 = download, 0 = view in browser
            exit; // important — prevents CI4 from appending its own HTML wrapper

        } catch (DompdfException $e) {
            log_message('error', 'PDF generation failed: ' . $e->getMessage());
        } catch (\Throwable $e) {
            log_message('critical', 'Unexpected error in PDF export: ' . $e->getMessage());
        }
    }

    public function enquiryReportExportExcel()
    {
        $requestData            = $this->request->getGet();
        $from_date = $requestData['search_range_from'];
        $to_date   = $requestData['search_range_to'];                           

        $sql2 = '
                SELECT 
                    eq.plant_id, eq.company_id, eq.enquiry_no, 
                    eup.plant_name AS plant_name,
                    ec.company_name AS company_name,
                    esq.vendor_id, esq.item_id, esq.weighted_qty, esq.weighted_unit, esq.vehicle_registration_nos,
                    euv.company_name AS vendor_name,
                    eci.item_name_ecoex AS item_name,
                    eau.name AS assigned_user
                FROM ecomm_enquires eq 
                LEFT JOIN ecomm_users eup ON eq.plant_id = eup.id
                LEFT JOIN ecoex_companies ec ON eq.company_id = ec.id 
                LEFT JOIN ecomm_sub_enquires esq ON eq.id = esq.enq_id
                LEFT JOIN ecomm_users euv ON esq.vendor_id = euv.id
                LEFT JOIN ecomm_company_items eci ON esq.item_id = eci.id
                LEFT JOIN ecoex_admin_user eau ON eau.plant_ids LIKE CONCAT(\'%"\', eq.plant_id, \'"%\')
                WHERE DATE(eq.created_at) BETWEEN \'' . $from_date . '\' AND \'' . $to_date . '\'                     
                ORDER BY eq.enquiry_no DESC';                     

        $query = $this->db->query($sql2);
        $results = $query->getResult();
        // $date_param             = $this->plantService->buildReportParams($requestData);
        // $details_data           = $this->plantService->getEnquires($search_company_id, $date_param['from_date'], $date_param['to_date']);

        // pr($results);

        $mergedData = [];

        foreach ($results as $row) {
            $enquiryNo = $row->enquiry_no;

            if (!isset($mergedData[$enquiryNo])) {
                // initialize
                $mergedData[$enquiryNo] = [                        
                    'enquiry_no' => $row->enquiry_no, 
                    'assigned_user' => $row->assigned_user,                                         
                    'plant_names' => $row->plant_name,
                    'company_names' => $row->company_name,
                    'vendor_names' => [],
                    'item_names' => [],
                    'weighted_qtys' => [],
                    'weighted_units' => [],
                    'vehicle_registration_nos' => [],
                ];
            }

            // push array values
            $mergedData[$enquiryNo]['vendor_names'][] = $row->vendor_name;                
            $mergedData[$enquiryNo]['item_names'][] = $row->item_name;
            $mergedData[$enquiryNo]['weighted_qtys'][] = $row->weighted_qty;
            $mergedData[$enquiryNo]['weighted_units'][] = $row->weighted_unit;

            $vehicles = json_decode($row->vehicle_registration_nos, true);
            if (!empty($vehicles)) {
                $mergedData[$enquiryNo]['vehicle_registration_nos'][] = !empty($vehicles) ? $vehicles : [];
            }
        }
        $finalData = array_values($mergedData);
        $response = [
            // 'graph_title'       => $date_param['graph_title'],
            'details_data'      => $finalData,
        ];



        // Create a new spreadsheet
        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // the header row
        $headers = [
            'Sr. No.',
            'Enquiry No.',
            'Company Name',
            'Plant Name',
            'Assigned user',            
            'Vehicle No.',
            'Material Lifted',
            'Quantity',
            'Vendor'
        ];
        foreach ($headers as $colIndex => $header) {
            $cell = Coordinate::stringFromColumnIndex($colIndex + 1) . '1';
            $sheet->setCellValue($cell, $header);
        }

        // Fill data rows
        $row       = 2;
        $serial = 1;

        foreach ($response['details_data'] as $data) {
            // Ensure these are arrays
            $vendor_names = $data['vendor_names'] ?? [];
            $item_names = $data['item_names'] ?? [];
            $weighted_qtys = $data['weighted_qtys'] ?? [];
            $weighted_units = $data['weighted_units'] ?? [];
            $vehicle_sets = $data['vehicle_registration_nos'] ?? [];

            // Find max number of sub-rows for this enquiry
            $rowCount = max(
                count($vendor_names),
                count($item_names),
                count($weighted_qtys)
            );
            if ($rowCount == 0) $rowCount = 1;

            // Loop through each sub-row
            for ($i = 0; $i < $rowCount; $i++) {
                // Sr. No.
                $sheet->setCellValue("A{$row}", $serial);

                // Show enquiry-level data only once (simulate rowspan)
                if ($i == 0) {
                    $sheet->setCellValue("B{$row}", $data['enquiry_no']);
                    $sheet->setCellValue("C{$row}", $data['company_names']);
                    $sheet->setCellValue("D{$row}", $data['plant_names']);
                    $sheet->setCellValue("E{$row}", $data['assigned_user']);
                }

                // Vehicle Numbers (joined with commas)
                $vehicles = $vehicle_sets[$i] ?? [];
                $vehicleList = !empty($vehicles) ? implode(', ', $vehicles) : '-';
                $sheet->setCellValue("F{$row}", $vehicleList);

                // Item Info
                $sheet->setCellValue("G{$row}", $item_names[$i] ?? '-');
                $sheet->setCellValue("H{$row}", ($weighted_qtys[$i] ?? '-') . '/' . ($weighted_units[$i] ?? '-'));
                $sheet->setCellValue("I{$row}", $vendor_names[$i] ?? '-');

                $row++;
            }

            $serial++;
        }

        // Apply thin black border around every cell in A1:M<lastRow>
        $lastRow   = $row - 1;
        $fullRange = "A1:M{$lastRow}";
        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color'       => ['argb' => 'FF000000'],
                ],
            ],
        ];
        $sheet->getStyle($fullRange)
            ->applyFromArray($borderStyle, false);

        // Output to browser
        $filename = 'Enquiry_report.xlsx';
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: max-age=0');

        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }
}
