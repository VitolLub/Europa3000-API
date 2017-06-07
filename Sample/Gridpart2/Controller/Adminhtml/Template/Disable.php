<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;
use Magento\Framework\App\Bootstrap;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;
use \Magento\Catalog\Api\ProductRepositoryInterface;

class Disable extends \Magento\Backend\App\Action
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
        ProductRepositoryInterface $productRepository,
        PageFactory $resultPageFactory
    ) {
        parent::__construct($context);
        $this->productRepository = $productRepository;
        $this->resultPageFactory = $resultPageFactory;
    }

    /**
     * Index action
     *
     * @return \Magento\Backend\Model\View\Result\Page
     */
    public function execute()
    {
        $resultRedirect = $this->resultRedirectFactory->create();
        $tableCollection = curl_init("http://212.243.175.10:8080/E3k.Web/api/Table/066/Count");
        curl_setopt($tableCollection, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($tableCollection, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
        curl_setopt($tableCollection, CURLOPT_TIMEOUT, 1);
        curl_setopt($tableCollection, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($tableCollection);
        $a = json_decode($return);

        for($i=0;$i<count($a);$i++) {
            $pruductData = curl_init("http://212.243.175.10:8080/E3k.Web/api/Article/IsDeletable/".$i);
            curl_setopt($pruductData, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($pruductData, CURLOPT_USERPWD, "jira" . ":" . "meiko17");
            curl_setopt($pruductData, CURLOPT_RETURNTRANSFER, TRUE);
            $returnPruductData = curl_exec($pruductData);
            $bReturnPruductData = json_decode($returnPruductData);

            if($returnPruductData=="true"){
                $processArticleNumber = curl_init("http://212.243.175.10:8080/E3k.Web/api/Article/".$i);
                curl_setopt($processArticleNumber, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
                curl_setopt($processArticleNumber, CURLOPT_POSTFIELDS, "[\"ArticleNumber\"]");
                curl_setopt($processArticleNumber, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
                curl_setopt($processArticleNumber, CURLOPT_TIMEOUT, 1);
                curl_setopt($processArticleNumber, CURLOPT_RETURNTRANSFER, TRUE);
                $returnPruductData2 = curl_exec($processArticleNumber);
                $bReturnPruductData2 = json_decode($returnPruductData2);

                if(!isset($bReturnPruductData2->ArticleNumber)){

                }else{
                        $product = $this->productRepository->get(trim($bReturnPruductData2->ArticleNumber));
                        if($product!==false){
                            $product->setStatus(\Magento\Catalog\Model\Product\Attribute\Source\Status::STATUS_DISABLED);
                            $this->productRepository->save($product);
                        }

                }

            }
            if($i==1000){
                break;
            }


        }
        return $resultRedirect->setPath('*/*/');


    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sample_Gridpart2::gridpart2_template');
    }
    public function isAjaxLoaded()
    {
        return true;
    }
}