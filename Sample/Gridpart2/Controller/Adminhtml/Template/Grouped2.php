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

class Grouped2
{

    public function index($gsku,$result1,$m,$uid,$pname)
    {
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        if(isset($gsku)) {
            $tt = $this->select($gsku);
            if (isset($tt)) {

                $tt = $connection->fetchAll("SELECT * FROM emagicone_simple_table WHERE LTRIM(RTRIM(gsku))='$gsku'");
                if(isset($tt[0]['sku'])){
                    $simpleSku = "https://www.okiem.ch/rest/V1/products/".$tt[0]['sku'];//.trim($gsku);
                    $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

                    $ch2 = curl_init($simpleSku);
                    curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");
                    curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                    curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                    $responseCreate = curl_exec($ch2);
                    curl_close($ch2);
                    $a = json_decode($responseCreate);
                    if(isset($a->id))
                    {


                        $stockItem = array(
                            "stockId" => 1,
                            "qty" => 0,
                            "isInStock" => true,
                        );
                        $extensionAttributes = array(
                            "stockItem" => $stockItem
                        );
                        $qty = array(
                            "qty" => 0
                        );
                        $product_links2 = [];
                        $product_desc2 = [];
                        //count($tt)
                        for ($h = 0; $h < count($tt); $h++) {
                            $simpleSku = "https://www.okiem.ch/rest/V1/products/".$tt[$h]['sku'];//.trim($gsku);
                            $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

                            $ch2 = curl_init($simpleSku);
                            curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "GET");
                            curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                            curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                            curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                            $responseCreate = curl_exec($ch2);
                            curl_close($ch2);
                            $b = json_decode($responseCreate);
                            if(isset($b->custom_attributes)){
                                for($m=0;$m<count($b->custom_attributes);$m++){
                                    if(trim($b->custom_attributes[$m]->attribute_code)=='category_ids'){
                                        $key = $b->custom_attributes[$m]->value;
                                        //print_r($key);
                                    }
                                }
                            }else{
                                $key = array('233');
                            }

                            if(isset($b->id)){
                               $productSimple = array(
                                     "sku"=>"".$tt[$h]['sku']."",
                                     "type_id"=>"simple",
                                     "visibility"=>1

                                );
                                $productSimpleData = json_encode(array('product' => $productSimple));
                                $ch2 = curl_init($simpleSku);
                                curl_setopt($ch2, CURLOPT_POSTFIELDS, $productSimpleData);
                                curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
                                curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                                curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                                curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                                $responseCreate = curl_exec($ch2);
                                curl_close($ch2);

                                $product_links = array(
                                    "sku" => "" . $gsku . "",
                                    "link_type" => "associated",
                                    "linked_product_sku" => "" . $tt[$h]['sku'] . "",
                                    "linked_product_type" => "simple",
                                    "position" => 2,
                                    "extension_attributes" => $qty
                                );
                                array_push($product_links2, $product_links);
                                $product_desc = array(
                                    "attribute_code"=> "description",
                                    "value"=>"".$result1[$m]['F075'].""
                                );
                                array_push($product_desc2, $product_desc);
                                $category_ids = array(
                                    "attribute_code"=>"category_ids",
                                    "value"=> $key
                                );
                                array_push($product_desc2, $category_ids);
                            }

                        }


                        $sampleProductData =array();

                        $requestUrl5 = "http://212.243.175.10:8080/E3k.Web/api/Table/091/".$uid;
                        $pruductData5 = curl_init($requestUrl5);
                        curl_setopt($pruductData5, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
                        curl_setopt($pruductData5, CURLOPT_POSTFIELDS, "[\"F071\"]");
                        curl_setopt($pruductData5, CURLOPT_USERPWD, "jira" . ":" . "meiko17");
                        curl_setopt($pruductData5, CURLOPT_RETURNTRANSFER, TRUE);
                        $returnPruductData5 = curl_exec($pruductData5);
                        $bReturnPruductData5 = json_decode($returnPruductData5);

                        if(isset($bReturnPruductData5->F071)){
                            $aa = $bReturnPruductData5->F071;
                            $bb = trim($aa);

                            $strRes = strrpos($bb,"\\");
                            $rest = substr($bb, $strRes+1);

                            $firs = substr($rest, 0, 1);
                            $sec = substr($rest, 1, 1);
                            if($this->get_http_response_code('https://www.okiem.ch/pub/media/catalog/product/'.$firs.'/'.$sec.'/'.$rest.'') != "200"){
                                $sampleProductData = array(
                                    "sku" => "" . $gsku . "",
                                    "name" => "" . $pname . "",
                                    "price" => 1,
                                    "status" => 1,
                                    "extensionAttributes" => $extensionAttributes,
                                    "product_links" => $product_links2,
                                    "custom_attributes"=>$product_desc2
                                );
                            }else{
                                $b64image = base64_encode(file_get_contents('https://www.okiem.ch/pub/media/catalog/product/'.$firs.'/'.$sec.'/'.$rest.''));
                                $img64 = array(
                                    "base64_encoded_data"=>$b64image,
                                    "type"=>"image/jpeg",
                                    "name"=>"test.jpg"
                                );
                                $baseImg = array(
                                    "media_type"=>"image",
                                    "label"=>"Product Image",
                                    "position"=>1,
                                    "disabled"=>false,
                                    "types"=>["image","small_image","thumbnail"],
                                    "content"=>$img64
                                );
                                $sampleProductData = array(
                                    "sku" => "" . $gsku . "",
                                    "name" => "" . $pname . "",
                                    "price" => 1,
                                    "status" => 1,
                                    "media_gallery_entries"=>[$baseImg],
                                    "extensionAttributes" => $extensionAttributes,
                                    "product_links" => $product_links2,
                                    "custom_attributes"=>$product_desc2
                                );
                            }



                        }


                        $createProductData2 = array(
                            "sku" => "" . $gsku . "",
                            "name" => "" . $pname . "",
                            "price" => 30,
                            "status" => 1,
                            "type_id" => "grouped",
                            "attribute_set_id" => 20,
                            "weight" => 1,
                            "visibility"=> 4
                        );



                        $requestUrl2 = 'https://www.okiem.ch/rest/V1/products/' . $gsku;
                        $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

                        $productCreateData2 = json_encode(array('product' => $sampleProductData));
                        $productCreateData = json_encode(array('product' => $createProductData2));
                        $ch2 = curl_init($requestUrl2);
                        curl_setopt($ch2, CURLOPT_POSTFIELDS, $productCreateData);
                        curl_setopt($ch2, CURLOPT_CUSTOMREQUEST, "PUT");
                        curl_setopt($ch2, CURLOPT_HTTPHEADER, $headersCreate);
                        curl_setopt($ch2, CURLOPT_SSL_VERIFYPEER, false);
                        curl_setopt($ch2, CURLOPT_RETURNTRANSFER, true);
                        $responseCreate = curl_exec($ch2);
                        curl_close($ch2);

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
    public function select($sku){
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $tt = $connection->fetchAll("SELECT * FROM `emagicone_simple_table` WHERE `gsku`='$sku'");
        return $tt;
    }
    public function  get_http_response_code($url) {
            $headers = get_headers($url);
            return substr($headers[0], 9, 3);
    }

}