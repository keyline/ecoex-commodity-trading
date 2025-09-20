<?php

namespace App\Events;

class EnquiryEvents
{
    public static function triggerEnquiryCreated(array $enquiry)
    {
        // $enquiry is an associative array containing enquiry data
        \CodeIgniter\Events\Events::trigger('enquiry.created', $enquiry);
    }
}
