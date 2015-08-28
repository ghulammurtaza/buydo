<?php

class MW_Newordernotify_Model_Newordernotify extends Mage_Sales_Model_Order
{
	const XML_PATH_EMAILADMIN_NEWORDER_TEMPLATE      = 'mw_mageworld_newordernotify/mgoptions/mgemail_template';
	const XML_PATH_EMAILADMIN_NEWORDER    			 = 'mw_mageworld_newordernotify/mgoptions/mgrecipient_email';
	const XML_PATH_EMAILADMIN_NEWORDER_IDENTITY      = 'mw_mageworld_newordernotify/mgoptions/mgsender_email_identity';
    public function _construct()
    {
        parent::_construct();        
    }
	public function sendNewOrderEmail()
    {
        if (!Mage::helper('sales')->canSendNewOrderEmail($this->getStore()->getId())) {
            return $this;
        }

        $translate = Mage::getSingleton('core/translate');
        /* @var $translate Mage_Core_Model_Translate */
        $translate->setTranslateInline(false);

        $paymentBlock = Mage::helper('payment')->getInfoBlock($this->getPayment())
            ->setIsSecureMode(true);

        $paymentBlock->getMethod()->setStore($this->getStore()->getId());

        $mailTemplate = Mage::getModel('core/email_template');
        /* @var $mailTemplate Mage_Core_Model_Email_Template */
        $copyTo = $this->_getEmails(self::XML_PATH_EMAIL_COPY_TO);
        $copyMethod = Mage::getStoreConfig(self::XML_PATH_EMAIL_COPY_METHOD, $this->getStoreId());
        if ($copyTo && $copyMethod == 'bcc') {
            foreach ($copyTo as $email) {
                $mailTemplate->addBcc($email);
            }
        }

        if ($this->getCustomerIsGuest()) {
            $template = Mage::getStoreConfig(self::XML_PATH_EMAIL_GUEST_TEMPLATE, $this->getStoreId());
            $customerName = $this->getBillingAddress()->getName();
        } else {
            $template = Mage::getStoreConfig(self::XML_PATH_EMAIL_TEMPLATE, $this->getStoreId());
            $customerName = $this->getCustomerName();
        }

        $sendTo = array(
            array(
                'email' => $this->getCustomerEmail(),
                'name'  => $customerName
            )
        );
        if ($copyTo && $copyMethod == 'copy') {
            foreach ($copyTo as $email) {
                $sendTo[] = array(
                    'email' => $email,
                    'name'  => null
                );
            }
        }

        foreach ($sendTo as $recipient) {
            $mailTemplate->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    $template,
                    Mage::getStoreConfig(self::XML_PATH_EMAIL_IDENTITY, $this->getStoreId()),
                    $recipient['email'],
                    $recipient['name'],
                    array(
                        'order'         => $this,
                        'billing'       => $this->getBillingAddress(),
                        'payment_html'  => $paymentBlock->toHtml(),
                    )
                );            
        }
        Mage::getModel('core/email_template')
        		->setDesignConfig(array('area'=>'frontend', 'store'=>$this->getStoreId()))
                ->sendTransactional(
                    Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER_TEMPLATE),
                    Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER_IDENTITY),
                    Mage::getStoreConfig(self::XML_PATH_EMAILADMIN_NEWORDER),
                    null,
                    array(
                        'order'         => $this,
                        'billing'       => $this->getBillingAddress(),
                        'payment_html'  => $paymentBlock->toHtml(),
                    )
                );

        $translate->setTranslateInline(true);

        return $this;
    }
}