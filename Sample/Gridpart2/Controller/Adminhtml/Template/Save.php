<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;

use Magento\Framework\App\TemplateTypesInterface;
use Magento\Framework\Exception\LocalizedException;
use Magento\Framework\Controller\ResultFactory;

class Save extends \Sample\Gridpart2\Controller\Adminhtml\Template
{
    /**
     * Save Newsletter Template
     *
     * @return void
     */
    public function execute()
    {
        /** @var \Magento\Backend\Model\View\Result\Redirect $resultRedirect */
        $resultRedirect = $this->resultRedirectFactory->create();
        $request = $this->getRequest();
        if (!$request->isPost()) {
            $this->getResponse()->setRedirect($this->getUrl('*/template'));
        }

        $template = $this->_objectManager->create('Sample\Gridpart2\Model\Template');
        $id = (int)$request->getParam('pid');
        /*$template->setData('name',
            $request->getParam('name')
        )->setData('status',
            $request->getParam('status')
        );*/
        if((int)$request->getParam('status')==2){
            $stat = 0;
        }else{
            $stat = 1;
        }
        $date = date('Y.m.d');
        $data = array('name'=>$request->getParam('name'),'dateupdate'=>$date,'status'=>$stat);
        $objectManager = \Magento\Framework\App\ObjectManager::getInstance();
        $model = $objectManager->create('Sample\Gridpart2\Model\Template')->load($id)->addData($data);;

        try {
            $model->setId($id)->save();
            echo "Data updated successfully.";

        } catch (Exception $e){
            echo $e->getMessage();
        }


        return $resultRedirect->setPath('*/*/');
    }
}
