<?php

namespace App\Libraries;

use PhpOffice\PhpWord\PhpWord;
use PhpOffice\PhpWord\SimpleType\Jc;
use PhpOffice\PhpWord\IOFactory;
use PhpOffice\PhpWord\Shared\Converter;

class WordDocumentGenerator
{
    private $phpWord;
    private $section;
    private $data;

    public function __construct($data)
    {
        $this->data = $data;
        $this->phpWord = new PhpWord();

        // Set default font
        $this->phpWord->setDefaultFontName('Arial');
        $this->phpWord->setDefaultFontSize(11);

        // Set document properties
        $properties = $this->phpWord->getDocInfo();
        $properties->setCreator('Karma Ecotech Limited');
        $properties->setTitle('Scrap Collection Certificate');

        // Create section with margins (convert mm to twips: 1mm = 56.7 twips)
        $this->section = $this->phpWord->addSection([
            'marginTop' => Converter::cmToTwip(1.5),
            'marginBottom' => Converter::cmToTwip(1.5),
            'marginLeft' => Converter::cmToTwip(1.5),
            'marginRight' => Converter::cmToTwip(1.5),
        ]);
    }

    public function generate()
    {
        // Add header row (Ref and Date)
        $this->addHeaderRow();

        // Add title
        $this->addTitle();

        // Add main content
        $this->addMainContent();

        // Add plant information
        $this->addPlantInfo();

        // Add quantities title
        $this->addQuantitiesTitle();

        // Add items list
        $this->addItemsList();

        // Add footer text with vendors
        $this->addFooterText();

        // Add signature section
        $this->addSignatureSection();

        // Add footer information for finalized certificates
        if (isset($this->data['status']) && $this->data['status'] === 'finalized') {
            $this->addFooterInfo();
        }

        return $this->phpWord;
    }

    private function addHeaderRow()
    {
        $tableStyle = [
            'borderSize' => 0,
            'borderColor' => 'FFFFFF',
            'cellMargin' => 0,
            'width' => 100 * 50,
            'unit' => \PhpOffice\PhpWord\SimpleType\TblWidth::PERCENT
        ];

        $table = $this->section->addTable($tableStyle);
        $table->addRow();

        // Left cell - Ref
        $cellLeft = $table->addCell(4500, ['valign' => 'top']);
        $textRun = $cellLeft->addTextRun(['alignment' => Jc::START]);
        $textRun->addText('Ref: ', ['bold' => true, 'size' => 11]);
        $textRun->addText($this->sanitizeForWord($this->data['certificate_number']) ?? '', ['size' => 11]);

        // Right cell - Date
        $cellRight = $table->addCell(4500, ['valign' => 'top']);
        $issueDate = isset($this->data['issue_date'])
            ? date('d-m-Y', strtotime($this->data['issue_date']))
            : date('d-m-Y');
        $textRunRight = $cellRight->addTextRun(['alignment' => Jc::END]);
        $textRunRight->addText('Date: ', ['bold' => true, 'size' => 11]);
        $textRunRight->addText($issueDate, ['size' => 11]);

        $this->section->addTextBreak(1);
    }

    private function addTitle()
    {
        $this->section->addText(
            'TO WHOM-SO-EVER IT MAY CONCERN',
            [
                'bold' => true,
                'size' => 14,
                'underline' => 'single'
            ],
            [
                'alignment' => Jc::CENTER,
                'spaceBefore' => Converter::pointToTwip(10),
                'spaceAfter' => Converter::pointToTwip(10)
            ]
        );

        $this->section->addTextBreak(1);
    }

    private function addMainContent()
    {
        $companyName = $this->data['company_name'] ?? '';
        $collectionDate = isset($this->data['collection_date'])
            ? date('d-m-Y', strtotime($this->data['collection_date']))
            : '';

        $textRun = $this->section->addTextRun([
            'alignment' => Jc::BOTH,
            'spaceAfter' => Converter::pointToTwip(10)
        ]);

        $textRun->addText(
            'This certificate confirms that Karma Ecotech Limited (Ecoex) collected scrap materials from ',
            ['size' => 11]
        );
        $textRun->addText($this->sanitizeForWord($companyName), ['size' => 11, 'bold' => true]);
        $textRun->addText(' on ', ['size' => 11]);
        $textRun->addText($collectionDate, ['size' => 11, 'bold' => true]);
        $textRun->addText(' at the following location:', ['size' => 11]);

        $this->section->addTextBreak(1);
    }

