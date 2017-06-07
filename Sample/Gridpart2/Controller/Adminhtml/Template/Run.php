<?php
/**
 *
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;


class Run extends \Sample\Gridpart2\Controller\Adminhtml\Template
{


    public function execute()
    {
        $id = $this->getRequest()->getParam('id');
        switch ($id) {
            case 1:
                $this->_forward('quantity');
                break;
            case 2:
                $this->_forward('newproduct');
                break;
            case 3:
                $this->_forward('product');
                break;
            case 5:
                $this->_forward('disable');
                break;
            case 8:
                $this->_forward('grouped');
                break;
        }
        //
        
    }
}
