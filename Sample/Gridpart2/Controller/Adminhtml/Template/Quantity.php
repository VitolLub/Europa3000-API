<?php
/**
 * Copyright © 2015 Magento. All rights reserved.
 * See COPYING.txt for license details.
 */
namespace Sample\Gridpart2\Controller\Adminhtml\Template;
use Magento\Framework\App\Bootstrap;
use Magento\Backend\App\Action\Context;
use Magento\Framework\View\Result\PageFactory;

class Quantity extends \Magento\Backend\App\Action
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
        $time_start = microtime(true);
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        $state = $obj->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        $collection = $state->create()
            ->addAttributeToSelect('*')
            ->load();

        $StockState = $obj->get('\Magento\CatalogInventory\Api\StockStateInterface');
        $i = 1;
        foreach ($collection as $product){
            try{
                $process = curl_init("http://212.243.175.10:8080/E3k.Web/api/Article/Key/".$product->getSku());
                curl_setopt($process, CURLOPT_HTTPHEADER, array('Content-Type: application/xml'));
                curl_setopt($process, CURLOPT_USERPWD, "jira" . ":" ."meiko17");
                curl_setopt($process, CURLOPT_TIMEOUT, 1);
                curl_setopt($process, CURLOPT_RETURNTRANSFER, TRUE);
                $return = curl_exec($process);
                //print_r(json_decode($return));
                $a = json_decode($return);
                if(isset($a->Quantity)) {
                    $file = 'people.txt';
                    $file2 = 'people2.txt';
                    $file3 = 'people3.txt';
                    $file4 = 'people4.txt';

                    $current = file_get_contents($file);
                    $sku = file_get_contents($file2);
                    $id = file_get_contents($file3);
                    $qty = file_get_contents($file4);

                    $current .= $product->getName()."\n";
                    $sku .= $product->getSku()."\n";
                    $id .= $product->getId()."\n";
                    $qty .= $a->Quantity."\n";
                    file_put_contents($file, $current);
                    file_put_contents($file2, $sku);
                    file_put_contents($file3, $id);
                    file_put_contents($file4, $qty);
                }
                else{
                   // echo '<span style="color:red;">'.$product->getName().','.$product->getSku().','.$product->getId().',Some error with SKU </span><br>';
                }
                curl_close($process);

                $adminUrl = 'https://www.okiem.ch/rest/V1/integration/admin/token/';
                $ch = curl_init();
                $data = array("username" => "admin", "password" => "vitol486070920");

                $data_string = json_encode($data);
                $ch = curl_init($adminUrl);
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
                curl_setopt($ch, CURLOPT_POSTFIELDS, $data_string);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                        'Content-Type: application/json',
                        'Content-Length: ' . strlen($data_string))
                );
                $token = curl_exec($ch);
                $token=  json_decode($token);

                $headers = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5","Content-Type: application/json");

                $requestUrl='https://www.okiem.ch/rest/V1/products/'.$product->getSku().'/stockItems/1';
                if(isset($a->Quantity)) {
                    $sampleProductData = array(
                        "qty" => intval($a->Quantity),
                        "is_in_stock" => (intval($a->Quantity) > 0 ? 1 : 0)
                    );

                    $productData = json_encode(array('stockItem' => $sampleProductData));

                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $requestUrl);
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $productData);
                    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
                    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $response = curl_exec($ch);
                    curl_close($ch);
                    //var_dump($response);

                    unset($productData);
                    unset($sampleProductData);
                }


            } catch (Exception $e) {
                //echo $product->getName().','.$product->getSku().','.$product->getId().',<p style="color:red;">Some error with SKU </p>';
            }
            $i++;
            if ($i == 100) break;

        }

        $time_end = microtime(true);
        $time = $time_end - $time_start;
        //echo "Process Time: {$time}";

        return $resultRedirect->setPath('*/*/');

       //return $resultPage;
    }

    /**
     * @return bool
     */
    protected function _isAllowed()
    {
        return $this->_authorization->isAllowed('Sample_Gridpart2::gridpart2_template');
    }
}