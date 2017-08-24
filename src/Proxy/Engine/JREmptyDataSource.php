<?php

declare(strict_types=1);

namespace Soluble\Jasper\Proxy\Engine;

use Soluble\Japha\Interfaces\JavaObject;
use Soluble\Japha\Bridge\Adapter as BridgeAdapter;

class JREmptyDataSource implements JRDataSourceInterface
{
    /**
     * @var BridgeAdapter
     */
    private $ba;

    /**
     * @var \Soluble\Japha\Interfaces\JavaObject
     */
    private $jrEmptyDataSource;

    public function __construct(BridgeAdapter $bridgeAdapter)
    {
        $this->ba = $bridgeAdapter;
        $this->jrEmptyDataSource = $this->ba->java('net.sf.jasperreports.engine.JREmptyDataSource');
    }

    /**
     * @return JavaObject Java('net.sf.jasperreports.engine.JREmptyDataSource')
     */
    public function getJavaProxiedObject(): JavaObject
    {
        return $this->jrEmptyDataSource;
    }
}