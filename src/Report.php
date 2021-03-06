<?php

declare(strict_types=1);

/*
 * Jasper report integration for PHP
 *
 * @link      https://github.com/belgattitude/soluble-jasper
 * @author    Vanvelthem Sébastien
 * @copyright Copyright (c) 2017-2019 Vanvelthem Sébastien
 * @license   MIT
 */

namespace Soluble\Jasper;

use Soluble\Jasper\DataSource\Contract\DataSourceInterface;
use Soluble\Jasper\Exception\ReportFileNotFoundException;
use Soluble\Jasper\Report\ReportStatusInterface;

class Report implements ReportStatusInterface
{
    /**
     * @var string
     */
    private $reportFile;

    /**
     * @var ReportParams
     */
    private $reportParams;

    /**
     * @var DataSourceInterface
     */
    private $dataSource;

    public function __construct(string $reportJRXMLFile, ReportParams $reportParams = null, DataSourceInterface $dataSource = null)
    {
        if (!file_exists($reportJRXMLFile)) {
            throw new ReportFileNotFoundException(
                sprintf(
                    'The report file "%s" cannot be found.',
                    $reportJRXMLFile
                )
            );
        }

        if ($reportParams !== null) {
            $this->setReportParams($reportParams);
        }

        if ($dataSource !== null) {
            $this->setDataSource($dataSource);
        }

        $this->reportFile = $reportJRXMLFile;
    }

    public function setReportParams(ReportParams $reportParams): void
    {
        $this->reportParams = $reportParams;
    }

    public function getReportParams(): ?ReportParams
    {
        return $this->reportParams;
    }

    public function setDataSource(DataSourceInterface $dataSource): void
    {
        $this->dataSource = $dataSource;
    }

    public function getDataSource(): ?DataSourceInterface
    {
        return $this->dataSource;
    }

    /**
     * @return string current jrxml report file
     */
    public function getReportFile(): string
    {
        return $this->reportFile;
    }

    public function getReportPath(): string
    {
        return dirname($this->reportFile);
    }

    public function getStatus(): string
    {
        return ReportStatusInterface::STATUS_FRESH;
    }
}
