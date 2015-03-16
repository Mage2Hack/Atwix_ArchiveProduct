<?php

class Atwix_ArchiveProduct_Model_Observer
{
    public function chnageDeleteUrlToArchiveUrl($observer)
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
}