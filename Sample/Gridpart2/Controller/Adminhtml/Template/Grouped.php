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

class Grouped extends \Magento\Backend\App\Action
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
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        $state = $obj->get('Magento\Catalog\Model\ResourceModel\Product\CollectionFactory');
        //use Magento\Framework\App\Bootstrap;
        //use Magento\Framework\Setup\InstallDataInterface;
        //use Magento\Framework\Setup\ModuleContextInterface;
        //use Magento\Framework\Setup\ModuleDataSetupInterface;
        //require __DIR__ . '/app/bootstrap.php';
        //$params = $_SERVER;
        //$bootstrap = Bootstrap::create(BP, $params);
        $resultRedirect = $this->resultRedirectFactory->create();
        $obj = \Magento\Framework\App\ObjectManager::getInstance();

        $state = $obj->get('Magento\Framework\Setup\ModuleDataSetupInterface');
        //$obj = $bootstrap->getObjectManager();
        //$state = $obj->get('Magento\Framework\Setup\ModuleDataSetupInterface');
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');


        $writeAdapter   = $state->getConnection('core_write');
        $readAdapter   = $state->getConnection('core_read');

        $requestUrl2 = "http://212.243.175.10:8080/E3k.Web/api/Table/066/Count";
        $headers2 = array("Authorization: Basic amlyYTptZWlrbzE3","Content-Type: application/json");

        $ch3 = curl_init();
        curl_setopt($ch3, CURLOPT_URL, $requestUrl2);
        curl_setopt($ch3, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch3, CURLOPT_HTTPHEADER, $headers2);
        curl_setopt($ch3, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch3, CURLOPT_RETURNTRANSFER, true);
        $responses = curl_exec($ch3);
        curl_close($ch3);
        $skuArr = array();
        $requestUrl4 = "http://212.243.175.10:8080/E3k.Web/api/Table/066/Count";
        $headers4 = array("Authorization: Basic amlyYTptZWlrbzE3","Content-Type: application/json");
        $headersCreate = array("Authorization: Bearer xavwoy382dqrm2am7kxp587ddnx9p6p5", "Content-Type: application/json");

        $ch4 = curl_init();
        curl_setopt($ch4, CURLOPT_URL, $requestUrl4);
        curl_setopt($ch4, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch4, CURLOPT_HTTPHEADER, $headers4);
        curl_setopt($ch4, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch4, CURLOPT_RETURNTRANSFER, true);
        $responses4 = curl_exec($ch4);
        curl_close($ch4);
        //intval($responses4)
        /*for($v=0;$v<intval($responses4);$v++){
            $requestUrl3 = "http://212.243.175.10:8080/E3k.Web/api/Table/066/".$v;
            $pruductData3 = curl_init($requestUrl3);
            curl_setopt($pruductData3, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($pruductData3, CURLOPT_POSTFIELDS, "[\"F001\",\"F121\"]");
            curl_setopt($pruductData3, CURLOPT_USERPWD, "jira" . ":" . "meiko17");
            curl_setopt($pruductData3, CURLOPT_RETURNTRANSFER, TRUE);
            $returnPruductData3 = curl_exec($pruductData3);
            $bReturnPruductData3 = json_decode($returnPruductData3);
            if(isset($bReturnPruductData3->F121)){
                $gsku = trim($bReturnPruductData3->F121);
                $sku = trim($bReturnPruductData3->F001);
                //$requestUrl2 = 'https://www.okiem.ch/rest/V1/products/'.$sku;
                if(strlen($gsku)>0){
                    $writeAdapter->query("INSERT INTO emagicone_simple_table (`uid`,`sku`,`gsku`) VALUES($v,'$sku','$gsku')");
                }


            }
        }*/
        //count($responses)
        /*for($i=2905;$i<3629;$i++){
            $requestUrl = "http://212.243.175.10:8080/E3k.Web/api/Table/091/".$i;
            $pruductData = curl_init($requestUrl);
            curl_setopt($pruductData, CURLOPT_HTTPHEADER, array('Content-Type: application/json', 'Accept: application/json'));
            curl_setopt($pruductData, CURLOPT_POSTFIELDS, "[\"F001\",\"F004\",\"F007\",\"F071\",\"F075\",\"F076\",\"F080\"]");
            curl_setopt($pruductData, CURLOPT_USERPWD, "jira" . ":" . "meiko17");
            curl_setopt($pruductData, CURLOPT_TIMEOUT, 4);
            curl_setopt($pruductData, CURLOPT_RETURNTRANSFER, TRUE);
            $returnPruductData = curl_exec($pruductData);
            $bReturnPruductData = json_decode($returnPruductData);

            if(isset($bReturnPruductData->F001)) {

                $F001 =  $bReturnPruductData->F001;
                echo $F001;
                echo "<br>";

                $F004 = $bReturnPruductData->F004;
                $F007 = $bReturnPruductData->F007;
                $F071 = $bReturnPruductData->F071;
                $F075 = $bReturnPruductData->F075;
                $F076 = $bReturnPruductData->F076;
                $F080 = $bReturnPruductData->F080;
                $uid = $i;
                $F001 = trim($F001);
                $F004 = $this->clean($F004);
                $F007 = $this->clean($F007);
                $F071 = $this->clean($F071);
                $F075 = $this->clean($F075);
                $F0762 = $this->clean($F076);
                $F080 = $this->clean($F080);
               $writeAdapter->query("INSERT INTO emagicone_group_table (`uid`,`F001`,`F004`,`F007`,`F071`,`F075`,`F076`,`F080`) VALUES($uid,'$F001','$F004','$F007','$F071','$F075','$F0762','$F080')");
            }

        }*/


        $result1 = $connection->fetchAll("SELECT * FROM emagicone_group_table");

        $obn =  new Grouped2();
        //count($result1)
        for($m=0;$m<count($result1);$m++){
            $gsku = trim($result1[$m]['F001']);
            $uid = trim($result1[$m]['uid']);
            $pname = trim($result1[$m]['F004']);
            $obn->index($gsku,$result1,$m,$uid,$pname);

        }
        //return $resultRedirect->setPath('*/*/');


    }
    public function additem() {

        $idd = $this->getRequest()->getPost('tabindex');

        echo $idd;
    }
    public function clean($string) {
        $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
        $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
        $string = str_replace('-', ' ', $string);
        return $string; // Replaces multiple hyphens with single one.
    }
    public function select($sku){
        $objectManager =   \Magento\Framework\App\ObjectManager::getInstance();
        $connection = $objectManager->get('Magento\Framework\App\ResourceConnection')->getConnection('\Magento\Framework\App\ResourceConnection::DEFAULT_CONNECTION');
        $tt = $connection->fetchAll("SELECT * FROM `emagicone_simple_table` WHERE `gsku`='$sku'");
        return $tt;
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