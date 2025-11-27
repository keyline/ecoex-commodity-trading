<?php

// ============================================
// 7. CERTIFICATE CONTROLLER
// ============================================
// File: app/Controllers/CertificateController.php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\CertificateModel;
use App\Models\CertificateItemModel;
use App\Services\PdfService;
use App\Models\CertificateVendorModel;
use CodeIgniter\Database\Exceptions\DatabaseException;
use App\Models\CompanyCertificateModel;
use App\Libraries\WordDocumentGenerator;

class CertificateController extends BaseController
{
    protected $certificateModel;
    protected $itemModel;
    protected $pdfService;
    protected $vendorModel;
    protected $companyCertificateModel;

    public function __construct()
    {
        $session = \Config\Services::session();

        if (!$session->get('is_admin_login')) {
            return redirect()->to('/Administrator');
        }

        $this->certificateModel = new CertificateModel();
        $this->itemModel = new CertificateItemModel();
        $this->pdfService = new PdfService();

        $this->vendorModel = new CertificateVendorModel();

        $this->companyCertificateModel = new CompanyCertificateModel();

        $this->data = array(
                    //'model'                 => $model,
                    'session'               => $session,
                    'title'                 => 'Certificate Request',
                    'controller_route'      => 'certificates',
                    'controller'            => 'CertificateController',
                    'table_name'            => 'ecomm_company_certificates',
                    'primary_key'           => 'id'
                );

    }

    public function index()
    {
        $data['certificates'] = $this->certificateModel->findAll();
        return view('certificates/index', $data);
    }

    /**
     * Generate certificate - check if enquiry exists
     * If exists and draft, show edit form
     * If exists and finalized, show view only
     * If not exists, show form with enquiry data pre-filled
     */
    public function generate()
    {
        $enquiryNo = $this->request->getPost('enquiry_id');
        $companyId = $this->request->getPost('company_id');
        $plantId = $this->request->getPost('plant_id');





        $title                      = 'Create Certificate';


        $page_name                  = 'certificates/form';


        $data['moduleDetail']       = $this->data;




        if (!$enquiryNo) {
            return redirect()->back()->with('error', 'Enquiry number is required');
        }

        // Check if certificate already exists for this enquiry
        $certificate = $this->certificateModel->getCertificateByEnquiry($enquiryNo);

        if ($certificate) {
            // Certificate exists

            return redirect()->to('admin/certificates/' . $certificate['id'])
                                ->with('info', 'This certificate is already created.');

            /*if ($certificate['status'] === 'finalized') {
                // Redirect to view only

            } else {

                $title                      = 'Edit Certificate';

                // Redirect to edit form (draft status)
                return redirect()->to('admin/certificates/' . $certificate['id'] . '/edit');
            }*/
        }

        // Certificate doesn't exist - fetch enquiry data and show form
        $enquiryData = $this->getEnquiryData($enquiryNo);

        if (!$enquiryData) {
            return redirect()->back()->with('error_message', 'Invalid enquiry number');
        }

        $data['enquiry'] = $enquiryData;
        $data['mode'] = 'create';
        //return view('certificates/form', $data);
        echo $this->layout_after_login($title, $page_name, $data);
    }

