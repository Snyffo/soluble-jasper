<?php

declare(strict_types=1);

namespace JasperTest\Proxy\Engine;

use JasperTestsFactories;
use PHPUnit\Framework\TestCase;
use Soluble\Japha\Bridge\Adapter as BridgeAdapter;
use Soluble\Jasper\Report;
use Soluble\Jasper\ReportRunnerFactory;

class JasperReportTest extends TestCase
{
    /**
     * @var BridgeAdapter
     */
    protected $bridgeAdapter;

    public function setUp()
    {
        $this->bridgeAdapter = \JasperTestsFactories::getJavaBridgeAdapter();
    }

    public function testGetResourceBundle()
    {
        $report = new Report(JasperTestsFactories::getDefaultReportFile());

        $reportRunner = ReportRunnerFactory::getBridgedReportRunner($this->bridgeAdapter);
        $jasperReport = $reportRunner->compileReport($report);

        $this->assertNull($jasperReport->getResourceBundle());
    }
}
