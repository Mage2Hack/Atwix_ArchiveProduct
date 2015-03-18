<?php

namespace Atwix\ArchiveProduct\Controller\Adminhtml\Product;

class MassDelete extends \Magento\Catalog\Controller\Adminhtml\Product\MassDelete
{
    /**
     * @var \Atwix\ArchiveProduct\Helper\Data
     */
    protected $_coreHelper;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder
     * @param \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory
     */
    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Catalog\Controller\Adminhtml\Product\Builder $productBuilder,
        \Magento\Backend\Model\View\Result\RedirectFactory $resultRedirectFactory,
        \Atwix\ArchiveProduct\Helper\Data $coreHelper

    ) {
        $this->_coreHelper = $coreHelper;
        parent::__construct($context, $productBuilder, $resultRedirectFactory);
    }


    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $productIds = $this->getRequest()->getParam('product');
        $storeId = (int) $this->getRequest()->getParam('store', 0);

        $this->_coreHelper->toggleArchiveProducts($productIds, 1, $storeId);

        return $this->resultRedirectFactory->create()->setPath('catalog/*/index');
    }
}
