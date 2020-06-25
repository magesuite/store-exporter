<?php

namespace MageSuite\StoreExporter\Service;

abstract class BaseConverter implements ConverterInterface
{
    /**
     * @var string
     */
    protected $fileName;

    /**
     * @var  \Magento\Framework\App\Filesystem\DirectoryList
     */
    protected $directoryList;

    /**
     * @var \Magento\Framework\App\Response\Http\FileFactory
     */
    protected $fileFactory;

    public function __construct(
        \Magento\Framework\App\Filesystem\DirectoryList $directoryList,
        \Magento\Framework\App\Response\Http\FileFactory $fileFactory
    ) {
        $this->directoryList = $directoryList;
        $this->fileFactory = $fileFactory;
    }

    public function getFileResponse() {
        if (! file_exists($this->getFilePath())) {
            throw new \Magento\Framework\Exception\NotFoundException();
        }

        $content = [];
        $content['type'] = 'filename';
        $content['value'] = $this->fileName;
        $content['rm'] = '1';

        return $this->fileFactory->create($this->fileName, $content, \Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR);
    }

    public function getFilePath(){
        return $this->directoryList
                ->getPath(\Magento\Framework\App\Filesystem\DirectoryList::VAR_DIR) . "/" . $this->fileName;
    }

    public function setFileName($fileName) {
        $this->fileName = $fileName;
    }
}
