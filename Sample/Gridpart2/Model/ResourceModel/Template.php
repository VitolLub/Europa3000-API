<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Model\ResourceModel;

/**
 * Directory Country Resource Model
 */
class Template extends \Magento\Framework\Model\ResourceModel\Db\AbstractDb
{
    
    /**
     * Construct
     *
     * @param \Magento\Framework\Model\ResourceModel\Db\Context $context
     * @param string|null $resourcePrefix
     */
    public function __construct(
        \Magento\Framework\Model\ResourceModel\Db\Context $context,
        $resourcePrefix = null
    ) {
        parent::__construct($context, $resourcePrefix);     
    }
    
    /**
     * Resource initialization
     *
     * @return void
     */
    protected function _construct()
    {
        $this->_init('api_synchronization', 'apisynchronization_id');
    }
    
    

}
