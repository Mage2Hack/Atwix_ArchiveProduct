<?php

class Atwix_ArchiveProduct_Helper_Data extends Mage_Core_Helper_Abstract
{
    protected $_libDirectoryPath;
    protected $_adapter;

    public function __construct()
    {
        $this->_libDirectoryPath = Mage::getBaseDir('lib');
        try {
            require_once $this->_libDirectoryPath . DS . 'internal' . DS . 'atwix' . DS . 'archiveproduct' . DS . 'Adapter.php';
            $this->_adapter = new Atwix\ArchiveProduct\Adapter\Atwix_ArchiveProduct_Adapter();

        } catch (Exception $e) {
            Mage::log($this->__('Cannot load library for ArchiveProduct extension'). "\n" . $e->__toString(), Zend_Log::ERR);
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