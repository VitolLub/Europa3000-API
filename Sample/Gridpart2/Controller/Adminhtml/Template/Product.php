<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;
use Magento\Framework\App\Bootstrap;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Product extends \Magento\Backend\App\Action
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

        $resultRedirect = $this->resultRedirectFactory->create();
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        $state = $obj->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $state->create()
            ->addAttributeToSelect('*')
            ->load();

        $tableCollection = curl_init("http://212.243.175.10:8080/E3k.Web/api/Table/066/Count");
        curl_setopt($tableCollection, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
        curl_setopt($tableCollection, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
        curl_setopt($tableCollection, CURLOPT_TIMEOUT, 1);
        curl_setopt($tableCollection, CURLOPT_RETURNTRANSFER, TRUE);
        $return = curl_exec($tableCollection);
        $a = json_decode($return);
//echo $a;
        $skuArr = array();
        for($i=intval($a);$i>0;$i--){
            $processArticleNumber = curl_init("http://212.243.175.10:8080/E3k.Web/api/Article/".$i);
            curl_setopt($processArticleNumber, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($processArticleNumber, CURLOPT_POSTFIELDS, "[\"ArticleNumber\"]");
            curl_setopt($processArticleNumber, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
            curl_setopt($processArticleNumber, CURLOPT_TIMEOUT, 1);
            curl_setopt($processArticleNumber, CURLOPT_RETURNTRANSFER, TRUE);
            $returnProcessArticleNumber = curl_exec($processArticleNumber);
            $bReturnProcessArticleNumber = json_decode($returnProcessArticleNumber);
            if (!isset($bReturnProcessArticleNumber->ArticleNumber)){
                $ArticleNumber = null;
            }
            else{
                $ArticleNumber = $bReturnProcessArticleNumber->ArticleNumber;
            }
            array_push($skuArr,$ArticleNumber);

            if($i==26500){
                break;
            }
        }
//echo "Europa 3000";
//echo "<br>";
//print_r($skuArr);

//echo "<br>";
        $siteArr = array();
        foreach ($collection as $product){
            array_push($siteArr,$product->getSku());
        }
//echo "PC";
//echo "<br>";
//print_r($siteArr);

        $resultSkuArr = array_diff($skuArr,$siteArr);
//echo "<br>";
//print_r($resultSkuArr);
        foreach ($resultSkuArr  as $sku){
            $processSku = curl_init("http://212.243.175.10:8080/E3k.Web/api/Article/Key/".$sku);
            curl_setopt($processSku, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($processSku, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
            curl_setopt($processSku, CURLOPT_TIMEOUT, 1);
            curl_setopt($processSku, CURLOPT_RETURNTRANSFER, TRUE);
            $returnSku = curl_exec($processSku);
            $bSku = json_decode($returnSku);
            if (!isset($bSku->Id)){
                $prodId = null;
            }else{
                $prodId = $bSku->Id;
            }
            //request to table by ID
            //POST request
            $pruductData = curl_init("http://212.243.175.10:8080/E3k.Web/api/Table/066/".$prodId);
            curl_setopt($pruductData, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($pruductData, CURLOPT_POSTFIELDS, "[\"F075\",\"F098\",\"F033\",\"F004\",\"F005\",\"F006\",\"F010\",\"F001\",\"F064\",\"F027\",\"F007\",\"F008\",\"F009\",\"F076\",\"F063\"]");
            curl_setopt($pruductData, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
            curl_setopt($pruductData, CURLOPT_TIMEOUT, 1);
            curl_setopt($pruductData, CURLOPT_RETURNTRANSFER, TRUE);
            $returnPruductData = curl_exec($pruductData);
            $bReturnPruductData = json_decode($returnPruductData);
            if (!isset($bReturnPruductData->F063)){
                $pF063 = null;
            }else{
                $pF063 = $bReturnPruductData->F063;
                $pieces = explode(" ", $pF063);
                $prices = array_filter($pieces);
                $pricesArray = array_values($prices);
                //echo 'pricesArray';
                //print_r($pricesArray);


                //create product
                $requestUrl3='https://www.okiem.ch/rest/V1/products/'.$bReturnPruductData->F001;
                $createProductData2 = array(
                    "sku"=> "".$bReturnPruductData->F001."",
                    "name"=> "".$bReturnPruductData->F001."",
                    "price"=>30,
                    "status"=> 1,
                    "type_id"=> "simple",
                    "attribute_set_id"=> 4,
                    "weight"=> 1
                );


                $headersCreate = array("Authorization: Bearer vsl9f3alwbtjq9ytbop6evg6ex58oh8q","Content-Type: application/json");

                $productCreateData = json_encode(array('product' => $createProductData2));

                $ch2 = curl_init();
                curl_setopt($ch2, CURLOPT_URL, $requestUrl3);
                curl_setopt($ch2, CURLOPT_POSTFIELDS, $productCreateData);
                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                $responseCreate = curl_exec($ch2);
                curl_close($ch2);
                //print_r($responseCreate);
                //end create product


                //inport product
                $requestUrl2='https://www.okiem.ch/rest/V1/products/'.$bReturnPruductData->F001;
                $sampleProductData = array();
                $sampleTierPrices1 = array();
                $sampleTierPrices2 = array();
                $sampleTierPrices3 = array();
                $sampleProductData2 = array();
                $sampleTierPrices1 = array(
                    "customerGroupId"=> 2,
                    "qty"=> 1,
                    "value"=>$pricesArray[0]
                );
                $sampleTierPrices2 = array(
                    "customerGroupId"=> 3,
                    "qty"=> 1,
                    "value"=>$pricesArray[1]
                );
                $sampleTierPrices3 = array(
                    "customerGroupId"=> 4,
                    "qty"=> 1,
                    "value"=>$pricesArray[2]
                );
                $sampleProductData2 = array(
                    $sampleTierPrices1,
                    $sampleTierPrices2,
                    $sampleTierPrices3,
                );
                $sampleProductData = array(
                    "sku" => "".$bReturnPruductData->F001."",
                    "name" => "".$bReturnPruductData->F004." ".$bReturnPruductData->F005." ".$bReturnPruductData->F006."",
                    "price" => $bReturnPruductData->F033,
                    "status"=> $bReturnPruductData->F098,
                    'tierPrices' => $sampleProductData2
                );
                //print_r($sampleProductData);

                $headers2 = array("Authorization: Bearer vsl9f3alwbtjq9ytbop6evg6ex58oh8q","Content-Type: application/json");

                $productData = json_encode(array('product' => $sampleProductData));

                $ch3 = curl_init();
                curl_setopt($ch3, CURLOPT_URL, $requestUrl2);
                curl_setopt($ch3, CURLOPT_POSTFIELDS, $productData);
                curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "PUT");
                curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
                curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                $responses = curl_exec($ch3);
                curl_close($ch3);
                $rrr = json_decode($responses);

                //img upload
                $requestUrl2 = "http://212.243.175.10:8080/E3k.Web/api/Article/PictureBase64/".$rrr->id."/F071";
                $headers2 = array("Authorization: Basic amlyYTptZWlrbzE3","Content-Type: application/json");

                $ch3 = curl_init();
                curl_setopt($ch3, CURLOPT_URL, $requestUrl2);
                curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "GET");
                curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
                curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                $responses = curl_exec($ch3);
                curl_close($ch3);
                $rrr = json_decode($responses);
                $wor = "base64";
                $pos = strpos($rrr, $wor);
                $resYtube64 = substr($rrr,$pos+7,-1);


                $requestUrl2='https://www.okiem.ch/rest/V1/products/'.$rrr->sku.'/media';
                $headers2 = array("Authorization: Bearer vsl9f3alwbtjq9ytbop6evg6ex58oh8q","Content-Type: application/json");
                $base64img = array(
                    "base64EncodedData"=>$resYtube64,
                    "type"=>"image/jpeg",
                    "name"=>"new image"
                );
                $sampleProductData = array(
                    "media_type"=>"image",
                    "label"=>"Image",
                    "position"=>1,
                    "disabled"=>false,
                    "types"=>[
                        "image",
                        "small_image",
                        "thumbnail"
                    ],
                    "file"=>"/m/b/mb01-blue-0.jpg",
                        "content"=>$base64img

                );
                $productData = json_encode(array('entry' => $sampleProductData));
                $ch3 = curl_init();
                curl_setopt($ch3, CURLOPT_URL, $requestUrl2);
                curl_setopt($ch3, CURLOPT_POSTFIELDS, $productData);
                curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
                curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
                curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                $responses = curl_exec($ch3);
                curl_close($ch3);


                if(strlen(trim($bReturnPruductData->F073))>10){
                    $a = $bReturnPruductData->F073;
                    $b = trim($a);
                    $findme   = 'embed/';
                    $pos = strpos($b, $findme);
                    $newStr = substr($b, $pos+6);
                    $rel = "?rel";
                    $posRel = strpos($newStr, $rel);
                    $resYtube = substr($newStr,0,$posRel);
                    $b64image = base64_encode(file_get_contents('https://img.youtube.com/vi/'.$resYtube.'/0.jpg'));
                    echo $b64image;

                    $requestUrl2='https://www.okiem.ch/rest/V1/products/'.$rrr->sku.'/media';
                    $headers2 = array("Authorization: Bearer vsl9f3alwbtjq9ytbop6evg6ex58oh8q","Content-Type: application/json");
                    $types = array(
                        "image",
                        "small_image",
                        "thumbnail",
                        "swatch_image"
                    );
                    $base64 = array(
                        "base64EncodedData"=>$b64image,
                        "type"=>"image/jpeg",
                        "name"=>"0.jpg"
                    );
                    $video_content = array(
                        "media_type"=>"external-video",
                        "video_provider"=>"",
                        "video_url"=>"https://www.youtube.com/watch?v=".$resYtube."",
                        "video_title"=>"B202-SKU",
                        "video_description"=>"B202-SKU",
                        "video_metadata"=>"B202-SKU"
                    );
                    $extension_attributes = array(
                        "video_content"=>$video_content
                    );
                    $sampleProductData = array(
                        "id" => $rrr->id,
                        "media_type" => "external-video",
                        "label" => null,
                        "position"=> 0,
                        "disabled" => false,
                        "types"=> $types,
                        "content"=>$base64,
                        "extension_attributes"=>$extension_attributes
                    );
                    $productData = json_encode(array('entry' => $sampleProductData));
                    $ch3 = curl_init();
                    curl_setopt($ch3, CURLOPT_URL, $requestUrl2);
                    curl_setopt($ch3, CURLOPT_POSTFIELDS, $productData);
                    curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
                    curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
                    $responses = curl_exec($ch3);
                    curl_close($ch3);

                    $aa = $obj->get('Magento\Framework\App\ResourceConnection');
                    $connection= $aa->getConnection();

                    $themeTable = $connection->getTableName('catalog_product_entity_media_gallery_value_video');
                    $sql = "UPDATE `".$themeTable."` SET  `store_id`=0,`provider`='',`url`='https://www.youtube.com/watch?v=".$resYtube."',`title`='Some music',`description`='Some music',`metadata`='Some music' WHERE  `value_id`=".$responses;
                    $connection->query($sql);
                    $themeTable2 = $connection->getTableName('catalog_product_entity_media_gallery_value');
                    $sql2 = "UPDATE `".$themeTable2."` SET  `store_id`=0 WHERE  `value_id`=".$responses;
                    $connection->query($sql2);
                }


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
}