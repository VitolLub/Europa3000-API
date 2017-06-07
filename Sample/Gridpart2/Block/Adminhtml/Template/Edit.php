<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */

// @codingStandardsIgnoreFile

/**
 * Newsletter Template Edit Block
 *
 * @author     Magento Core Team <core@magentocommerce.com>
 */
namespace Sample\Gridpart2\Block\Adminhtml\Template;


class Edit extends \Magento\Backend\Block\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\Block\Template\Context $context
     * @param \Magento\Cms\Model\Wysiwyg\Config $wysiwygConfig
     * @param \Magento\Framework\Registry $registry
     * @param array $data
     */
    public function __construct(
        \Magento\Backend\Block\Template\Context $context,
        \Magento\Framework\Registry $registry,
        array $data = []
    ) {
        $this->_coreRegistry = $registry;
        parent::__construct($context, $data);
    }

    /**
     * Retrieve template object
     *
     * @return \Magento\Newsletter\Model\Template
     */
    public function getModel()
    {
        return $this->_coreRegistry->registry('_gridpart2_template');
    }

    /**
     * Preparing block layout
     *
     * @return $this
     * @SuppressWarnings(PHPMD.ExcessiveMethodLength)
     */
    protected function _prepareLayout()
    {

        $this->getToolbar()->addChild(
            'back_button',
            'Magento\Backend\Block\Widget\Button',
            [
                'label' => __('Back'),
                'onclick' => "window.location.href = '" . $this->getUrl('*/*') . "'",
                'class' => 'action-back'
            ]
        );

        $this->getToolbar()->addChild(
            'reset_button',
            'Magento\Backend\Block\Widget\Button',
            [
                'label' => __('Reset'),
                'onclick' => 'window.location.href = window.location.href',
                'class' => 'reset'
            ]
        );

        

        if ($this->getRequest()->getParam('id', false)) {
            $this->getToolbar()->addChild(
                'delete_button',
                'Magento\Backend\Block\Widget\Button',
                [
                    'label' => __('Delete Template'),
                    'data_attribute' => [
                        'role' => 'template-delete',
                    ],
                    'class' => 'delete'
                ]
            );

          
        }

            $this->getToolbar()->addChild(
                'save_button',
                'Magento\Backend\Block\Widget\Button',
                [
                    'label' => __('Save Template'),
                    'data_attribute' => [
                        'role' => 'template-save',
                    ],
                    'class' => 'save primary',
                    'onclick' => 'window.location.href = window.location.href',

                ]
            );
        

        return parent::_prepareLayout();
    }

    /**
     * Return edit flag for block
     *
     * @return boolean
     * @SuppressWarnings(PHPMD.BooleanGetMethodName)
     */
    public function getEditMode()
    {
        
        if ($this->getModel()->getId()) {
            return true;
        }
        return false;
    }

    /**
     * Return header text for form
     *
     * @return \Magento\Framework\Phrase
     */
    public function getHeaderText()
    {
        if ($this->getRequest()->getParam('id', false)) {
            return __('Edit  Template');
        }

        return __('New  Template');
    }

    /**
     * Return form block HTML
     *
     * @return string
     */
    public function getForm()
    {
        return $this->getLayout()->createBlock('Sample\Gridpart2\Block\Adminhtml\Template\Edit\Form')->toHtml();
    }

   

    /**
     * Return action url for form
     *
     * @return string
     */
    public function getSaveUrl()
    {
        return $this->getUrl('*/*/save');
    }

    /**
     * Return delete url for customer group
     *
     * @return string
     */
    public function getDeleteUrl()
    {
        return $this->getUrl('*/*/delete', ['id' => $this->getRequest()->getParam('id')]);
    }

    /**
     * Retrieve Save As Flag
     *
     * @return int
     */
    public function getSaveAsFlag()
    {
        return $this->getRequest()->getParam('_save_as_flag') ? '1' : '';
    }

    /**
     * Getter for single store mode check
     *
     * @return boolean
     */
    protected function isSingleStoreMode()
    {
        return $this->_storeManager->isSingleStoreMode();
    }

    /**
     * Getter for id of current store (the only one in single-store mode and current in multi-stores mode)
     *
     * @return int
     */
    protected function getStoreId()
    {
        return $this->_storeManager->getStore(true)->getId();
    }
}
