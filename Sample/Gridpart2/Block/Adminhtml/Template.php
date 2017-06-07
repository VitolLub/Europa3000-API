<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

/**
 * Newsletter templates page content block
 *
 * @author      Magento Core Team <core@magentocommerce.com>
 */
namespace Sample\Gridpart2\Block\Adminhtml;

class Template extends \Magento\Backend\Block\Template
{
    /**
     * @var string
     */
    protected $_template = 'template/list.phtml';

    
    /**
     * @return $this
     */
    protected function _prepareLayout()
    {
        $this->getToolbar()->addChild(
            'add_button',
            'Magento\Backend\Block\Widget\Button',
            [
                'label' => __('Add New Template'),
                'onclick' => "window.location='" . $this->getCreateUrl() . "'",
                'class' => 'add primary add-template'
            ]
        );

        return parent::_prepareLayout();
    }

    /**
     * Get the url for create
     *
     * @return string
     */
    public function getCreateUrl()
    {
        return $this->getUrl('*/*/new');
    }

    /**
     * Get header text
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        return __(' Api Synchronization');
    }

    public function getAjaxUrl(){
        return $this->getUrl("module/index/view"); // Controller Url
    }
}
