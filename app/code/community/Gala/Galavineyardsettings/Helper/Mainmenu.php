<?php
class Gala_Galavineyardsettings_Helper_mainmenu extends Mage_Core_Helper_Abstract
{
	public function gettype() {
		$type	=	0;
		if(	Mage::getConfig()->getModuleConfig('EM_Megamenupro')->is('active', 'true') != false)	// Check include extension
		{
			if(Mage::getStoreConfig('advanced/modules_disable_output/EM_Megamenupro')	!= 1){	// check enable/disable extension - in Backend : System > Config > Advanced
				$id	=	Mage::helper("galavineyardsettings")->getGeneral_MainMenu();
				if($id != 0){
					$data = Mage::getModel('megamenupro/megamenupro')->load($id);
					if($data->getStatus() == 1){	// check enable/disable this menu 
						$type = $id;
					}
				}
			}
		}
		return	$type;
	}

	public function getmenu() {
		$id	=	Mage::helper("galavineyardsettings")->getGeneral_MainMenu();	
		$widget	=	"{{widget type=\"megamenupro/megamenupro\" menu=\"".$id."\"}}";
		$helper = Mage::helper('cms');
		$processor = $helper->getBlockTemplateProcessor();
		$html = $processor->filter($widget);		
		return	$html;
	}
}