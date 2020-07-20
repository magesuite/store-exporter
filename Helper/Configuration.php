<?php

namespace MageSuite\StoreExporter\Helper;

class Configuration extends \Magento\Framework\App\Helper\AbstractHelper
{
    const XML_PATH_ORDER_EXPORT_PERIODICAL_CONFIG = 'store_exporter/general/export_file_type';

    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $scopeConfig;

    protected $exportFileType = null;

    public function __construct(
        \Magento\Framework\App\Helper\Context $context,
        \Magento\Framework\App\Config\ScopeConfigInterface $scopeConfigInterface
    ) {
        parent::__construct($context);

        $this->scopeConfig = $scopeConfigInterface;
    }

    public function getExportFileType()
    {
        if ($this->exportFileType === null) {
            $this->exportFileType = $this->scopeConfig->getValue(self::XML_PATH_ORDER_EXPORT_PERIODICAL_CONFIG, \Magento\Store\Model\ScopeInterface::SCOPE_STORE);
        }

        return $this->exportFileType;
    }
}
