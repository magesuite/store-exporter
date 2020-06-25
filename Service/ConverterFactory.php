<?php

namespace MageSuite\StoreExporter\Service;

class ConverterFactory
{
    /**
     * @var \MageSuite\OrderExport\Helper\Configuration
     */
    protected $configuration;

    /**
     * @var array
     */
    protected $convertersMap;

    public function __construct(
        \MageSuite\OrderExport\Helper\Configuration $configuration,
        array $convertersMap
    ) {
        $this->configuration = $configuration;
        $this->convertersMap = $convertersMap;
    }

    /**
     * @return \MageSuite\StoreExporter\Service\ConverterInterface
     */
    public function create()
    {
        $exportType = $this->configuration->getExportFileType();

        if (!isset($this->convertersMap[$exportType])) {
            return null;
        }

        return $this->convertersMap[$exportType];
    }
}
