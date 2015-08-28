<?php
class Gala_Galavineyardsettings_Model_Observer extends Varien_Object{
	
	public function beforeGenerateBlocks(Varien_Event_Observer $observer) {
	   $package = Mage::getSingleton('core/design_package')->getPackageName();
       $theme = Mage::getSingleton('core/design_package')->getTheme('frontend');
       if($package == 'default' && $theme == 'galavineyard'){
            # Disable default Magento footer links
    		if (Mage::helper('galavineyardsettings')->getGeneral_DisableFooterLinks()) {
    			$blocks = $observer->getLayout()->getXpath('//block[@name="footer_links"]');
    			if (!empty($blocks))
    				$blocks[0]->addAttribute('ignore', true);
    		}
       }
	}
	    
    public function processAfterHtmlDispatch($observer) {
		static $addJS;
		
		$cookie = Mage::getSingleton('core/cookie');
		$key = $key = $cookie->get('EDIT_BLOCK_KEY');
		if (!$key || !$cookie->get('adminhtml')) return;
		
		$block = $observer->getEvent()->getData('block');
		$name = $block->getNameInLayout();
		
		// is static block
		if (is_a($block, 'Mage_Cms_Block_Block') || is_a($block, 'Mage_Cms_Block_Widget_Block')) {
			$block_id = $block->getBlockId();
			$model = Mage::getModel('cms/block')
				->setStoreId(Mage::app()->getStore()->getId())
				->load($block_id);
			if (!($id = $model->getId())) $id = $block_id;
			
			$title = $model->getTitle();
			$transport = $observer->getEvent()->getTransport();
			
			$html = '';
			if (!$addJS) {
				$addJS = true;
				$html .= "<script type=\"text/javascript\" src=\"".$block->getSkinUrl('js/galavineyard_settings/galavineyard_settings.js')."\"></script>";
				$html .= "<script type=\"text/javascript\">jQuery(function($) { 
					$('head').append('<link rel=\"stylesheet\" type=\"text/css\" href=\"".$block->getSkinUrl('css/galavineyard_settings.css')."\"></link>');
					$('body').append('<div id=\"galavineyard_settings_previewblock_actions\"><a href=\"".Mage::getUrl('galavineyardsettings/visual/disablePreview')."\" class=\"turnoff\">".$block->__("Disable Block Preview")."</a></div>');
				});</script>"; 
			}
			