    public function store()
    {

        $enquiryId = $this->request->getPost('enquiry_id');

        // Check if certificate already exists
        if ($this->certificateModel->enquiryExists($enquiryId)) {
            return redirect()->back()
                ->withInput()
                ->with('error', 'Certificate already exists for this enquiry number');
        }

        $validation = \Config\Services::validation();


        $validationRules = [
            'enquiry_id' => 'required',
            'company_id' => 'required',
            'enquiry_no' => 'required',
            'certificate_number' => 'permit_empty|max_length[255]',
            'company_name' => 'required|max_length[255]',
            'plant_name' => 'required|max_length[255]',
            'plant_address' => 'required',
            'plant_state' => 'required|max_length[100]',
            'collection_date' => 'required|valid_date',
            'items.*.description' => 'required|max_length[500]',
            'items.*.quantity' => 'required|decimal',
            'items.*.unit' => 'required|max_length[50]',
            'vendors.*.company_name' => 'required|max_length[255]',
        ];


        $validationMessages = [
            'enquiry_no' => [
                'required' => 'Enquiry number is required',
            ],
            'enquiry_id' => [
                'required' => 'Enquiry ID is required',
            ],
            'company_id' => [
                'required' => 'Company ID is required',
            ],
            'enquiry_no' => [
                'required' => 'Enquiry number is required',
            ],
            'company_name' => [
                'required' => 'Company name is required',
                'max_length' => 'Company name cannot exceed 255 characters',
            ],
            'plant_name' => [
                'required' => 'Plant name is required',
                'max_length' => 'Plant name cannot exceed 255 characters',
            ],
            'plant_address' => [
                'required' => 'Plant address is required',
            ],
            'plant_state' => [
                'required' => 'Plant state is required',
                'max_length' => 'Plant state cannot exceed 100 characters',
            ],
            'collection_date' => [
                'required' => 'Collection date is required',
                'valid_date' => 'Collection date must be a valid date',
            ],
            'items.*.description' => [
                'required' => 'Item description is required',
                'max_length' => 'Item description cannot exceed 500 characters',
            ],
            'items.*.quantity' => [
                'required' => 'Item quantity is required',
                'decimal' => 'Item quantity must be a valid number',
            ],
            'items.*.unit' => [
                'required' => 'Item unit is required',
                'max_length' => 'Item unit cannot exceed 50 characters',
            ],
            'vendors.*.company_name' => [
                'required' => 'Vendor company name is required',
                'max_length' => 'Vendor company name cannot exceed 255 characters',
            ],
        ];


        if (!$this->validate($validationRules, $validationMessages)) {
            /*return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());*/
            var_dump($validation->getErrors());
            exit;
        }




        /*if (!$this->validate($this->certificateModel->getValidationRules())) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }*/

        $db = \Config\Database::connect();
        $db->transException(true)->transStart();

        try {
            // Generate certificate number
            /*$certNumber = $this->generateCertificateNumber(
                $this->request->getPost('plant_name'),
                $this->request->getPost('enquiry_no')
            );*/

            // Insert certificate
            $certificateData = [
                'enquiry_id' => $enquiryId,
                'enquiry_no' => $this->request->getPost('enquiry_no'),
                'company_id' => $this->request->getPost('company_id'),
                'certificate_number' => $this->request->getPost('certificate_number') ?? null,
                'company_name' => $this->request->getPost('company_name'),
                'plant_name' => $this->request->getPost('plant_name'),
                'plant_address' => $this->request->getPost('plant_address'),
                'plant_state' => $this->request->getPost('plant_state'),
                'collection_date' => $this->request->getPost('collection_date'),
                'issue_date' => date('Y-m-d'),
                'status' => 'pending',
                'created_by' => session()->get('user_id'),
            ];

            $certificateId = $this->certificateModel->insert($certificateData);


            if (!$certificateId) {
                throw new \Exception('Failed to create certificate');
            }


            // Insert items
            /*$items = $this->request->getPost('items');
            if ($items) {
                foreach ($items as $index => $item) {
                    if (!empty($item['description']) && !empty($item['quantity'])) {
                        $this->itemModel->insert([
                            'certificate_id' => $certificateId,
                            'item_description' => $item['description'],
                            'quantity' => $item['quantity'],
                            'unit' => $item['unit'],
                            'sequence' => $index + 1
                        ]);
                    }
                }
            }*/
            $this->insertCertificateItems($certificateId);

            // Insert vendors
            /*$vendors = $this->request->getPost('vendors');
            if ($vendors) {
                $vendorModel = new \App\Models\CertificateVendorModel();
                foreach ($vendors as $index => $vendor) {
                    if (!empty($vendor['company_name'])) {
                        $vendorModel->insert([
                            'certificate_id' => $certificateId,
                            'vendor_id' => $vendor['vendor_id'] ?? null,
                            'company_name' => $vendor['company_name'],
                            'sequence' => $index + 1
                        ]);
                    }
                }
            }*/

            // Insert vendors
            $this->insertCertificateVendors($certificateId);


            // Generate PDF on the fly
            $pdfFilename = $this->generatePDF($certificateId);

            $wordFileName = $this->saveWord($certificateId);


            //$savePath = FCPATH . 'public/uploads/certificate/' . $pdfFilename;


            // Insert record into ecomm_company_certificates table
            $this->companyCertificateModel->insert([
                'company_id' => $certificateData['company_id'] ?? 0,
                'enquiry_id' => $certificateData['enquiry_id'] ?? 0,
                'certificate_type' => 1, // Alternate type
                'certificate_file' => $pdfFilename,
                'word_filename' => pathinfo($wordFileName, PATHINFO_FILENAME),
                'certificate_word_file' => $wordFileName,
                'filename' => pathinfo($pdfFilename, PATHINFO_FILENAME),
            ]);



            // Update certificate with PDF path
            $this->certificateModel->update($certificateId, ['pdf_path' => $pdfFilename, 'word_path' => $wordFileName]);



            $db->transComplete();

            if ($db->transStatus() === false) {
                //return redirect()->back()->with('error', 'Failed to create certificate');

                throw new \Exception('Transaction failed');

            }

            return redirect()->to('admin/certificates/' . $certificateId)
                ->with('success', 'Certificate created successfully');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Certificate creation failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to create certificate: ' . $e->getMessage());
        }

    }

    /**
     * Edit certificate - only if draft status
     */
    public function edit($id)
    {

        $title                      = 'Edit Certificate';


        $page_name                  = 'certificates/form';


        $data['moduleDetail']       = $this->data;

        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Check if certificate can be edited
        if ($certificate['status'] === 'approved') {
            return redirect()->to('/certificates/view/' . $id)
                ->with('error', 'Cannot edit approved certificate');
        }

        // Get certificate with items
        $certificate = $this->certificateModel->getCertificateWithItems($id);

        // Get vendors
        $certificate['vendors'] = $this->vendorModel
            ->where('certificate_id', $id)
            ->orderBy('sequence', 'ASC')
            ->findAll();

        $data['certificate'] = $certificate;
        $data['mode'] = 'edit';
        //return view('certificates/form', $data);

        echo $this->layout_after_login($title, $page_name, $data);

    }

