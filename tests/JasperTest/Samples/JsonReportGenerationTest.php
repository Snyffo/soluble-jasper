<?php

declare(strict_types=1);

namespace JasperTest\Samples;

use JasperTest\Util\PDFUtils;
use Soluble\Jasper\DataSource\EmptyDataSource;
use Soluble\Jasper\Exception\JavaProxiedException;
use Soluble\Jasper\Report;
use PHPUnit\Framework\TestCase;
use Soluble\Japha\Bridge\Adapter as BridgeAdapter;
use Soluble\Jasper\ReportParams;
use Soluble\Jasper\ReportProperties;
use Soluble\Jasper\ReportRunnerFactory;

class JsonReportGenerationTest extends TestCase
{
    /**
     * @var BridgeAdapter
     */
    protected $ba;

    public function setUp()
    {
        $this->ba = \JasperTestsFactories::getJavaBridgeAdapter();
    }

    public function testCSV()
    {
        /*
         * JRCsvDataSource dataSource = new JRCsvDataSource(JRLoader.getLocationInputStream("data/CsvDataSource.txt"));
        dataSource.setRecordDelimiter("\r\n");
        //				dataSource.setUseFirstRowAsHeader(true);
        dataSource.setColumnNames(columnNames);
         */
        $this->assertTrue(true);
    }

    public function testDefaultReport()
    {
        $reportFile = \JasperTestsFactories::getReportBaseDir() . '/10_report_test_json_northwind.jrxml';
        $jsonFile = \JasperTestsFactories::getDataBaseDir() . '/northwind.json';

        $reportRunner = ReportRunnerFactory::getBridgedReportRunner($this->ba);

        $dataSource = new EmptyDataSource();

        $reportParams = new ReportParams();

        $report = new Report($reportFile, $reportParams, $dataSource);

        $report->setReportProperties(new ReportProperties(
            [
                'net.sf.jasperreports.json.source'         => $jsonFile,
                'net.sf.jasperreports.json.date.pattern'   => 'yyyy-MM-dd',
                'net.sf.jasperreports.json.number.pattern' => '#,##0.##',
                'net.sf.jasperreports.json.locale.code'    => 'en_GB',
                'net.sf.jasperreports.json.timezone.id'    => 'Europe/Brussels',
            ]
        ));

        $exportManager = $reportRunner->getExportManager($report);

        $output_pdf = \JasperTestsFactories::getOutputDir() . '/test_json.pdf';
        if (file_exists($output_pdf)) {
            unlink($output_pdf);
        }

        try {
            $exportManager->savePdf($output_pdf);
        } catch (JavaProxiedException $e) {
            //var_dump($e->getJvmStackTrace());
            throw $e;
        }

        $pdfUtils = new PDFUtils();
        $text = $pdfUtils->getPDFText($output_pdf);

        $this->assertContains('Customer Order List', $text);
        //$this->assertContains('Alfreds Futterkiste', $text);
    }
}