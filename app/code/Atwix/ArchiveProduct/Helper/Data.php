<?php

namespace Atwix\ArchiveProduct\Helper;

use Magento\Framework\App\Filesystem\DirectoryList;

class Data {

    protected $_libDirectoryPath;
    protected $_logger;
    protected $_adapter;

    public function __construct(
        \Psr\Log\LoggerInterface $logger,
        \Magento\Framework\Message\ManagerInterface $messageManager,
        \Magento\Framework\ObjectManagerInterface $objectManager
    )
    {
        $this->_libDirectoryPath = DirectoryList::getDefaultConfig()[DirectoryList::LIB_INTERNAL]['path'];
        $this->_logger = $logger;

        try {
            require_once $this->_libDirectoryPath . '/atwix/archiveproduct/Adapter.php';
            $this->_adapter = new \Atwix\ArchiveProduct\Adapter\Atwix_ArchiveProduct_Adapter(
                $messageManager, $objectManager);

        } catch (Exception $e) {
            $logger->critical('Cannot load library for ArchiveProduct extension');
        }
    }

    public function toggleArchiveProducts($productIds, $isArchived, $storeId)
    {
        return $this->_adapter->toggleArchiveProducts($productIds, $isArchived, $storeId);
    }

    public function destroyProducts($productIds)
    {
        return $this->_adapter->destroyProducts($productIds);
    }
}