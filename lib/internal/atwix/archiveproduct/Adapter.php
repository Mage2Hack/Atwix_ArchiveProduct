<?php

namespace Atwix\ArchiveProduct\Adapter;

/**
 * The set of methods compatible for both Magento versions
 *
 * Class Atwix_ArchiveProduct_Adapter
 * @package Atwix\ArchiveProduct\Adapter
 */
class Atwix_ArchiveProduct_Adapter {

    /**
     * @var \Magento\Framework\ObjectManagerInterface
     */
    protected $_objectManager;

    /**
     * @var \Magento\Framework\Message\ManagerInterface
     */
    protected $_messageManager;

    public function __construct($messageManager = NULL, $objectManager = NULL)
    {
        $this->_messageManager = $messageManager;
        $this->_objectManager = $objectManager;
    }

    /**
     * Archives/Restores products. Depends on $isArchived flag
     *
     * @param array $productIds
     * @param int $isArchived
     * @param int $storeId
     * @return $this
     */
    public function toggleArchiveProducts($productIds, $isArchived = 1, $storeId = 0)
    {
        if (!is_array($productIds) || empty($productIds)) {
            $this->_addMessage('Please select product(s).', 'error'); // TODO: translation
        } else {
            try {
                $this->_updateAttributes($productIds, ['is_archived' => $isArchived], $storeId);
                if (NULL != $isArchived) {
                    $this->_addMessage(sprintf('A total of %s record(s) have been moved to trash.',
                        count($productIds)), 'success');
                } else {
                    $this->_addMessage(sprintf('A total of %s record(s) have been restored.',
                        count($productIds)), 'success');
                }
            } catch (\Exception $e) {
                $this->_addMessage($e->getMessage(), 'error');
            }
        }
        return $this;
    }

    /**
     * Removes products permanently
     *
     * @param array $productIds
     * @return $this
     */
    public function destroyProducts($productIds)
    {
        if (!is_array($productIds) || empty($productIds)) {
            $this->_addMessage('Please select product(s).', 'error'); // TODO: translation
        } else {
            try {
                foreach ($productIds as $productId) {
                    $product = $this->_loadProduct($productId);
                    $product->delete();
                }
                $this->_addMessage(sprintf('A total of %s record(s) have been deleted.',
                    count($productIds)), 'success');
            } catch (\Exception $e) {
                $this->_addMessage($e->getMessage(), 'error');
            }
        }
        return $this;
    }

    /**
     * Adds message to messages bag
     *
     * @param string $message
     * @param string $type
     */
    protected function _addMessage($message, $type)
    {
        switch ($type) {
            case 'error' :
                if (NULL != $this->_messageManager) {
                    $this->_messageManager->addError($message);
                } else {
                    \Mage::getSingleton('adminhtml/session')->addError($message);
                }
            break;
            case 'success' :
                if (NULL != $this->_messageManager) {
                    $this->_messageManager->addSuccess($message);
                } else {
                    \Mage::getSingleton('adminhtml/session')->addSuccess($message);
                }
            break;
            default:
                if (NULL != $this->_messageManager) {
                    $this->_messageManager->addMessage($message);
                } else {
                    \Mage::getSingleton('adminhtml/session')->addMessage($message);
                }
        }
    }

    /**
     * Updates producs attributes
     *
     * @param array $productIds
     * @param array $attributes
     * @param int $storeId
     */
    protected function _updateAttributes($productIds, $attributes, $storeId)
    {
        if (NULL != $this->_objectManager) {
            $this->_objectManager->get('Magento\Catalog\Model\Product\Action')
                ->updateAttributes($productIds, $attributes, $storeId);
        } else {
                \Mage::getSingleton('catalog/product_action')
                    ->updateAttributes($productIds, $attributes, $storeId);
        }
    }

    /**
     * Loads product's entity by id
     *
     * @param int $productId
     * @return mixed
     */
    protected function _loadProduct($productId)
    {
        if (NULL != $this->_objectManager) {
            return $this->_objectManager->get('Magento\Catalog\Model\Product')->load($productId);
        } else {
            // For Magento 1
            return \Mage::getModel('catalog/product')->load($productId);
        }

    }
}