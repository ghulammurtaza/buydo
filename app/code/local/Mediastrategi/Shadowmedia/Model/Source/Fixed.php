<?php
class Mediastrategi_Shadowmedia_Model_Source_Fixed
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'yes', 'label' => Mage::helper('adminhtml')->__('Yes')),
            array('value' => 'no', 'label' => Mage::helper('adminhtml')->__('No'))
        );
    }
}
