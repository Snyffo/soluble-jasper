<?php

declare(strict_types=1);

namespace JasperTest;

use Soluble\Jasper\Exception\ReportFileNotFoundException;
use Soluble\Jasper\Report;
use PHPUnit\Framework\TestCase;
use Soluble\Jasper\Report\ReportStatusInterface;

class ReportTest extends TestCase
{
    /**
     * @var string
     */
    protected $reportFile;

    public function setUp(): void
    {
        $this->reportFile = \JasperTestsFactories::getReportBaseDir() . '/01_report_default.jrxml';
    }

    public function testConstructThrowsMissingReportFileException(): void
    {
        $this->expectException(ReportFileNotFoundException::class);
        new Report('/sdkfjlksdjf/sdfsdfs.jrxml');
    }

    public function testGetReportFile(): void
    {
        $report = new Report($this->reportFile);
        self::assertFileEquals($this->reportFile, $report->getReportFile());
    }

    public function testGetStatus(): void
    {
        $report = new Report($this->reportFile);
        self::assertEquals(ReportStatusInterface::STATUS_FRESH, $report->getStatus());
    }
}
