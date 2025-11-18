<?php

// ============================================
// PDF SERVICE WITH DOMPDF
// ============================================
// File: app/Services/PdfService.php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Models\CommonModel;

class PdfService
{
    protected $dompdf;
    protected $options;
    protected $common_model;

    public function __construct()
    {
        // Configure Dompdf options
        $this->options = new Options();
        $this->options->set('isHtml5ParserEnabled', true);
        $this->options->set('isRemoteEnabled', true);
        $this->options->set('defaultFont', 'Arial');
        $this->options->set('chroot', FCPATH); // Allow access to public folder for images

        // Initialize Dompdf
        $this->dompdf = new Dompdf($this->options);

        // Set paper size and orientation
        $this->dompdf->setPaper('A4', 'portrait');

        $this->common_model     = new CommonModel();
    }

    /**
     * Generate certificate PDF
     *
     * @param array $data Certificate data including items
     * @param string|null $savePath Path to save PDF file (if null, returns as string)
     * @return string|bool PDF content as string or save status
     */
    public function generateCertificate($data, $savePath = null)
    {

        $data['general_settings']   = $this->common_model->find_data('general_settings', 'row');

        // Load the certificate template view
        $html = view('admin/maincontents/certificates/pdf_template_v4', $data);

        // Load HTML into Dompdf
        $this->dompdf->loadHtml($html);

        // Render the PDF
        $this->dompdf->render();

        // Save or return PDF
        if ($savePath) {
            // Ensure directory exists
            $directory = dirname($savePath);
            if (!is_dir($directory)) {
                mkdir($directory, 0755, true);
            }

            // Save to file
            file_put_contents($savePath, $this->dompdf->output());
            return true;
        }

        // Return as string for streaming
        return $this->dompdf->output();
    }

    /**
     * Add image-based signature to PDF
     *
     * @param string $pdfPath Path to existing PDF
     * @param string $signatureImagePath Path to signature image
     * @param array $certificateData Certificate data for context
     * @return bool
     */
    public function addImageSignature($pdfPath, $signatureImagePath, $certificateData)
    {
        // With Dompdf, we include signature in the template itself
        // This method is for adding signature after PDF generation

        // Read existing PDF content
        $existingPdf = file_get_contents($pdfPath);

        // Reload with signature
        $certificateData['signature_path'] = $signatureImagePath;
        $html = view('admin/maincontents/certificates/pdf_template', $certificateData);

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        // Save updated PDF
        file_put_contents($pdfPath, $this->dompdf->output());

        return true;
    }

    /**
     * Stream PDF to browser for download
     *
     * @param array $data Certificate data
     * @param string $filename Filename for download
     * @return void
     */
    public function streamPdf($data, $filename = 'certificate.pdf')
    {
        $html = view('admin/maincontents/certificates/pdf_template', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        // Stream the PDF to browser
        $this->dompdf->stream($filename, [
            'Attachment' => true // Set to false to display in browser
        ]);
    }

    /**
     * Generate PDF and return as response for CodeIgniter
     *
     * @param array $data Certificate data
     * @param string $filename Filename for download
     * @return \CodeIgniter\HTTP\ResponseInterface
     */
    public function downloadResponse($data, $filename = 'certificate.pdf')
    {
        $html = view('admin/maincontents/certificates/pdf_template', $data);

        $this->dompdf->loadHtml($html);
        $this->dompdf->render();

        $output = $this->dompdf->output();

        // Return as CodeIgniter response
        return response()
            ->setContentType('application/pdf')
            ->setHeader('Content-Disposition', 'attachment; filename="' . $filename . '"')
            ->setBody($output);
    }
}
