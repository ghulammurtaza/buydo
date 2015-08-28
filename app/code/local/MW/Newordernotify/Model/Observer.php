<?php
class MW_Newordernotify_Model_Observer
{
	const XML_PATH_EMAILADMIN_NEWORDER_TEMPLATE      = 'mw_mageworld_newordernotify/mgoptions/mgemail_template';
	const XML_PATH_EMAILADMIN_NEWORDER    			 = 'mw_mageworld_newordernotify/mgoptions/mgrecipient_email';
	const XML_PATH_EMAILADMIN_NEWORDER_IDENTITY      = 'mw_mageworld_newordernotify/mgoptions/mgsender_email_identity';
	
	public function checkout_type_onepage_save_order_after($observer)
    {
    	$order = $observer->getOrder();
	
        $translate = Mage::getSingleton('core/translate');
        $translate->setTranslateInline(false);
        
        $paymentBlock = "";
       if($order->getPayment()){
       		$paymentBlock = Mage::helper('payment')->getInfoBlock($order->getPayment())
            	->setIsSecureMode(true);

        	$paymentBlock->getMethod()->setStore(Mage::app()->getStore()->getId());
        	$paymentBlock = $paymentBlock->toHtml();
        }
        
 		$receiption = Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER);
 		$receiption = explode(',',$receiption);
 		foreach($receiption as $re){
	        Mage::getModel('core/email_template')
	        		->setDesignConfig(array('area'=>'frontend', 'store'=>Mage::app()->getStore()->getId()))
	                ->sendTransactional(
	                    Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER_TEMPLATE),
	                    Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER_IDENTITY),
	                    $re,
	                    null,
	                    array(
	                        'order'         => $order,
	                        //'billing'       => $billing,
	                        'payment_html'  => $paymentBlock,
	                    )
	                );
 		}

        $translate->setTranslateInline(true);
        //return $order;
    }
}