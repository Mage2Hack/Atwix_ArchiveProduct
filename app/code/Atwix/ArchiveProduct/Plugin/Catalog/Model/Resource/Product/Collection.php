<?php

namespace Atwix\ArchiveProduct\Plugin\Catalog\Model\Resource\Product;

class Collection
{
    protected $_request;

    public function __construct(\Magento\Framework\App\RequestInterface $request)
    {
        $this->_request = $request;
    }

    /**
     * Removes archive product from products collection
     *
     * @param \Magento\Catalog\Model\Resource\Product\Collection $collection
     */
    public function beforeLoad(\Magento\Catalog\Model\Resource\Product\Collection $collection)
    {
        if ($this->_request->getModuleName() != 'archiveproduct') {
            $collection->addAttributeToFilter('is_archived', array('null' => true), 'left');
        }
    }
}