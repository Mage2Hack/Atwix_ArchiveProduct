<?php

class Atwix_ArchiveProduct_Model_Observer
{
    public function changeMassDeleteUrlToMassArchiveUrl($observer)
    {
        $block = $observer->getBlock();
        $massactionItemsArray = $block->getMassactionBlock()->getItems();
        $archiveMassactionUrl = Mage::helper("adminhtml")->getUrl('*/archiveproduct/massArchive');
        $massactionItemsArray['delete']->setUrl($archiveMassactionUrl);
    }

    public function addIsArchivedFilter($observer)
    {
        $collection = $observer->getCollection();
        $controllerName = Mage::app()->getRequest()->getControllerName();
        if ($controllerName !== 'archiveproduct'){
            $collection->addAttributeToFilter('is_archived', array('null' => true), 'left');
        }
    }

    public function changeDeleteUrlToArchiveUrl($observer)
    {
        $controllerName = Mage::app()->getRequest()->getControllerName();
        $actionName = Mage::app()->getRequest()->getActionName();
        if ($controllerName === 'catalog_product' && $actionName === 'edit') {
            $block = $observer->getBlock();
            if ($block->getId() === 'product_edit') {
                $deleteButton = $block->getChild('delete_button');
                $archiveUrl = Mage::helper("adminhtml")->getUrl('*/archiveproduct/archive', array('_current'=>true));
                $onClick = 'confirmSetLocation(\'' . Mage::helper('catalog')->__('Are you sure?').'\', \''.$archiveUrl.'\')';
                $deleteButton->setData('onclick', $onClick);
            }
        }
    }

}