    /**
     * Update certificate - only if draft status
     */
    public function update($id)
    {
        $certificate = $this->certificateModel->find($id);

        if (!$certificate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Prevent update if finalized
        if ($certificate['status'] === 'approved') {
            return redirect()->back()
                ->with('error', 'Cannot update approved certificate');
        }

        // Validation
        $validation = \Config\Services::validation();

        $validationRules = [
                    'enquiry_id' => 'required',
                    'certificate_number' => 'permit_empty|max_length[255]',
                    'company_id' => 'required',
                    'enquiry_no' => 'required',
                    'company_name' => 'required|max_length[255]',
                    'plant_name' => 'required|max_length[255]',
                    'plant_address' => 'required',
                    'plant_state' => 'required|max_length[100]',
                    'collection_date' => 'required|valid_date',
                    'items.*.description' => 'required|max_length[500]',
                    'items.*.quantity' => 'required|decimal',
                    'items.*.unit' => 'required|max_length[50]',
                    'vendors.*.company_name' => 'required|max_length[255]',
                ];


        $validationMessages = [
            'enquiry_no' => [
                'required' => 'Enquiry number is required',
            ],
            'enquiry_id' => [
                'required' => 'Enquiry ID is required',
            ],
            'company_id' => [
                'required' => 'Company ID is required',
            ],
            'enquiry_no' => [
                'required' => 'Enquiry number is required',
            ],
            'company_name' => [
                'required' => 'Company name is required',
                'max_length' => 'Company name cannot exceed 255 characters',
            ],
            'plant_name' => [
                'required' => 'Plant name is required',
                'max_length' => 'Plant name cannot exceed 255 characters',
            ],
            'plant_address' => [
                'required' => 'Plant address is required',
            ],
            'plant_state' => [
                'required' => 'Plant state is required',
                'max_length' => 'Plant state cannot exceed 100 characters',
            ],
            'collection_date' => [
                'required' => 'Collection date is required',
                'valid_date' => 'Collection date must be a valid date',
            ],
            'items.*.description' => [
                'required' => 'Item description is required',
                'max_length' => 'Item description cannot exceed 500 characters',
            ],
            'items.*.quantity' => [
                'required' => 'Item quantity is required',
                'decimal' => 'Item quantity must be a valid number',
            ],
            'items.*.unit' => [
                'required' => 'Item unit is required',
                'max_length' => 'Item unit cannot exceed 50 characters',
            ],
            'vendors.*.company_name' => [
                'required' => 'Vendor company name is required',
                'max_length' => 'Vendor company name cannot exceed 255 characters',
            ],
        ];


        if (!$this->validate($validationRules)) {
            return redirect()->back()
                ->withInput()
                ->with('errors', $validation->getErrors());
        }

        $db = \Config\Database::connect();
        $db->transStart();

        try {

            // Delete old PDF file
            $this->deleteOldPDF(FCPATH . 'public/uploads/certificate/' . $certificate['pdf_path']);
            $this->deleteOldPDF(FCPATH . 'public/uploads/certificate/' . $certificate['word_path']);

            // Create version before update (for audit trail)
            $this->certificateModel->createVersion($id, session()->get('user_id'), 'Updated certificate');

            // Update main certificate data
            $updateData = [
                'company_name' => $this->request->getPost('company_name'),
                'certificate_number' => $this->request->getPost('certificate_number') ?? null,
                'plant_name' => $this->request->getPost('plant_name'),
                'plant_address' => $this->request->getPost('plant_address'),
                'plant_state' => $this->request->getPost('plant_state'),
                'collection_date' => $this->request->getPost('collection_date'),
                'version' => $certificate['version'] + 1,
                'updated_by' => session()->get('user_id'),
            ];

            $this->certificateModel->update($id, $updateData);

            // Update Items: Delete existing and re-insert
            $this->updateCertificateItems($id);

            // Update Vendors: Delete existing and re-insert
            $this->updateCertificateVendors($id);

            // Generate new PDF on the fly
            $pdfFilename = $this->generatePDF($id);

            $wordFileName = $this->saveWord($id);



            // Update certificate with new PDF path
            $this->certificateModel->update($id, ['pdf_path' => $pdfFilename, 'word_path' => $wordFileName]);


            $this->companyCertificateModel->where('enquiry_id', $certificate['enquiry_id'])->set([
                'certificate_word_file' => $wordFileName,
                'word_filename'         => pathinfo($wordFileName, PATHINFO_FILENAME),
                'certificate_file'      => $pdfFilename,
                'filename'              => pathinfo($pdfFilename, PATHINFO_FILENAME),
            ])->update();




            $db->transComplete();

            if ($db->transStatus() === false) {
                throw new \Exception('Transaction failed');
            }

            return redirect()->to('admin/certificates/' . $id)
                ->with('success', 'Certificate updated successfully (Version ' . ($certificate['version'] + 1) . ')');

        } catch (\Exception $e) {
            $db->transRollback();
            log_message('error', 'Certificate update failed: ' . $e->getMessage());
            return redirect()->back()
                ->withInput()
                ->with('error', 'Failed to update certificate: ' . $e->getMessage());
        }
    }

    /**
     * Update certificate items (helper method)
     *
     * @param int $certificateId
     * @return void
     */
    private function updateCertificateItems($certificateId)
    {
        // Delete existing items
        $this->itemModel->where('certificate_id', $certificateId)->delete();

        // Insert new items
        $items = $this->request->getPost('items');

        if (!$items || !is_array($items)) {
            throw new \Exception('At least one item is required');
        }

        $validItemsCount = 0;

        foreach ($items as $index => $item) {
            // Validate item has required fields
            if (empty($item['description']) || empty($item['quantity']) || empty($item['unit'])) {
                continue;
            }

            $this->itemModel->insert([
                'certificate_id' => $certificateId,
                'item_description' => trim($item['description']),
                'quantity' => $item['quantity'],
                'unit' => $item['unit'],
                'sequence' => $index + 1
            ]);

            $validItemsCount++;
        }

        if ($validItemsCount === 0) {
            throw new \Exception('At least one valid item is required');
        }
    }

    /**
     * Update certificate vendors (helper method)
     *
     * @param int $certificateId
     * @return void
     */
    private function updateCertificateVendors($certificateId)
    {
        // Delete existing vendors
        $this->vendorModel->where('certificate_id', $certificateId)->delete();

        // Insert new vendors
        $vendors = $this->request->getPost('vendors');

        if (!$vendors || !is_array($vendors)) {
            throw new \Exception('At least one vendor is required');
        }

        $validVendorsCount = 0;

        foreach ($vendors as $index => $vendor) {
            // Validate vendor has company name
            if (empty($vendor['company_name'])) {
                continue;
            }

            $this->vendorModel->insert([
                'certificate_id' => $certificateId,
                'vendor_id' => !empty($vendor['vendor_id']) ? $vendor['vendor_id'] : null,
                'company_name' => trim($vendor['company_name']),
                'sequence' => $index + 1,
                'cto' => !empty($vendor['cto']) ? trim($vendor['cto']) : null,
            ]);

            $validVendorsCount++;
        }

        if ($validVendorsCount === 0) {
            throw new \Exception('At least one valid vendor is required');
        }
    }

    /**
     * View certificate with all details
     */
    public function view($id)
    {

        $title                      = 'View Certificate';


        $page_name                  = 'certificates/view';


        $data['moduleDetail']       = $this->data;

        $certificate = $this->certificateModel->getCertificateWithItems($id);

        if (!$certificate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }

        // Get vendors
        $certificate['vendors'] = $this->vendorModel
            ->where('certificate_id', $id)
            ->orderBy('sequence', 'ASC')
            ->findAll();

        $data['certificate'] = $certificate;
        //return view('certificates/view', $data);

        echo $this->layout_after_login($title, $page_name, $data);

    }

    /**
     * Generate PDF and save to storage
     * Insert record into ecomm_company_certificates table
     *
     * @param int $certificateId
     * @return string PDF filename
     * @throws \Exception
     */
    private function generatePDF($certificateId)
    {
        try {
            // Get certificate with all related data
            $certificate = $this->certificateModel->getCertificateWithItems($certificateId);

            if (!$certificate) {
                throw new \Exception('Certificate not found');
            }

            // Get vendors
            $certificate['vendors'] = $this->vendorModel
                ->where('certificate_id', $certificateId)
                ->orderBy('sequence', 'ASC')
                ->findAll();

            // Generate filename
            //$filename = 'certificate_' . $certificate['certificate_number'] . '_' . time() . '.pdf';
            $filename = safeFilename($certificate['certificate_number'] ?: $certificate['enquiry_no']) . '.pdf';

            $savePath = FCPATH . 'public/uploads/certificate/' . $filename;

            // Ensure directory exists
            $directory = dirname($savePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Generate PDF
            $pdfService = new PdfService();
            $pdfService->generateCertificate($certificate, $savePath);

            // Verify PDF was created
            if (!file_exists($savePath)) {
                throw new \Exception('Failed to generate PDF file');
            }

            return $filename;

        } catch (\Exception $e) {
            log_message('error', 'PDF generation failed: ' . $e->getMessage());
            throw new \Exception('PDF generation failed: ' . $e->getMessage());
        }
    }

    public function sendForReview($id)
    {
        try {

            $certificate = $this->certificateModel->find($id);


            if (!$certificate) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
            }


            if ($certificate['status'] === 'approved') {
                return redirect()->back()->with('error_message', 'Certificate already finalized');
            }


            $this->certificateModel->reviewCertificate($id, session()->get('user_id'));


            return redirect()->to('admin/certificates/' . $id)->with('success', 'Certificate send for review successfully');

        } catch (\Exception $ex) {
            //throw $th;
            log_message('error', 'Error in sending certificate for review: ' . $ex->getMessage());
            return redirect()->back()->with('error_message', 'Error: ' . "send for review failed. Please try again.");
        }

    }

    public function finalize($id)
    {
        $certificate = $this->certificateModel->find($id);


        if (!$certificate) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }


        if ($certificate['status'] === 'approved') {
            return redirect()->back()->with('error_message', 'Certificate already approved');
        }

        // Generate final PDF with signature
        //$certificate = $this->certificateModel->getCertificateWithItems($id);

        // Get vendors
        /*$certificate['vendors'] = $this->vendorModel
            ->where('certificate_id', $id)
            ->orderBy('sequence', 'ASC')
            ->findAll();

        $filename = 'certificate_' . $certificate['certificate_number'] . '_final.pdf';
        $savePath = FCPATH . 'public/uploads/certificate/' . $filename;

        $this->pdfService->generateCertificate($certificate, $savePath);

        // Add digital signature (if configured)
        //$signatureService = new DigitalSignatureService();
        // $signatureService->signPdf($savePath, $savePath, $certPath, $keyPath, $password);*/

        // Finalize in database
        $this->certificateModel->finalizeCertificate($id, session()->get('user_id'));
        //$this->certificateModel->update($id, ['pdf_path' => $filename]);

        return redirect()->to('admin/certificates/' . $id)->with('success', 'Certificate approved successfully');
    }

