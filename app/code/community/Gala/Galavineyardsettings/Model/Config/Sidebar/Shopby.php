<?php
class Gala_Galavineyardsettings_Model_Config_Sidebar_Shopby
{
	/**
     * Options getter
     *
     * @return array
     */
    public function toOptionArray()
    {
        return array(
            array('value' => 'left', 'label'=>Mage::helper('adminhtml')->__('Left')),
            array('value' => 'right', 'label'=>Mage::helper('adminhtml')->__('Right')),
            array('value' => 'none', 'label'=>Mage::helper('adminhtml')->__('None')),
        );
    }
}
?>