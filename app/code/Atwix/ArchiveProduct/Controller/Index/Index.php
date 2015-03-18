<?php
namespace Atwix\ArchiveProduct\Controller\Index;

use Magento\Framework\App\Action\Context;

class Index extends \Magento\Framework\App\Action\Action
{
    /**
     * @var \Atwix\ArchiveProduct\Helper\Data
     */
    protected $_coreHelper;

    /**
     * @param Context $context
     * @param \Atwix\ArchiveProduct\Helper\Data $coreHelper
     */
    public function __construct(
        Context $context,
       \Atwix\ArchiveProduct\Helper\Data $coreHelper

    )
    {
        parent::__construct($context);
        $this->_coreHelper = $coreHelper;
    }

    public function execute()
    {
         var_dump($this->_coreHelper->someFunction());
    }
}
?>