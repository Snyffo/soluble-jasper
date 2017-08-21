<?php

declare(strict_types=1);

namespace Soluble\Jasper\Exporter;

use Soluble\Jasper\Report;
use Soluble\Jasper\Runner\Bridged\Proxy\FilledJasperReport;
use Soluble\Jasper\Runner\Bridged\Proxy\JasperExportManager;
use Soluble\Jasper\Runner\Bridged\JRDataSourceFactory;
use Soluble\Jasper\Runner\Bridged\Proxy\JRDataSourceInterface;
use Soluble\Jasper\Runner\BridgedReportRunner;
use Soluble\Japha\Bridge\Adapter as BridgeAdapter;

class BridgedExportManager implements ExportManagerInterface
{
    /**
     * @var BridgedReportRunner
     */
    private $runner;

    /**
     * @var Report
     */
    private $report;

    /**
     * @var FilledJasperReport
     */
    private $filledReport;

    /**
     * @var BridgeAdapter
     */
    private $ba;

    /**
     * @var JasperExportManager
     */
    private $exportManager;

    public function __construct(BridgedReportRunner $runner, Report $report)
    {
        $this->runner = $runner;
        $this->report = $report;
        $this->ba = $runner->getBridgeAdapter();
        $this->exportManager = new JasperExportManager($this->ba);
    }

    public function savePdf(string $outputFile): void
    {
        $this->exportManager->exportReportToPdfFile($this->getFilledReport()->getJavaProxiedObject(), $outputFile);
        // Attempt to speed up
        //$this->exportManager->exportToPdfFile($this->report->getReportFile(), $outputFile);
    }

    protected function getFilledReport(): FilledJasperReport
    {
        if ($this->filledReport === null) {
            $compiledReport = $this->runner->compileReport($this->report);
            $this->filledReport = $this->runner->fillReport(
                                                    $compiledReport,
                                                    $this->report->getReportParams(),
                                                    $this->getJRDataSource()
            );
        }

        return $this->filledReport;
    }

    protected function getJRDataSource(): ?JRDataSourceInterface
    {
        if ($this->report->getDataSource() === null) {
            return null;
        }

        return (new JRDataSourceFactory($this->ba))($this->report->getDataSource());
    }
}