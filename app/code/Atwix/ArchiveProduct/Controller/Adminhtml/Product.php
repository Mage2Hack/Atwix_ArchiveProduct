<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace  Atwix\ArchiveProduct\Controller\Adminhtml;

use Magento\Backend\App\Action;

/**
 * Catalog product controller
 * @SuppressWarnings(PHPMD.NumberOfChildren)
 */
class Product extends \Magento\Backend\App\Action
{
    /**
     * @var Product\Builder
     */
    protected $productBuilder;

    /**
     * @param Action\Context $context
     * @param Product\Builder $productBuilder
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
    ) {
        $this->productBuilder = $productBuilder;
        parent::__construct($context);
    }


    /**
     * Check for is allowed
     *
     * @return boolean
     */
    protected function _isAllowed()
    {
        // TODO: change to the actual ACL
        return true;
    }
}
