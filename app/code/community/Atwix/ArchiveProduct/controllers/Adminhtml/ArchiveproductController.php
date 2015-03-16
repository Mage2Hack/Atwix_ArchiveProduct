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
        if (!is_array($productIds)) {
            $this->_getSession()->addError($this->__('Please select product(s).'));
        } else {
            if (!empty($productIds)) {
                try {
                    foreach ($productIds as $productId) {
                        $product = Mage::getSingleton('catalog/product')->load($productId);
                        Mage::dispatchEvent('catalog_controller_product_delete', array('product' => $product));
                        $product->delete();
                    }
                    $this->_getSession()->addSuccess(
                        $this->__('Total of %d record(s) have been deleted.', count($productIds))
                    );
                } catch (Exception $e) {
                    $this->_getSession()->addError($e->getMessage());
                }
            }
        }
        $this->_redirect('*/*/index');
    }

    public function massRestoreAction()
    {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $isArchived = null;

        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($productIds, array('is_archived' => $isArchived), $storeId);

            $this->_getSession()->addSuccess(
                $this->__('Total of %d record(s) have been restored.', count($productIds))
            );
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while restoring product(s) .'));
        }

        $this->_redirect('*/*/', array('store'=> $storeId));
    }

    public function massArchiveAction()
    {
        $productIds = (array)$this->getRequest()->getParam('product');
        $storeId    = (int)$this->getRequest()->getParam('store', 0);
        $isArchived = 1;

        try {
            Mage::getSingleton('catalog/product_action')
                ->updateAttributes($productIds, array('is_archived' => $isArchived), $storeId);

            $this->_getSession()->addSuccess(
                $this->__('Total of %d record(s) have been archived.', count($productIds))
            );
        }
        catch (Mage_Core_Model_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Mage_Core_Exception $e) {
            $this->_getSession()->addError($e->getMessage());
        } catch (Exception $e) {
            $this->_getSession()
                ->addException($e, $this->__('An error occurred while archiving product(s) .'));
        }

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

}