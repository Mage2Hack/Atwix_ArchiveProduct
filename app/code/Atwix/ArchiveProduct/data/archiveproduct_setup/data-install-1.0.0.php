<?php

/* @var $installer \Magento\Catalog\Model\Resource\Setup */
$installer = $this;

$installer->addAttribute(
    \Magento\Catalog\Model\Product::ENTITY,
    'is_archived',
    [
        'type' => 'int',
        'backend' => '',
        'frontend' => '',
        'label' => 'Removed Product',
        'input' => '',
        'class' => '',
        'source' => '',
        'global' => \Magento\Catalog\Model\Resource\Eav\Attribute::SCOPE_GLOBAL,
        'visible' => false,
        'required' => false,
        'user_defined' => false,
        'default' => 0,
        'searchable' => false,
        'filterable' => false,
        'comparable' => false,
        'visible_on_front' => false,
        'used_in_product_listing' => false,
        'unique' => false,
        'apply_to' => ''
    ]
);