    private function addPlantInfo()
    {
        $plantName = $this->sanitizeForWord($this->data['plant_name'] ?? '');
        $plantAddress = $this->sanitizeForWord($this->data['plant_address'] ?? '');
        $plantState = $this->sanitizeForWord($this->data['plant_state'] ?? '');

        // Plant Name
        $textRun1 = $this->section->addTextRun(['spaceAfter' => Converter::pointToTwip(5)]);
        $textRun1->addText('Plant Name: ', ['size' => 11, 'bold' => true]);
        $textRun1->addText($plantName, ['size' => 11]);

        // Plant Address
        $textRun2 = $this->section->addTextRun(['spaceAfter' => Converter::pointToTwip(10)]);
        $textRun2->addText('Plant Address: ', ['size' => 11, 'bold' => true]);
        $textRun2->addText($plantAddress, ['size' => 11]);

        if (!empty($plantState)) {
            $textRun2->addText(', ' . $plantState, ['size' => 11]);
        }

        $this->section->addTextBreak(1);
    }

    private function addQuantitiesTitle()
    {
        $this->section->addText(
            'Quantities Collected (in Nos & Kgs.)',
            ['bold' => true, 'size' => 11],
            ['spaceAfter' => Converter::pointToTwip(5)]
        );
    }

    private function addItemsList()
    {
        $items = $this->data['items'] ?? [];

        if (empty($items)) {
            $this->section->addListItem(
                'No items specified.',
                0,
                ['size' => 11, 'bold' => true],
                null,
                null
            );
        } else {
            $numberingStyle = 'decimal';

            foreach ($items as $index => $item) {
                $description = $item['item_description'] ?? $this->sanitizeForWord($item['description']) ?? '';
                $quantity = $item['quantity'] ?? 0;
                $unit = $item['unit'] ?? '';

                // Format quantity based on unit
                if (strtolower($unit) === 'nos' || strtolower($unit) === 'pcs') {
                    $formattedQty = number_format($quantity, 0);
                } else {
                    $formattedQty = number_format($quantity, 2);
                }

                $itemText = $description . ' : ' . $formattedQty . ' ' . $unit . '.';

                $this->section->addListItem(
                    $itemText,
                    0,
                    ['size' => 11, 'bold' => true],
                    ['spaceAfter' => Converter::pointToTwip(3)],
                    $numberingStyle
                );
            }
        }

        $this->section->addTextBreak(1);
    }

    private function addFooterText()
    {
        $companyName = $this->sanitizeForWord($this->data['company_name']) ?? '';
        $vendors = $this->data['vendors'] ?? [];
        $plantState = $this->sanitizeForWord($this->data['plant_state'] ?? 'State');

        $textRun = $this->section->addTextRun([
            'alignment' => Jc::BOTH,
            'spaceAfter' => Converter::pointToTwip(10)
        ]);

        $textRun->addText(
            'Collected scrap materials including trademarked materials from ',
            ['size' => 11]
        );
        $textRun->addText($companyName, ['size' => 11, 'bold' => true]);
        $textRun->addText(' plant are being picked up by ', ['size' => 11]);

        // Add vendor names
        if (!empty($vendors)) {
            $vendorNames = array_map(function ($v) {
                return $v['company_name'] ?? '';
            }, $vendors);

            if (count($vendorNames) === 1) {
                $textRun->addText($vendorNames[0], ['size' => 11]);
            } elseif (count($vendorNames) === 2) {
                $textRun->addText($vendorNames[0] . ' and ' . $vendorNames[1], ['size' => 11]);
            } else {
                $lastVendor = array_pop($vendorNames);
                $textRun->addText(implode(', ', $vendorNames) . ', and ' . $lastVendor, ['size' => 11]);
            }
        } else {
            $textRun->addText('authorized vendors', ['size' => 11]);
        }

        $textRun->addText(' on behalf of Karma Ecotech Limited and sent to ', ['size' => 11]);

        // Add recycler name
        if (!empty($vendors)) {
            $recycler = end($vendors);
            $textRun->addText($recycler['company_name'], ['size' => 11]);
        } else {
            $textRun->addText('authorized recyclers', ['size' => 11]);
        }

        $textRun->addText(
            ' (Recycler Listed in ' . $plantState . ' Pollution Control Board) for recycling purposes. Karma Ecotech Limited (Ecoex) will channelize these materials according to industry standards.',
            ['size' => 11]
        );
    }

