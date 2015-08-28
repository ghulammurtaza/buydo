<?php
class Mediastrategi_Shadowmedia_Model_Source_Effects
{
	public function toOptionArray()
	{
		return array(
			array('value' => 'fade-and-drop-from-top', 'label' => Mage::helper('adminhtml')->__('Fade and drop from top')),
			array('value' => 'default', 'label' => Mage::helper('adminhtml')->__('Default'))
		);
	}
}
