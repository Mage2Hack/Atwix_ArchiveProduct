<?php

class Atwix_ArchiveProduct_Block_Adminhtml_Archiveproduct extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    /**
     * Set template
     */
    public function __construct()
    {
        $this->_blockGroup = 'atwix_archiveproduct';
        $this->_controller = 'adminhtml_archiveproduct';
        $this->_headerText = Mage::helper('atwix_archiveproduct')->__('Archived Products');
        parent::__construct();
        $this->setTemplate('atwix_archiveproduct/catalog/product.phtml');
        $this->_removeButton('add');
    }

    /**
     * Prepare button and grid
     *
     * @return Mage_Adminhtml_Block_Catalog_Product
     */
    protected function _prepareLayout()
    {
        $storeSwitcherBlock = $this->getLayout()
            ->createBlock('adminhtml/store_switcher', 'store_switcher')
            ->setUseConfirm(false);
        $this->setChild('store_switcher', $storeSwitcherBlock);
        return parent::_prepareLayout();
    }


    /**
     * Render grid
     *
     * @return string
     */
    public function getGridHtml()
    {
        return $this->getChildHtml('grid');
    }

    /**
     * Check whether it is single store mode
     *
     * @return bool
     */
    public function isSingleStoreMode()
    {
        if (!Mage::app()->isSingleStoreMode()) {
            return false;
        }
        return true;
    }
}