    private function addSignatureSection()
    {
        $this->section->addTextBreak(2);

        $this->section->addText(
            'Sincerely,',
            ['size' => 11],
            ['spaceAfter' => Converter::pointToTwip(5)]
        );

        // Add signature image if available
        if (isset($this->data['signature_path']) && !empty($this->data['signature_path'])) {
            $signaturePath = WRITEPATH . 'uploads/signatures/' . $this->data['signature_path'];

            if (file_exists($signaturePath)) {
                try {
                    $this->section->addImage(
                        $signaturePath,
                        [
                            'height' => 50,
                            'wrappingStyle' => 'inline',
                            'positioning' => 'relative',
                            'posHorizontalRel' => 'margin',
                            'posVerticalRel' => 'line'
                        ]
                    );
                } catch (\Exception $e) {
                    log_message('error', 'Failed to add signature image: ' . $e->getMessage());
                    $this->section->addTextBreak(2);
                }
            } else {
                $this->section->addTextBreak(2);
            }
        } else {
            $this->section->addTextBreak(2);
        }

        $this->section->addText(
            'For Karma Ecotech Limited',
            ['size' => 11],
            ['spaceAfter' => Converter::pointToTwip(5)]
        );

        $this->section->addText(
            'Authorized Signatory',
            ['size' => 11, 'bold' => true]
        );
    }

    private function addFooterInfo()
    {
        $this->section->addTextBreak(2);

        // Add separator line using text
        $this->section->addText(
            str_repeat('_', 80),
            ['size' => 8, 'color' => 'CCCCCC']
        );

        $certNumber = $this->data['certificate_number'] ?? '';
        $enquiryNo = $this->data['enquiry_no'] ?? 'N/A';
        $finalizedAt = isset($this->data['finalized_at'])
            ? date('d-m-Y H:i', strtotime($this->data['finalized_at']))
            : date('d-m-Y H:i');
        $version = $this->data['version'] ?? '1';

        $textRun1 = $this->section->addTextRun(['spaceAfter' => Converter::pointToTwip(3)]);
        $textRun1->addText('Certificate Number: ', ['size' => 8, 'bold' => true, 'color' => '666666']);
        $textRun1->addText($certNumber . ' | ', ['size' => 8, 'color' => '666666']);
        $textRun1->addText('Enquiry Number: ', ['size' => 8, 'bold' => true, 'color' => '666666']);
        $textRun1->addText($enquiryNo, ['size' => 8, 'color' => '666666']);

        $textRun2 = $this->section->addTextRun();
        $textRun2->addText('Finalized on: ', ['size' => 8, 'bold' => true, 'color' => '666666']);
        $textRun2->addText($finalizedAt . ' | ', ['size' => 8, 'color' => '666666']);
        $textRun2->addText('Version: ', ['size' => 8, 'bold' => true, 'color' => '666666']);
        $textRun2->addText($version, ['size' => 8, 'color' => '666666']);
    }

    public function save($filePath)
    {
        try {

            \PhpOffice\PhpWord\Settings::setOutputEscapingEnabled(true);

            // Clear ALL output buffers to avoid corrupt ZIP/DOCX writing
            while (ob_get_level()) {
                ob_end_clean();
            }

            // Disable compression
            if (function_exists('apache_setenv')) {
                @apache_setenv('no-gzip', 1);
            }
            @ini_set('zlib.output_compression', 'Off');

            $objWriter = IOFactory::createWriter($this->phpWord, 'Word2007');
            $objWriter->save($filePath);
            return $filePath;
        } catch (\Exception $e) {
            log_message('error', 'Failed to save Word document: ' . $e->getMessage());
            throw new \Exception('Failed to save Word document: ' . $e->getMessage());
        }
    }

    public function download($fileName = 'certificate.docx')
    {
        try {
            // Clear any previous output
            if (ob_get_level()) {
                ob_end_clean();
            }

            // Set headers
            header('Content-Type: application/vnd.openxmlformats-officedocument.wordprocessingml.document');
            header('Content-Disposition: attachment;filename="' . $fileName . '"');
            header('Cache-Control: max-age=0');
            header('Cache-Control: max-age=1');
            header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
            header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
            header('Cache-Control: cache, must-revalidate');
            header('Pragma: public');

            $objWriter = IOFactory::createWriter($this->phpWord, 'Word2007');
            $objWriter->save('php://output');
            exit;
        } catch (\Exception $e) {
            log_message('error', 'Failed to download Word document: ' . $e->getMessage());
            throw new \Exception('Failed to generate Word document: ' . $e->getMessage());
        }
    }

    private function sanitizeForWord($text)
    {
        if (empty($text)) {
            return '';
        }

        // Remove or replace problematic characters
        $text = str_replace(["\r\n", "\r", "\n"], ' ', $text);
        $text = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]/', '', $text);
        $text = trim($text);

        return $text;
    }

}
