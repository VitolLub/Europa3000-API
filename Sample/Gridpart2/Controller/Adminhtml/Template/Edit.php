<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;

class Edit extends \Sample\Gridpart2\Controller\Adminhtml\Template
{
    /**
     * Core registry
     *
     * @var \Magento\Framework\Registry
     */
    protected $_coreRegistry = null;

    /**
     * @param \Magento\Backend\App\Action\Context $context
     * @param \Magento\Framework\Registry $coreRegistry
     */
    public function __construct(\Magento\Backend\App\Action\Context $context, \Magento\Framework\Registry $coreRegistry)
    {
        $this->_coreRegistry = $coreRegistry;
        parent::__construct($context);
    }

    /**
     * Edit Newsletter Template
     *
     * @return void
     */
    public function execute()
    {
        $model = $this->_objectManager->create('Sample\Gridpart2\Model\Template');
        $id = $this->getRequest()->getParam('id');
        if ($id) {
            $model->load($id);
        }

        $this->_coreRegistry->register('_api_synchronization', $model);

        $this->_view->loadLayout();
        $this->_setActiveMenu('Sample_Gridpart2::api_synchronization');

        if ($model->getId()) {
            $breadcrumbTitle = __('Edit Template');
            $breadcrumbLabel = $breadcrumbTitle;
        } else {
            $breadcrumbTitle = __('New Template');
            $breadcrumbLabel = __('Create  Template');
        }
        $this->_view->getPage()->getConfig()->getTitle()->prepend(__(' Templates'));
        $this->_view->getPage()->getConfig()->getTitle()->prepend(
            $model->getId() ? $model->getTemplateId() : __('New Template')
        );

        $this->_addBreadcrumb($breadcrumbLabel, $breadcrumbTitle);

        // restore data
        $values = $this->_getSession()->getData('gridpart2_template_form_data', true);
        if ($values) {
            $model->addData($values);
        }

        $this->_view->renderLayout();
    }
}
