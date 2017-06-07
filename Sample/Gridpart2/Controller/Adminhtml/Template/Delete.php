<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;


class Delete extends \Sample\Gridpart2\Controller\Adminhtml\Template
{
    /**
     * Delete action
     *
     * @return \Magento\Backend\Model\View\Result\Redirect
     */
    public function execute()
    {
        // check if we know what should be deleted
        $id = $this->getRequest()->getParam('id');
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        if ($id) {
            $title = "";
            try {
                // init model and delete
                $model = $this->_objectManager->create('Sample\Gridpart2\Model\Template');
                $model->load($id);
                $model->delete();
                // display success message
                $this->messageManager->addSuccess(__('The gift card template  has been deleted.'));
                // go to grid
               
                return $resultRedirect->setPath('*/*/');
            } catch (\Exception $e) {
                // display error message
                $this->messageManager->addError($e->getMessage());
                // go back to edit form
                return $resultRedirect->setPath('*/*/edit', ['id' => $id]);
            }
        }
        // display error message
        $this->messageManager->addError(__('We can\'t find a gift card template to delete.'));
        // go to grid
        return $resultRedirect->setPath('*/*/');
    }
}
