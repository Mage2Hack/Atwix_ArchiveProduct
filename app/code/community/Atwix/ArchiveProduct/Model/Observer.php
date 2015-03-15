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
}