<?php

namespace MageSuite\StoreExporter\Service;

interface ConverterInterface {
    /**
     * @param \Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection
     */
    public function convert(\Magento\Framework\Model\ResourceModel\Db\Collection\AbstractCollection $sourceCollection);

    /**
     * @return \Magento\Framework\App\ResponseInterface
     * @throws \Magento\Framework\Exception\NotFoundException
     */
    public function getFileResponse();

    /**
     * @return string
     */
    public function getFilePath();
}