			$html .= trim($transport->getHtml());
			$transport->setHtml($html
				."<div class=\"galavineyard_settings_previewblock".(!$html ? ' empty' : '')."\" style=\"display:none\">"
				."<a target=\"_blank\" href=\"".Mage::helper('adminhtml')->getUrl("adminhtml/cms_block/edit", array('block_id' => $id, 'key' => $key))."\">$title</a>"
				."</div>");
		} 
		// is widget
		elseif (strlen($name) == 32 && preg_replace('/[^a-z0-9]/', '', $name) == $name) {
			$transport = $observer->getEvent()->getTransport();
			$html = trim($transport->getHtml());
			$transport->setHtml($html
				."<div class=\"galavineyard_settings_previewblock".(!$html ? ' empty' : '')."\" style=\"display:none\">"
				."Widget ".$block->getType()
				."<br/><span class=\"path\">".$block->getTemplateFile()."</span>"
				."</div>");

		}
	}
    
    /* Update custom layout */
    public function changeLayoutEvent($observer){
		if((Mage::getSingleton('core/design_package')->getPackageName() == 'default') && (Mage::getDesign()->getTheme('frontend') == 'galavineyard')){
			$update = $observer->getEvent()->getLayout()->getUpdate();
			$handles = $update->getHandles();
			$prefixTagXml = 'galavineyard/';
			
			/* Load reset xml */
			//echo Mage::getSingleton('core/design_package')->getBaseDir().'etc'.DS.'reset.php';exit;
			$xmlRestArray = require_once(Mage::getSingleton('core/design_package')->getBaseDir(array('_type' => 'etc')).DS.'reset.php');
			$xmlUpdateString = '';
			if(count($xmlRestArray)){
				foreach($xmlRestArray as $keyHandle => $value){
					if(in_array($keyHandle,$handles))
						$xmlUpdateString .= $value;
				}
			}
			$update->addUpdate($xmlUpdateString);
			$prefixDataXml = $prefixTagXml.'sidebar/block_data/';
			//echo '<pre>';print_r($update->getHandles());exit;
			$blocks = array('left' => array('blocks' => array(),'unset'=>array()),'right' => array('blocks' => array(),'unset'=>array()));
			
			$list = explode(',',Mage::getStoreConfig($prefixTagXml.'sidebar/list'));
			/* Build array blocks */
			foreach($list as $l){
				$position = Mage::getStoreConfig($prefixTagXml.'position/'.$l);
				if($position == 'none' || 
					(($handle = Mage::getStoreConfig($prefixDataXml.$l.'/handles')) && (count(array_intersect(explode(',',$handle),$handles)) == 0)))
					continue;
					
				$type = Mage::getStoreConfig($prefixDataXml.$l.'/type');
				$template = Mage::getStoreConfig($prefixDataXml.$l.'/template');
				$name = Mage::getStoreConfig($prefixDataXml.$l.'/name');
				$as = Mage::getStoreConfig($prefixDataXml.$l.'/as');
				if(($type == 'layerednavigation/catalog_layer') && (!Mage::getConfig()->getModuleConfig('EM_LayeredNavigation')->is('active', 'true'))){
					$type = 'catalog/layer_view';
					$template = 'catalog/layer/view.phtml';
					$name = 'catalog.leftnav.custom';
				}
				
				if(($type == 'layerednavigation/search_layer') && (!Mage::getConfig()->getModuleConfig('EM_LayeredNavigation')->is('active', 'true'))){
					$type = 'catalogsearch/layer';
					$template = 'catalog/layer/view.phtml';
					$name = 'catalogsearch.leftnav.custom';
				}
				
				$stringXml = '<block type="'.$type.'" name="'.$name.'"';
				if($as)
					$stringXml .= ' as="'.$as.'"';
				//echo Mage::getStoreConfig($prefixTagXml.$l.'/type');exit;
				if($template)
					$stringXml .= ' template="'.$template.'"';
				if($before = Mage::getStoreConfig($prefixDataXml.$l.'/before'))
					$stringXml .= ' before="'.$before.'"';	
				if($after = Mage::getStoreConfig($prefixDataXml.$l.'/after'))
					$stringXml .= ' after="'.$after.'"';
				if($action = Mage::getStoreConfig($prefixDataXml.$l.'/action')){
					/* Build action method */
					$stringXml .= '>';
					$actionArray = explode('|',$action);
					foreach($actionArray as $act){
						list($methodString,$paramString) = explode('?',$act);
						$methodData = explode(',',$methodString);
						$stringXml .= '<action';
						foreach($methodData as $method){
							list($label,$value) = explode(':',$method);
							$stringXml .= ' '.preg_replace('~[\r\n\t]+~', '', $label).'="'.preg_replace('~[\r\n\t]+~', '', str_replace('"',',',$value)).'"';
							//$stringXml .= '<'.$values[0].'>'.$values[1].'</'.$values[0].'>';
						}
						$stringXml .= '>';
						$paramsData = explode(',',$paramString);
						foreach($paramsData as $param){
							list($label,$value) = explode(':',$param);
							$stringXml .= '<'.preg_replace('~[\r\n\t]+~', '', $label).'>'.preg_replace('~[\r\n\t]+~', '', $value).'</'.preg_replace('~[\r\n\t]+~', '', $label).'>';
						}
						$stringXml .= '</action>';
					}
					$stringXml .= '</block>';
				} else{
					$stringXml .= '/>';	
				}	
				if($position == 'all'){
					$blocks['left']['blocks'][] = $stringXml;
					$blocks['right']['blocks'][] = $stringXml;
				} else {
					$blocks[$position]['blocks'][] = $stringXml;
				}
				
			}
			/* Build xml update */
			$xml = '';
			// Reference name="left"
			foreach($blocks as $position => $listXml){
				if((count($listXml['blocks']) > 0) || (count($listXml['unset']) > 0)){
					$xml .= '<reference name="'.$position.'">';
					
					/* unset block */
					/*if(count($listXml['unset']) > 0){
						foreach($listXml['unset'] as $name){
							$xml .= '<action method="unsetChild"><name>'.$name.'</name></action>';
						}
					}*/
					
					/* Add block */
					if(count($listXml['blocks']) > 0){
						foreach($listXml['blocks'] as $block){
							$xml .= $block;
						}
					}
					$xml .= '</reference>';
				}
				
			}
			//echo $xml;exit;
			$update->addUpdate($xml);
		}
        return $this;
    }
}
