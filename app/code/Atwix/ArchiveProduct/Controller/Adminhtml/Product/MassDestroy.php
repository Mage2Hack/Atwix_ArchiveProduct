<?php

namespace Atwix\ArchiveProduct\Controller\Adminhtml\Product;

class MassDestroy extends \Magento\Catalog\Controller\Adminhtml\Product
{
    /**
     * @var \Atwix\ArchiveProduct\Helper\Data
     */
    protected $_coreHelper;

    /**
     * @var \Magento\Backend\Model\View\Result\RedirectFactory
     */
    protected $resultRedirectFactory;

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
        parent::__construct($context, $productBuilder);
        $this->resultRedirectFactory = $resultRedirectFactory;
    }

    /**
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        $productIds = $this->getRequest()->getParam('product');
        $this->_coreHelper->destroyProducts($productIds);
        return $this->resultRedirectFactory->create()->setPath('archiveproduct/*/index');
    }
}