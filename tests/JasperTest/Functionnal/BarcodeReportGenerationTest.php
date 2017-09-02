<?php

declare(strict_types=1);

namespace JasperTest\Functionnal;

use JasperTest\Util\PDFUtils;
use Soluble\Jasper\Report;
use PHPUnit\Framework\TestCase;
use Soluble\Japha\Bridge\Adapter as BridgeAdapter;
use Soluble\Jasper\ReportParams;
use Soluble\Jasper\ReportRunnerFactory;

class BarcodeReportGenerationTest extends TestCase
{
    /**
     * @var BridgeAdapter
     */
    protected $ba;

    public function setUp()
    {
        $this->ba = \JasperTestsFactories::getJavaBridgeAdapter();
    }

    public function testDefaultReport()
    {
        $reportFile = \JasperTestsFactories::getReportBaseDir() . '/06_report_barcodes.jrxml';

        $reportRunner = ReportRunnerFactory::getBridgedReportRunner($this->ba);

        $report = new Report($reportFile, new ReportParams([
            'BookTitle'    => 'Soluble Jasper',
            'BookSubTitle' => 'Generated from unit tests'
        ]));

        $exportManager = $reportRunner->getExportManager($report);

        $output_pdf = \JasperTestsFactories::getOutputDir() . '/test_barcode.pdf';
        if (file_exists($output_pdf)) {
            unlink($output_pdf);
        }

        $exportManager->savePdf($output_pdf);

        // open the pdf and check for text

        $pdfUtils = new PDFUtils();
        $text = $pdfUtils->getPDFText($output_pdf);

        $this->assertContains('Test with barcodes', $text);
    }
}