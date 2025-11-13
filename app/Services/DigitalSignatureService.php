<?php

// ============================================
// ALTERNATIVE: DIGITAL SIGNATURE SERVICE FOR DOMPDF
// ============================================
// File: app/Services/DigitalSignatureService.php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class DigitalSignatureService
{
    /**
     * Add watermark/stamp to PDF for visual authentication
     * This is a visual signature approach since Dompdf doesn't support PKI signatures
     *
     * @param array $certificateData Certificate data
     * @param string $signatureImagePath Path to signature image
     * @param string $outputPath Output PDF path
     * @return bool
     */
    public function addVisualSignature($certificateData, $signatureImagePath, $outputPath)
    {
        // Add signature path to data
        $certificateData['signature_path'] = $signatureImagePath;
        $certificateData['has_signature'] = true;

        // Generate PDF with signature embedded
        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'Arial');

        $dompdf = new Dompdf($options);

        $html = view('certificates/pdf_template', $certificateData);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        // Save to file
        file_put_contents($outputPath, $dompdf->output());

        return true;
    }

    /**
     * Add QR code for verification (alternative to digital signature)
     *
     * @param array $certificateData Certificate data
     * @param string $qrCodePath Path to generated QR code image
     * @param string $outputPath Output PDF path
     * @return bool
     */
    public function addQrCodeVerification($certificateData, $qrCodePath, $outputPath)
    {
        // Add QR code to certificate data
        $certificateData['qr_code_path'] = $qrCodePath;
        $certificateData['verification_url'] = base_url('verify/' . $certificateData['certificate_number']);

        $options = new Options();
        $options->set('isHtml5ParserEnabled', true);
        $options->set('isRemoteEnabled', true);

        $dompdf = new Dompdf($options);

        $html = view('certificates/pdf_template', $certificateData);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());

        return true;
    }

    /**
     * Generate verification hash for certificate authenticity
     *
     * @param array $certificateData Certificate data
     * @return string Hash for verification
     */
    public function generateVerificationHash($certificateData)
    {
        // Create a unique hash based on certificate data
        $dataString = json_encode([
            'certificate_number' => $certificateData['certificate_number'],
            'client_name' => $certificateData['client_name'],
            'collection_date' => $certificateData['collection_date'],
            'finalized_at' => $certificateData['finalized_at'] ?? ''
        ]);

        // Generate secure hash
        return hash_hmac('sha256', $dataString, getenv('encryption.key'));
    }
}
