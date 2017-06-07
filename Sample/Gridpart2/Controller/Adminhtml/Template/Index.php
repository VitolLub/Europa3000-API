<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;

use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
class Index extends \Magento\Backend\App\Action
{
    /**
     * @var PageFactory
     */
    protected $resultPageFactory;

    /**
     * @param Context $context
     * @param PageFactory $resultPageFactory
     */
    public function __construct(
        Context $context,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Page $resultPage */
        $resultPage = $this->resultPageFactory->create();
        $resultPage->setActiveMenu('Sample_Gridpart2::gridpart2_template_ui');
        $resultPage->addBreadcrumb(__('API Synchronization'), __('API Synchronization'));
        $resultPage->addBreadcrumb(__('API Synchronization'), __('API Synchronization'));
        $resultPage->getConfig()->getTitle()->prepend(__('API Synchronization'));

        return $resultPage;
    }
    public function getSess() {
        echo "sddddd";
    }
     /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sample_Gridpart2::gridpart2_template');
    }
}