    private function generateCertificateNumber($plantName = null, $enquiryNo = null)
    {
        // Generate unique certificate number
        // Format: CERT-YYYYMMDD-XXXX
        $date = date('Ymd');
        //$count = $this->certificateModel->like('certificate_number', 'CERT-' . $plantName . '-' . $enquiryNo)->countAllResults();
        //return 'CERT-' . $date . '-' . str_pad($count + 1, 4, '0', STR_PAD_LEFT);
        return 'CERT-' . $plantName . '-' . $enquiryNo;
    }

    /**
     * Get enquiry data from your existing enquiry system
     * Replace this with your actual enquiry data fetch logic
     */
    private function getEnquiryData($enquiryNo)
    {

        $db = \Config\Database::connect();

        // Main enquiry with company and plant data
        $mainData = $db->table('ecomm_enquires e')
            ->select('e.*, 
                  c.company_name as company_name,
                  c.full_address as company_address,
                  u.plant_name as plant_name, 
                  u.full_address as plant_address,
                  u.location as plant_location,
                  u.state as plant_state,
                  (SELECT COUNT(*) FROM ecomm_enquiry_products WHERE enq_id = e.id AND status = 1) as approve_count,
                  (SELECT COUNT(*) FROM ecomm_enquiry_products WHERE enq_id = e.id AND status = 0) as disapprove_count
                  ')
            ->join('ecoex_companies c', 'c.id = e.company_id', 'left')
            ->join('ecomm_users u', 'u.id = e.plant_id', 'left')
            ->where('e.id', $enquiryNo)
            ->where('u.type', 'PLANT')
            ->get()
            ->getRowArray();

        if (!$mainData) {
            return null;
        }


        $subQuery = "
    SELECT enq_id, weighted_qty, weighted_unit, item_id
    FROM ecomm_sub_enquires
    GROUP BY enq_id, item_id
        ";


        // Get complete products with item details using JOINs (only approved)
        $products = $db->table('ecomm_enquiry_products ep')
            ->select('ep.id,
                  ep.enq_id,
                  ep.product_id,
                  ep.new_product,
                  ep.new_product_name,
                  ep.new_hsn,
                  ep.qty,
                  ep.remarks,
                  ep.status,
                  
                  ci.id as item_id,
                  ci.item_category,
                  ci.item_name_ecoex,
                  ci.alias_name,
                  ci.billing_name,
                  ci.hsn,
                  ci.gst,
                  ci.rate,
                  ci.unit as unit_id,
                  
                  cat.name as category_name,
                  unit.name as unit_name,
                  se.weighted_qty,
                se.weighted_unit')
            ->join(
                'ecomm_company_items ci',
                'ci.id = IF(ep.new_product = 1, (SELECT id FROM ecomm_company_items WHERE enq_product_id = ep.id LIMIT 1), ep.product_id)',
                'left'
            )
            ->join('ecomm_product_categories cat', 'cat.id = ci.item_category', 'left')
            ->join('ecomm_units unit', 'unit.id = ci.unit', 'left')
            ->join("($subQuery) se", 'se.enq_id = ep.enq_id AND se.item_id = ep.product_id', 'left', false)
            ->where('ep.enq_id', $mainData['id'])
            ->where('ep.status', 1)
            ->where('ci.company_id = ep.company_id', null, false)
            ->orderBy('ep.id', 'ASC')
            ->get()
            ->getResultArray();



        // Get shared vendors with vendor details in ONE query using JOIN
        $sharedVendors = $db->table('ecomm_enquiry_vendor_shares evs')
            ->select('evs.*, 
                  v.id as vendor_id,
                  v.company_name as vendor_company_name')
            ->join('ecomm_users v', 'v.id = evs.vendor_id', 'left')
            ->where('evs.enq_id', $mainData['id'])
            ->where('evs.status', 1)
            ->get()
            ->getResultArray();


        // Format items
        $items = array_map(function ($product, $index) {
            return [
                'description' => $product['product_name'] ?? $product['description'] ?? '',
                'quantity' => $product['quantity'] ?? 0,
                'unit' => $product['unit'] ?? 'Kgs',
                'sequence' => $index + 1
            ];
        }, $products, array_keys($products));


        // Format vendors
        $vendors = array_map(function ($vendor) {
            return [
                'vendor_id' => $vendor['vendor_id'],
                'company_name' => $vendor['vendor_company_name'],
                'share_details' => $vendor // Full vendor share data if needed
            ];
        }, $sharedVendors);


        // Format items for certificate with complete product details
        $items = [];
        foreach ($products as $index => $product) {
            // Determine product name based on new_product flag
            if ($product['new_product'] == 1) {
                $productName = $product['item_name_ecoex'] ?: $product['new_product_name'];
                $productHSN = $product['hsn'] ?: $product['new_hsn'];
            } else {
                $productName = $product['item_name_ecoex'] ?: '';
                $productHSN = $product['hsn'] ?: '';
            }

            $items[] = [
                'description' => $productName,
                'alias_name' => $product['alias_name'] ?? '',
                'billing_name' => $product['billing_name'] ?? '',
                'category_name' => $product['category_name'] ?? '',
                'hsn' => $productHSN,
                'gst' => $product['gst'] ?? '',
                'rate' => $product['rate'] ?? '',
                'quantity' => $product['weighted_qty'] ?? 0,
                'unit' => $product['weighted_unit'] ?? '',
                'remarks' => $product['remarks'] ?? '',
                'sequence' => $index + 1,
                // Additional details if needed
                'product_id' => $product['product_id'],
                'is_new_product' => $product['new_product'],
                'item_category' => $product['item_category']
            ];
        }



        return [
            'enquiry_no' => $mainData['enquiry_no'],
            'enquiry_id' => $mainData['id'],
            'company_id' => $mainData['company_id'],
            'company_name' => $mainData['company_name'] ?: $mainData['company_name'] ?: '',
            'plant_name' => $mainData['plant_name'] ?: $mainData['plant_name'] ?: '',
            'plant_address' => $mainData['plant_address'] ?: $mainData['plant_address'] ?: '',
            'plant_location' => $mainData['plant_location'] ?: 'NA',
            'plant_state' => $mainData['plant_state'] ?: 'NA',
            'collection_date' => $mainData['tentative_collection_date'] ?? 'NA',
            'approve_product_count' => (int)$mainData['approve_count'],
            'disapprove_product_count' => (int)$mainData['disapprove_count'],
            'items' => $items,
            'shared_vendors' => $vendors,
            'vendor_count' => count($vendors),
            'enquiry_details' => $mainData
        ];

    }

    /**
     * Download PDF file
     *
     * @param int $id Certificate ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function downloadPdf($id)
    {
        try {
            $certificate = $this->certificateModel->find($id);

            if (!$certificate) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Certificate not found');
            }

            if (empty($certificate['pdf_path'])) {
                return redirect()->back()->with('error', 'PDF file not generated yet');
            }

            $filePath = FCPATH . 'public/uploads/certificate/' . $certificate['pdf_path'];

            // Check if file exists
            if (!file_exists($filePath)) {
                log_message('error', 'PDF file not found: ' . $filePath);
                return redirect()->back()->with('error', 'PDF file not found. Please regenerate the certificate.');
            }

            // Check file permissions
            if (!is_readable($filePath)) {
                log_message('error', 'PDF file not readable: ' . $filePath);
                return redirect()->back()->with('error', 'PDF file cannot be read. Please check file permissions.');
            }

            // Download the file
            return $this->response->download($filePath, null)->setFileName($certificate['pdf_path']);

        } catch (\Exception $e) {
            log_message('error', 'PDF download failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to download PDF: ' . $e->getMessage());
        }
    }

    /**
     * View PDF in browser
     *
     * @param int $id Certificate ID
     * @return \CodeIgniter\HTTP\ResponseInterface
     * @throws \CodeIgniter\Exceptions\PageNotFoundException
     */
    public function viewPdf($id)
    {
        try {
            $certificate = $this->certificateModel->find($id);

            if (!$certificate) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Certificate not found');
            }

            if (empty($certificate['pdf_path'])) {
                return redirect()->back()->with('error', 'PDF file not generated yet');
            }

            $filePath = FCPATH . 'public/uploads/certificate/' . $certificate['pdf_path'];

            // Check if file exists
            if (!file_exists($filePath)) {
                log_message('error', 'PDF file not found: ' . $filePath);
                return redirect()->back()->with('error', 'PDF file not found. Please regenerate the certificate.');
            }

            // Check file permissions
            if (!is_readable($filePath)) {
                log_message('error', 'PDF file not readable: ' . $filePath);
                return redirect()->back()->with('error', 'PDF file cannot be read. Please check file permissions.');
            }

            // Read file content
            $pdfContent = file_get_contents($filePath);

            // Return PDF for inline viewing
            return $this->response
                ->setContentType('application/pdf')
                ->setHeader('Content-Disposition', 'inline; filename="' . $certificate['pdf_path'] . '"')
                ->setBody($pdfContent);

        } catch (\Exception $e) {
            log_message('error', 'PDF view failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to view PDF: ' . $e->getMessage());
        }
    }

    /**
     * Delete old PDF file
     *
     * @param string|null $filename
     * @return bool
     */
    private function deleteOldPDF($filename)
    {
        if (empty($filename)) {
            return false;
        }

        try {
            $filePath = FCPATH . 'public/uploads/certificate/' . $filename;

            if (file_exists($filePath)) {
                if (unlink($filePath)) {
                    log_message('info', 'Old PDF deleted: ' . $filename);
                    return true;
                } else {
                    log_message('warning', 'Failed to delete old PDF: ' . $filename);
                }
            }
        } catch (\Exception $e) {
            log_message('error', 'Error deleting old PDF: ' . $e->getMessage());
        }

        return false;
    }

    // Helper methods remain the same...
    private function insertCertificateItems($certificateId)
    {
        $items = $this->request->getPost('items');
        if (!$items || !is_array($items)) {
            throw new \Exception('At least one item is required');
        }

        $validItemsCount = 0;
        foreach ($items as $index => $item) {
            if (!empty($item['description']) && !empty($item['quantity'])) {
                $this->itemModel->insert([
                    'certificate_id' => $certificateId,
                    'item_description' => trim($item['description']),
                    'quantity' => $item['quantity'],
                    'unit' => $item['unit'],
                    'sequence' => $index + 1
                ]);
                $validItemsCount++;
            }
        }

        if ($validItemsCount === 0) {
            throw new \Exception('At least one valid item is required');
        }
    }

    private function insertCertificateVendors($certificateId)
    {
        $vendors = $this->request->getPost('vendors');
        if (!$vendors || !is_array($vendors)) {
            throw new \Exception('At least one vendor is required');
        }

        $validVendorsCount = 0;
        foreach ($vendors as $index => $vendor) {
            if (!empty($vendor['company_name'])) {
                $this->vendorModel->insert([
                    'certificate_id' => $certificateId,
                    'vendor_id'     => !empty($vendor['vendor_id']) ? $vendor['vendor_id'] : null,
                    'company_name'  => trim($vendor['company_name']),
                    'sequence'      => $index + 1,
                    'cto'           => trim($vendor['cto']),
                ]);
                $validVendorsCount++;
            }
        }

        if ($validVendorsCount === 0) {
            throw new \Exception('At least one valid vendor is required');
        }
    }

    /**
     * Generate Word document and save to server
     */
    private function saveWord($certificateId)
    {
        try {

            // Get certificate with all related data
            $certificate = $this->certificateModel->getCertificateWithItems($certificateId);


            if (!$certificate) {
                throw new \Exception('Certificate not found');
            }

            // Get vendors
            $certificate['vendors'] = $this->vendorModel
                ->where('certificate_id', $certificateId)
                ->orderBy('sequence', 'ASC')
                ->findAll();


            // Initialize Word generator
            $generator = new WordDocumentGenerator($certificate);
            $phpWord = $generator->generate();

            // Define save path
            $uploadPath = FCPATH . 'public/uploads/certificate/';
            if (!is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            // Generate filename
            $fileName = safeFilename($certificate['certificate_number'] ?: $certificate['enquiry_no']) . '_' . time() . '.docx';
            //$fileName = 'certificate' . '_' . time() . '.docx';
            $savePath = $uploadPath . $fileName;

            // Save the file
            $generator->save($savePath);

            // Update database with file path (optional)
            //$this->updateCertificateWordPath($certificateId, $fileName);


            // Verify Word file was created
            if (!file_exists($savePath)) {
                throw new \Exception('Failed to generate Word file');
            }


            return $fileName;

        } catch (\Exception $e) {
            log_message('error', 'Word save failed: ' . $e->getMessage());

            throw new \Exception('Word generation failed: ' . $e->getMessage());

        }
    }

    /**
     * View Word document in browser (converts to HTML preview)
     */
    public function viewWord($certificateId)
    {
        try {


            $certificate = $this->certificateModel->find($certificateId);

            if (!$certificate) {
                throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound('Certificate not found');
            }

            if (empty($certificate['word_path'])) {
                return redirect()->back()->with('error', 'Word file not generated yet');
            }

            $wordPath = FCPATH . 'public/uploads/certificate/' . $certificate['word_path'];


            // Check if file exists
            if (!file_exists($wordPath)) {
                log_message('error', 'Word file not found: ' . $certificate['word_path']);
                return redirect()->back()->with('error', 'Word file not found. Please regenerate the certificate.');
            }


            // Check file permissions
            if (!is_readable($wordPath)) {
                log_message('error', 'Word file not readable: ' . $wordPath);
                return redirect()->back()->with('error', 'Word file cannot be read. Please check file permissions.');
            }




            // Serve the file for download/view
            return $this->response->download($wordPath, null)->setFileName(basename($wordPath));



        } catch (\Exception $e) {
            log_message('error', 'Word view failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to view Word document');
        }
    }

    public function testWord()
    {
        try {
            $phpWord = new \PhpOffice\PhpWord\PhpWord();
            $section = $phpWord->addSection();
            $section->addText('Test Document', ['bold' => true, 'size' => 14]);
            $section->addText('This is a test paragraph.');

            $filePath = WRITEPATH . 'uploads/test_word.docx';
            $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
            $objWriter->save($filePath);

            if (file_exists($filePath)) {
                return $this->response->download($filePath, null)
                                      ->setFileName('test.docx');
            }

            return 'File created but not found';
        } catch (\Exception $e) {
            return 'Error: ' . $e->getMessage();
        }
    }

    public function previewPdf($certificateId)
    {

        try {
            // Get certificate with all related data
            $certificate = $this->certificateModel->getCertificateWithItems($certificateId);

            if (!$certificate) {
                throw new \Exception('Certificate not found');
            }

            // Get vendors
            $certificate['vendors'] = $this->vendorModel
                ->where('certificate_id', $certificateId)
                ->orderBy('sequence', 'ASC')
                ->findAll();


            // return $filename;
            return view('admin/maincontents/certificates/pdf_template_v4', $certificate);

        } catch (\Exception $e) {
            log_message('error', 'PDF generation failed: ' . $e->getMessage());
            throw new \Exception('PDF generation failed: ' . $e->getMessage());
        }


    }

    /*public function uploadCertificate($companyid, $enquiryid)
    {

        $company_id                         = decoded($companyid);
        $enquiry_id                         = decoded($enquiryid);
        $company                    = $this->common_model->find_data('ecoex_companies', 'row', ['id' => $company_id], 'company_name');
        $company_name               = (($company) ? $company->company_name : '');
        $data['moduleDetail']       = $this->data;
        $data['action']             = 'Manage Certificates : ';
        $title                      = $data['action'] . ' ' . $company_name;
        $page_name                  = 'certificates/upload-certificate';
        $data['company_id']         = $company_id;
        $data['company_name']       = $company_name;
        $data['enquiry_id']         = $enquiry_id;
        $data['enquiry_data']       = $this->certificateModel->getCertificateByEnquiry($enquiry_id);

        if ($this->request->getMethod() == 'post') {
            pr($this->request->getPost());
        }
        echo $this->layout_after_login($title, $page_name, $data);

    }*/

    /*public function upload()
    {

        $db = \Config\Database::connect();
        $db->transStart();

        try {
            $companyId = $this->request->getPost('company_id');
            $enquiryId = $this->request->getPost('enquiry_id');
            $file = $this->request->getFile('certificate_file');

            if ($file && $file->isValid() && !$file->hasMoved()) {
                $newName = $file->getRandomName();
                $fileOriginalName = $file->getName();
                // Strip extension before saving
                $filenameWithoutExt = pathinfo($fileOriginalName, PATHINFO_FILENAME);

                $file->move('public/uploads/certificate', $newName); // Store securely

                $fields = [
                    //'company_id'        => $companyId,
                    //'enquiry_id'        => $enquiryId,
                    //'certificate_type'  => 1,
                    'certificate_file'  => $newName,
                    'filename'          => $filenameWithoutExt,
                    //'created_at'        => date('Y-m-d H:i:s'),
                    'updated_at'        => date('Y-m-d H:i:s'),
                    'status'            => 1
                ];
                //$this->common_model->save_data('ecomm_company_certificates', $fields, '', 'id');
                $this->companyCertificateModel->where('enquiry_id', $enquiryId)
                                                ->where('company_id', $companyId)
                                                ->where('certificate_type', 1)
                                                ->set($fields)
                                                ->update();
                //update certificate table
                //find certificate by enquiry id
                $certificate = $this->certificateModel->where('enquiry_id', $enquiryId)->first();
                if ($certificate) {
                    $this->certificateModel->finalizeCertificate(
                        $certificate['id'],
                        session()->get('user_id')
                    );
                }

                $db->transComplete();

                if ($db->transStatus() === false) {
                    throw new \Exception('Transaction failed');
                }

                return $this->response->setJSON(['status' => 'success', 'file' => $newName]);
            }
            return $this->response->setStatusCode(400)->setJSON(['status' => 'error', 'message' => 'File upload failed.']);

        } catch (\Exception $ex) {
            //throw $th;

            $db->transRollback();
            log_message('error', 'Certificate update failed: ' . $ex->getMessage());
            return $this->response->setStatusCode(500)->setJSON(['status' => 'error', 'message' => 'Failed to upload certificate: ' . $ex->getMessage()]);
        }

    }*/


}
