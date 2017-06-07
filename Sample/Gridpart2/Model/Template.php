<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

/**
 * Country model
 *
 * @method \Magento\Directory\Model\Resource\Country _getResource()
 * @method \Magento\Directory\Model\Resource\Country getResource()
 * @method string getCountryId()
 * @method \Magento\Directory\Model\Country setCountryId(string $value)
 */
namespace Sample\Gridpart2\Model;


class Template extends \Magento\Framework\Model\AbstractModel
{
    /**
     * CMS page cache tag
     */
    const CACHE_TAG = 'api_synchronization';

    /**
     * Template's Statuses
     */
    const STATUS_ENABLED = 1;
    const STATUS_DISABLED = 0;

    /**
     * @param \Magento\Framework\Model\Context $context
     * @param \Magento\Framework\Registry $registry
     * @param \Magento\Framework\Model\ResourceModel\AbstractResource|null $resource
     * @param \Magento\Framework\Data\Collection\AbstractDb|null $resourceCollection
     * @param \Magento\Framework\UrlInterface $urlBuilder
     * @param array $data
     */
    function __construct(
        \Magento\Framework\Model\Context $context,
        \Magento\Framework\Registry $registry,
        \Magento\Framework\Model\ResourceModel\AbstractResource $resource = null,
        \Magento\Framework\Data\Collection\AbstractDb $resourceCollection = null,
        array $data = [])
    {
        parent::__construct($context, $registry, $resource, $resourceCollection, $data);
    }

    /**
     * @return void
     */
    protected function _construct()
    {
        $this->_init('Sample\Gridpart2\Model\ResourceModel\Template');
    }
    
       
    /**
     * Prepare post's statuses.
     * Available event blog_post_get_available_statuses to customize statuses.
     *
     * @return array
     */
    public function getAvailableStatuses()
    {
        return [self::STATUS_ENABLED => __('Enabled'), self::STATUS_DISABLED => __('Disabled')];
    }
    
    


}
