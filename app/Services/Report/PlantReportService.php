<?php

namespace App\Services\Report;

use App\Repositories\Report\PlantReportRepository;


class PlantReportService
{
    protected  $repository;

    public function __construct()
    {
        $this->repository = new PlantReportRepository();
    }

    public function getCompanies($id = null)
    {
        try {
            $companies = $this->repository->companies($id);
            if (empty($companies)) {
                throw new \Exception('No companies found.');
            }
            return $companies;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching companies: ' . $e->getMessage());
            return null;
        }
    }


    /**
     * Build date range, is_date_range flag, and graph title
     *
     * @param  array  $requestData
     * @return array
     */
    public function buildReportParams(array $requestData): array
    {
        $company = $this->getCompanies($requestData['search_company_id'] ?? null);
        $company = $company[0] ?? null;

        if (array_key_exists('is_date_range', $requestData)) {
            $search_range_from  = explode("-", $requestData['search_range_from']);
            $search_range_to    = explode("-", $requestData['search_range_to']);
            $currentMonth       = (int)$search_range_to[1];

            $lastDay            = lastdayMonth($currentMonth);

            $from_date          = $search_range_from[2] . '-' . $search_range_from[1] . '-' . $search_range_from[0];
            $to_date            = $search_range_to[2] . '-' . $search_range_to[1] . '-' . $search_range_to[0];


            $from          = date('jS M', strtotime($from_date));
            $to            = date('jS M', strtotime($to_date));


            $is_date_range      = 1;
            $companyName = $company ? $company['company_name'] : '';

            $graph_title = "{$companyName} {$from} To {$to} {$search_range_from[2]}";
        } else {

            $dayId = $requestData['search_day_id'] ?? 'this_month';


            // then your logic stays the same:
            if ($dayId === 'this_month') {
                $currentMonth       = (int)date('m');
                $lastDay            = lastdayMonth($currentMonth);
                $from_date          = date('Y') . '-' . date('m') . '-01';
                $to_date            = date('Y') . '-' . date('m') . '-' . $lastDay;
                $graph_title        = (($company) ? $company['company_name'] : '') . " " . date('M') . "-" . date('Y');
            } elseif ($dayId === 'this_week') {
                // Determine “today” and weekday (1 = Monday … 7 = Sunday)
                $dayOfWeek   = date('N');

                // Calculate Monday (start) and Sunday (end) of current week
                $from_date   = date('Y-m-d', strtotime('-' . ($dayOfWeek - 1) . ' days'));
                $to_date     = date('Y-m-d', strtotime('+' . (7 - $dayOfWeek) . ' days'));

                // Build a title like “CompanyName 21–27 Apr 2025”
                $companyName = $company ? $company['company_name'] : '';
                $titleFrom   = date('j', strtotime($from_date))
                    . ' ' . date('M', strtotime($from_date));
                $titleTo     = date('j', strtotime($to_date))
                    . ' ' . date('M', strtotime($from_date));
                $year        = date('Y', strtotime($from_date));

                $graph_title = "{$companyName} {$titleFrom}–{$titleTo} {$year}";
            }

            $is_date_range      = 0;
        }

        return [
            'from_date'      => $from_date,
            'to_date'        => $to_date,
            'is_date_range'  => $is_date_range ? 1 : 0,
            'graph_title'    => $graph_title,
        ];
    }




    /**
     * Clean, normalize, and group the raw enquiry data array by enq_id and vendor_id.
     *
     * - Decode JSON-encoded fields into PHP arrays.
     * - Cast numeric strings to appropriate types (float/int).
     * - Standardize date strings (optional DateTime conversion).
     * - Group items under the same enq_id & vendor_id.
     */

    protected function transformEnquiryData(array $rawData): array
    {
        $grouped = [];

        foreach ($rawData as $entry) {
            // Keys for grouping
            $enqId    = (int)$entry['enq_id'];
            $vendorId = (int)$entry['vendor_id'];
            $key      = "$enqId|$vendorId";

            // Decode JSON arrays
            $vehicles   = isset($entry['vehicle_registration_nos'])
                ? json_decode($entry['vehicle_registration_nos'], true)
                : [];
            $invNumbers = isset($entry['vendor_invoice_number_arr'])
                ? json_decode($entry['vendor_invoice_number_arr'], true)
                : [];
            $invAmounts = isset($entry['vendor_invoice_amount_arr'])
                ? json_decode($entry['vendor_invoice_amount_arr'], true)
                : [];
            $invDates   = isset($entry['vendor_invoice_date_arr'])
                ? json_decode($entry['vendor_invoice_date_arr'], true)
                : [];

            // Build invoice list
            $invoices = [];
            $count = max(count($invNumbers), count($invAmounts), count($invDates));
            for ($i = 0; $i < $count; $i++) {
                $invoices[] = [
                    'number' => $invNumbers[$i] ?? null,
                    'amount' => isset($invAmounts[$i]) ? (float)$invAmounts[$i] : null,
                    'date'   => $invDates[$i] ?? null,
                ];
            }

            // Prepare item info
            $item = [
                'item_id'         => (int)$entry['item_id'],
                'item_name'       => $entry['item_name_ecoex'],
                'weighted_qty'    => (float)$entry['weighted_qty'],
                'weighted_unit'   => $entry['weighted_unit'],
            ];

            // Base record for group
            if (!isset($grouped[$key])) {
                $grouped[$key] = [
                    'enq_id'           => $enqId,
                    'enquiry_no'       => $entry['enquiry_no'],
                    'plant_id'         => (int)$entry['plant_id'],
                    'plant_name'       => $entry['plant_name'],
                    'sub_enq_id'       => (int)$entry['sub_enq_id'],
                    'sub_enquiry_no'   => $entry['sub_enquiry_no'],
                    'vendor_id'        => $vendorId,
                    'vendor_name'      => $entry['vendor_name'],
                    'invoice_number'   => $entry['invoice_number'],
                    'invoice_date'     => $entry['invoice_date'],
                    'payable_amount'   => (float)$entry['payable_amount'],
                    'vehicles'         => $vehicles,
                    'invoices'         => $invoices,
                    'items'            => [],
                ];
            }

            // Append item info to group
            $grouped[$key]['items'][] = $item;
        }

        // Reset keys to indexed array
        return array_values($grouped);
    }

    public function getEnquires($companyId, $fromDate, $toDate)
    {
        try {

            $enquires = $this->repository->filterEnqueryBy($companyId, $fromDate, $toDate);

            $transformed = $this->transformEnquiryData($enquires);
            // pr($transformed);

            return $transformed;
        } catch (\Exception $e) {
            log_message('error', 'Error fetching enquiries: ' . $e->getMessage());
            return null;
        }
    }
}
