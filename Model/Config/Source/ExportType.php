<?php
namespace MageSuite\StoreExporter\Model\Config\Source;

class ExportType implements \Magento\Framework\Option\ArrayInterface
{
    const EXPORT_FILE_TYPE_CSV = 'csv';
    const EXPORT_FILE_TYPE_XML = 'xml';

    public function toOptionArray()
    {
        return [
            self::EXPORT_FILE_TYPE_CSV => __('Csv'),
            self::EXPORT_FILE_TYPE_XML => __('Xml')
        ];
    }
}
