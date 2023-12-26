<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        return view('welcome_message');
    }
    // enquiry request for whatsapp share
    public function enquiryRequest($id)
    {
        $id = decoded($id);
        $data['enquiry'] = $this->common_model->find_data('ecomm_enquires', 'row', ['id' => $id]);
        return view('enquiry-request-details', $data);
    }
}
