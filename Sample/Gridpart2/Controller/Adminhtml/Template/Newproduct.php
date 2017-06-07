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

class Newproduct extends \Magento\Backend\App\Action
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
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        $state = $obj->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');

        //get table count
        $requestCont = "http://212.243.175.10:8080/E3k.Web/api/Table/066/Count";
        $headers2 = array("Authorization: Basic amlyYTptZWlrbzE3","Content-Type: application/json");

        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $requestCont);
        curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $responses = curl_exec($ch3);
        curl_close($ch3);
        for($s=0;$s<=intval($responses);$s++){

            $pruductData = curl_init("http://212.243.175.10:8080/E3k.Web/api/Table/066/" . $s);
            curl_setopt($pruductData, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($pruductData, CURLOPT_POSTFIELDS, "[\"F071\",\"F002\",\"F075\",\"F098\",\"F033\",\"F004\",\"F005\",\"F006\",\"F010\",\"F001\",\"F064\",\"F027\",\"F007\",\"F008\",\"F009\",\"F076\"]");
            curl_setopt($pruductData, CURLOPT_USERPWD, "jira" . ":" . "meiko17");
            curl_setopt($pruductData, CURLOPT_TIMEOUT, 1);
            curl_setopt($pruductData, CURLOPT_RETURNTRANSFER, TRUE);
            $returnPruductData = curl_exec($pruductData);
            $bReturnPruductData = json_decode($returnPruductData);

            //chekc product
            if(isset($bReturnPruductData->F001))
            {
                $requestCheck = 'https://www.okiem.ch/rest/V1/products/'.$bReturnPruductData->F001;
                $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $requestCheck);
                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                $responseCheck = curl_exec($ch2);
                curl_close($ch2);
                $responseCheckJson = json_decode($responseCheck);
                if(isset($responseCheckJson->id)){

                    if (!isset($bReturnPruductData->F064)) {
                        $pF063 = null;
                    } else {
                        $pF063 = $bReturnPruductData->F064;
                        $pieces = explode(" ", $pF063);
                        $prices = array_filter($pieces);
                        $pricesArray = array_values($prices);
                        $sku = (string)$bReturnPruductData->F001;
                        $requestUrl2 = 'https://www.okiem.ch/rest/V1/products/' . trim($sku);
                        $sampleProductData = array();
                        $sampleTierPrices1 = array();
                        $sampleTierPrices2 = array();
                        $sampleTierPrices3 = array();
                        $sampleProductData2 = array();
                        $sampleTierPrices1 = array(
                            "customerGroupId" => 2,
                            "qty" => 1,
                            "value" => $pricesArray[0]
                        );
                        $sampleTierPrices2 = array(
                            "customerGroupId" => 3,
                            "qty" => 1,
                            "value" => $pricesArray[1]
                        );
                        $sampleTierPrices3 = array(
                            "customerGroupId" => 4,
                            "qty" => 1,
                            "value" => $pricesArray[2]
                        );
                        $sampleProductData2 = array(
                            $sampleTierPrices1,
                            $sampleTierPrices2,
                            $sampleTierPrices3,
                        );
                        $stockItem = array(
                            "stockId" => 1,
                            "qty" => $bReturnPruductData->F010,
                            "isInStock" => true,
                        );
                        $extensionAttributes = array(
                            "stockItem" => $stockItem
                        );
                        $aa = $bReturnPruductData->F071;
                        $bb = trim($aa);
                        $strRes = strrpos($bb,"\\");
                        $rest = substr($bb, $strRes+1);

                        $firs = substr($rest, 0, 1);
                        $sec = substr($rest, 1, 1);
                        //echo 'https://www.okiem.ch/pub/media/catalog/product/'.$firs.'/'.$sec.'/'.$rest.'';
                        //echo "<br>";
                        if($this->get_http_response_code('https://www.okiem.ch/pub/media/catalog/product/'.$firs.'/'.$sec.'/'.$rest.'') == "200") {
                            $b64image = base64_encode(file_get_contents('https://www.okiem.ch/pub/media/catalog/product/' . $firs . '/' . $sec . '/' . $rest . ''));

                            $img64 = array(
                                "base64_encoded_data" => $b64image,
                                "type" => "image/jpeg",
                                "name" => "test.jpg"
                            );
                            $baseImg = array(
                                "media_type" => "image",
                                "label" => "Product Image",
                                "position" => 1,
                                "disabled" => false,
                                "types" => ["image", "small_image", "thumbnail"],
                                "content" => $img64
                            );
                            $sampleProductData = array(
                                "sku" => "" . $bReturnPruductData->F001 . "",
                                "name" => "" . $bReturnPruductData->F004 . " " . $bReturnPruductData->F005 . " " . $bReturnPruductData->F006 . "",
                                "price" => $bReturnPruductData->F033,
                                "status" => $bReturnPruductData->F098,
                                "media_gallery_entries" => [$baseImg],
                                "extensionAttributes" => $extensionAttributes,
                                'tierPrices' => $sampleProductData2
                            );
                        }else{
                            $sampleProductData = array(
                                "sku" => "" . $bReturnPruductData->F001 . "",
                                "name" => "" . $bReturnPruductData->F004 . " " . $bReturnPruductData->F005 . " " . $bReturnPruductData->F006 . "",
                                "price" => $bReturnPruductData->F033,
                                "status" => $bReturnPruductData->F098,
                                "extensionAttributes" => $extensionAttributes,
                                'tierPrices' => $sampleProductData2
                            );
                        }


                        $createProductData2 = array(
                            "sku" => "" . $bReturnPruductData->F001 . "",
                            "name" => "" . $bReturnPruductData->F004 . "",
                            "price" => $bReturnPruductData->F033,
                            "status" => 1,
                            "type_id" => "simple",
                            "attribute_set_id" => 4,
                            "weight" => 1,
                            "visibility"=> 4
                        );


                        $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

                        $productCreateData2 = json_encode(array('product' => $sampleProductData));

                        $productCreateData = json_encode(array('product' => $createProductData2));

                        $ch2 = curl_init();
                        curl_setopt($ch2, CURLOPT_URL, $requestUrl2);
                        curl_setopt($ch2, CURLOPT_POSTFIELDS, $productCreateData);
                        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                        $responseCreate = curl_exec($ch2);
                        curl_close($ch2);
                        //print_r($responseCreate);
                        $ch2 = curl_init();
                        curl_setopt($ch2, CURLOPT_URL, $requestUrl2);
                        curl_setopt($ch2, CURLOPT_POSTFIELDS, $productCreateData2);
                        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                        $responseCreate = curl_exec($ch2);
                        curl_close($ch2);
                    }
                }

            }

        }


    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sample_Gridpart2::gridpart2_template');
    }
    public function  get_http_response_code($url) {
        $headers = get_headers($url);
        return substr($headers[0], 9, 3);
    }
    public function isAjaxLoaded()
    {
        return true;
    }
}