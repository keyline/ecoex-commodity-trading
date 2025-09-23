<?php

namespace App\Models;

use CodeIgniter\Model;

class PriceModel extends Model
{
    protected $db;

    public function __construct()
    {
        parent::__construct();
        $this->db = \Config\Database::connect();
    }

    public function getTopVendorsWithItems($startDate, $endDate)
    {
        $sql = "
            WITH top_vendors AS (
                SELECT 
                    vendor_id,
                    SUM(weighted_qty) AS total_qty
                FROM 
                    ecomm_sub_enquires
                WHERE 
                    assigned_date BETWEEN ? AND ?
                GROUP BY 
                    vendor_id
                ORDER BY 
                    total_qty DESC
                LIMIT 3
            )
            SELECT 
                e.vendor_id,
                i.item_name_ecoex AS item_name,
                SUM(e.weighted_qty) AS item_qty,
                e.weighted_unit AS item_unit
            FROM 
                ecomm_sub_enquires e
            JOIN 
                top_vendors tv ON e.vendor_id = tv.vendor_id
            LEFT JOIN 
                ecomm_company_items i ON e.eng_id = i.enq_id
            WHERE 
                e.assigned_date BETWEEN ? AND ?
            GROUP BY 
                e.vendor_id, i.item_name_ecoex, e.weighted_unit
            ORDER BY 
                tv.total_qty DESC, e.vendor_id, item_qty DESC
        ";

        // Run query with bindings (to prevent SQL injection)
        $query = $this->db->query($sql, [$startDate, $endDate, $startDate, $endDate]);

        return $query->getResultArray(); // or getResult() for objects
    }
}
