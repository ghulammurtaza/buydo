<?php
class Mediastrategi_Shadowmedia_Model_Source_Units
{
    public function toOptionArray()
    {
        return array(
            array('value' => 'seconds', 'label' => Mage::helper('adminhtml')->__('Seconds')),
            array('value' => 'minutes', 'label' => Mage::helper('adminhtml')->__('Minutes')),
            array('value' => 'hours', 'label' => Mage::helper('adminhtml')->__('Hours')),
            array('value' => 'days', 'label' => Mage::helper('adminhtml')->__('Days')),
            array('value' => 'weeks', 'label' => Mage::helper('adminhtml')->__('Weeks')),
            array('value' => 'months', 'label' => Mage::helper('adminhtml')->__('Months')),
            array('value' => 'years', 'label' => Mage::helper('adminhtml')->__('Years'))
        );
    }
}
