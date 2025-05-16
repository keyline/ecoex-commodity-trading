<?php

namespace App\Repositories\Report;

class PlantReportRepository
{
    protected $db;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
    }

    public function companies($id = null)
    {
        $builder = $this->db
            ->table('ecoex_companies')
            ->select('id, company_name')
            ->where('type', 'COMPANY')
            ->where('status >=', 1)
            ->where('status <=', 2);

        if ($id !== null) {
            $builder->where('id', $id);
        }

        return $builder
            ->orderBy('company_name', 'ASC')
            ->get()
            ->getResultArray();
    }


    // public function filterEnqueryBy(int $companyId, string $fromDate, string $toDate): array
    // {
    //     # qry debug

    //     $builder = $this->db
    //         ->table('view_ho_invoices enq')
    //         ->select([
    //             'enq.enq_id',
    //             'enq.enquiry_no',
    //             'enq.plant_id',
    //             'enq.idx',
    //             'enq.invoice_number',
    //             'enq.payable_amount',
    //             'enq.invoice_date',
    //             'plant.plant_name'
    //         ])
    //         // join onto ecomm_users aliased as “plant”
    //         ->join('ecomm_users plant', 'enq.plant_id = plant.id')
    //         ->where('enq.company_id', $companyId)
    //         ->where("enq.invoice_date >= '{$fromDate}'")
    //         ->where("enq.invoice_date <= '{$toDate}'");
    //         // ->orderBy('STR_TO_DATE(enq.order_complete_date, \'%Y-%m-%d\')', 'ASC', false);

    //     // This returns the full SQL string (with placeholders):
    //     $sql = $builder->getCompiledSelect();

    //     // You can now log it, echo it, dd() it, etc.
    //     echo $sql;
    //     die();



    //     return $this->db
    //         ->table('view_ho_invoices enq')
    //         ->select([
    //             'enq.enq_id',
    //             'enq.enquiry_no',
    //             'enq.plant_id',
    //             'enq.idx',
    //             'enq.invoice_number',
    //             'enq.payable_amount',
    //             'enq.invoice_date',
    //             'plant.plant_name'
    //         ])
    //         // join onto ecomm_users aliased as “plant”
    //         ->join('ecomm_users plant', 'enq.plant_id = plant.id')
    //         ->where('enq.company_id', $companyId)
    //         ->where("enq.invoice_date >= '{$fromDate}'")
    //         ->where("enq.invoice_date <= '{$toDate}'")
    //         ->get()
    //         ->getResultArray();
    // }

    // public function getSubEnquiryDetails(int $enquiryId): array
    // {
    //     return $this->db
    //         ->table('ecomm_sub_enquires AS sub_enq')
    //         ->select([
    //             'sub_enq.id AS sub_enq_id',
    //             'sub_enq.sub_enquiry_no',
    //             'vendor.id AS vendor_id',
    //             'vendor.company_name AS vendor_name',
    //             'sub_enq.item_id',
    //             'item.item_name_ecoex',
    //             'sub_enq.weighted_qty',
    //             'sub_enq.weighted_unit',
    //             'sub_enq.vehicle_registration_nos',
    //             'sub_enq.vendor_invoice_number_arr',
    //             'sub_enq.vendor_invoice_amount_arr',
    //             'sub_enq.vendor_invoice_date_arr',
    //         ])

    //         ->join('ecomm_users AS vendor', 'sub_enq.vendor_id = vendor.id')

    //         ->join('ecomm_company_items AS item', 'sub_enq.item_id = item.id')
    //         // filter by the parent enquiry
    //         ->where('sub_enq.enq_id', $enquiryId)
    //         ->get()
    //         ->getResultArray();
    // }

    public function filterEnqueryBy(int $companyId, string $fromDate, string $toDate)
    {
      
        $builder = $this->db->table('view_ho_invoices AS enq');
        $builder->select([
            'enq.enq_id',
            'enq.enquiry_no',
            'enq.plant_id',
            'enq.idx',
            'enq.invoice_number',
            'enq.payable_amount',
            'enq.invoice_date',
            'plant.plant_name',
            'sub_enq.id AS sub_enq_id',
            'sub_enq.sub_enquiry_no',
            'vendor.id AS vendor_id',
            'vendor.company_name AS vendor_name',
            'sub_enq.item_id',
            'item.item_name_ecoex',
            'sub_enq.weighted_qty',
            'sub_enq.weighted_unit',
            'sub_enq.vehicle_registration_nos',
            'sub_enq.vendor_invoice_number_arr',
            'sub_enq.vendor_invoice_amount_arr',
            'sub_enq.vendor_invoice_date_arr'
        ]);

        $builder->join('ecomm_users AS plant', 'enq.plant_id = plant.id');
        $builder->join('ecomm_sub_enquires AS sub_enq', 'enq.enq_id = sub_enq.enq_id');
        $builder->join('ecomm_users AS vendor', 'sub_enq.vendor_id = vendor.id');
        $builder->join('ecomm_company_items AS item', 'sub_enq.item_id = item.id');

        $builder->where('enq.company_id', $companyId);
        $builder->where("enq.invoice_date >= '{$fromDate}'");
        $builder->where("enq.invoice_date <= '{$toDate}'");
        $builder->where('sub_enq.status', 12.12);

        $query = $builder->get();
        return $query->getResultArray();
    }
}
