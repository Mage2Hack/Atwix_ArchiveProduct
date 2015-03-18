<?php

class Atwix_ArchiveProduct_Adminhtml_ArchiveproductController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Catalog'))->_title($this->__('Manage Archived Orders'));
        $this->loadLayout();
        $this->_setActiveMenu('catalog/atwix_archiveproduct');
        $this->_addContent($this->getLayout()->createBlock('atwix_archiveproduct/adminhtml_archiveproduct'));
        $this->renderLayout();
    }

    public function gridAction()
    {
        $this->loadLayout();
        $this->getResponse()->setBody(
            $this->getLayout()->createBlock('atwix_archiveproduct/adminhtml_archiveproduct_grid')->toHtml()
        );
    }

    public function massDeleteAction()
    {
        $productIds = $this->getRequest()->getParam('product');
        $helper = Mage::helper('atwix_archiveproduct');
        $helper->destroyProducts($productIds);
        $this->_redirect('*/*/index');
    }

    public function massRestoreAction()
    {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $isArchived = null;
        $helper = Mage::helper('atwix_archiveproduct');
        $helper->toggleArchiveProducts($productIds, $isArchived, $storeId);
        $this->_redirect('*/*/', array('store'=> $storeId));
    }

    public function massArchiveAction()
    {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $isArchived = 1;
        $helper = Mage::helper('atwix_archiveproduct');
        $helper->toggleArchiveProducts($productIds, $isArchived, $storeId);
        $this->_redirect('*/catalog_product/', array('store'=> $storeId));
    }

    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('catalog/atwix_archiveproduct');
    }

    /**
     * Archive product action
     */
    public function archiveAction()
    {
        $productIds = (array)$this->getRequest()->getParam('id');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $isArchived = 1;
        $helper = Mage::helper('atwix_archiveproduct');
        $helper->toggleArchiveProducts($productIds, $isArchived, $storeId);

        $this->getResponse()
            ->setRedirect($this->getUrl('*/catalog_product/', array('store' => $storeId)));
    }
}