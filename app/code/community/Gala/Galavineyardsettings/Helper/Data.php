<?php
/**
 * @methods:
 * - get[Section]_[ConfigName]($defaultValue = '')
 */
class Gala_Galavineyardsettings_Helper_Data extends Mage_Core_Helper_Abstract
{
	public function __call($name, $args) {
		if (method_exists($this, $name))
			call_user_func_array(array($this, $name), $args);
			
		elseif (preg_match('/^get([^_][a-zA-Z0-9_]+)$/', $name, $m)) {
			$segs = explode('_', $m[1]);
			foreach ($segs as $i => $seg)
				$segs[$i] = strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1_$2', $seg));

			$value = Mage::getStoreConfig('galavineyard/'.implode('/', $segs));
			if (!$value) $value = @$args[0];
			return $value;
		}
		
		else 
			call_user_func_array(array($this, $name), $args);
	}       
    	
	/**
	 * @return array
	 */
	public function getAllCssConfig() {            
        $h_bg_image = Mage::getStoreConfig('galavineyard/header/head_bg_file') ? 
			'url(' . Mage::getBaseUrl('media') . 'background/' . Mage::getStoreConfig('galavineyard/header/head_bg_file') . ')'
			: (Mage::getStoreConfig('galavineyard/header/head_bg_image') ? 'url(../images/stripes/'.Mage::getStoreConfig('galavineyard/header/head_bg_image').')' : '');
		
        $bd_bg_image = Mage::getStoreConfig('galavineyard/body/bd_bg_file') ? 
			'url(' . Mage::getBaseUrl('media') . 'background/' . Mage::getStoreConfig('galavineyard/body/bd_bg_file') . ')'
			: (Mage::getStoreConfig('galavineyard/body/bd_bg_image') ? 'url(../images/stripes/'.Mage::getStoreConfig('galavineyard/body/bd_bg_image').')' : '');
            
        $f_bg_image = Mage::getStoreConfig('galavineyard/footer/foot_bg_file') ? 
			'url(' . Mage::getBaseUrl('media') . 'background/' . Mage::getStoreConfig('galavineyard/footer/foot_bg_file') . ')'
			: (Mage::getStoreConfig('galavineyard/footer/foot_bg_image') ? 'url(../images/stripes/'.Mage::getStoreConfig('galavineyard/footer/foot_bg_image').')' : '');
        
        $page_bg_image = Mage::getStoreConfig('galavineyard/general/page_bg_file') ? 
			'url(' . Mage::getBaseUrl('media') . 'background/' . Mage::getStoreConfig('galavineyard/general/page_bg_file') . ')'
			: (Mage::getStoreConfig('galavineyard/general/page_bg_image') ? 'url(../images/stripes/'.Mage::getStoreConfig('galavineyard/general/page_bg_image').')' : '');
            
		// menu font and dropdown menu font
			if(Mage::getStoreConfig('galavineyard/menu/tm_font') == "")	$tm_font	=	Mage::getStoreConfig('galavineyard/typography/h5_font');
			else	$tm_font	=	Mage::getStoreConfig('galavineyard/menu/tm_font');
			
			if(Mage::getStoreConfig('galavineyard/menu/dm_font') == "")	$dm_font	=	Mage::getStoreConfig('galavineyard/typography/general_font');
			else	$dm_font	=	Mage::getStoreConfig('galavineyard/menu/dm_font');

		return array(
            'general_font' => Mage::getStoreConfig('galavineyard/typography/general_font'),
            'google_fonts_weights' => Mage::getStoreConfig('galavineyard/typography/google_fonts_weights'),
			'h1_font' => Mage::getStoreConfig('galavineyard/typography/h1_font'),
			'h2_font' => Mage::getStoreConfig('galavineyard/typography/h2_font'),
			'h3_font' => Mage::getStoreConfig('galavineyard/typography/h3_font'),
			'h4_font' => Mage::getStoreConfig('galavineyard/typography/h4_font'),
			'h5_font' => Mage::getStoreConfig('galavineyard/typography/h5_font'),
            'h6_font' => Mage::getStoreConfig('galavineyard/typography/h6_font'),
            'additional_css_file' => Mage::getStoreConfig('galavineyard/typography/additional_css_file'),
            'custom_css' => Mage::getStoreConfig('galavineyard/typography/custom_css'),
            'page_bg_color' => Mage::getStoreConfig('galavineyard/general/page_bg_color'),
            'page_bg_image' => $page_bg_image,
            'page_bg_position' => Mage::getStoreConfig('galavineyard/general/page_bg_position'),
			'page_bg_repeat' => Mage::getStoreConfig('galavineyard/general/page_bg_repeat'),            
            'head_text_color' => Mage::getStoreConfig('galavineyard/header/head_text_color'),
			'head_text2_color' => Mage::getStoreConfig('galavineyard/header/head_text2_color'),
			'head_text3_color' => Mage::getStoreConfig('galavineyard/header/head_text3_color'),
			'head_bg_color' => Mage::getStoreConfig('galavineyard/header/head_bg_color'),
            'head_bg2_color' => Mage::getStoreConfig('galavineyard/header/head_bg2_color'),
            'head_bg3_color' => Mage::getStoreConfig('galavineyard/header/head_bg3_color'),
            'head_bg4_color' => Mage::getStoreConfig('galavineyard/header/head_bg4_color'),
            'head_bg_image' => $h_bg_image,
            'head_bg_position' => Mage::getStoreConfig('galavineyard/header/head_bg_position'),
			'head_bg_repeat' => Mage::getStoreConfig('galavineyard/header/head_bg_repeat'),
            'tm_bg_color' => Mage::getStoreConfig('galavineyard/menu/tm_bg_color'),
            'tm_hover_bg_color' => Mage::getStoreConfig('galavineyard/menu/tm_hover_bg_color'),
			'tm_text_color' => Mage::getStoreConfig('galavineyard/menu/tm_text_color'),
			'tm_hover_text_color' => Mage::getStoreConfig('galavineyard/menu/tm_hover_text_color'),
            'tm_line_color' => Mage::getStoreConfig('galavineyard/menu/tm_line_color'),
			'tm_font' => $tm_font,
			'dm_bg_color' => Mage::getStoreConfig('galavineyard/menu/dm_bg_color'),
            'dm_text_color' => Mage::getStoreConfig('galavineyard/menu/dm_text_color'),
            'dm_hover_text_color' => Mage::getStoreConfig('galavineyard/menu/dm_hover_text_color'),
            'dm_text2_color' => Mage::getStoreConfig('galavineyard/menu/dm_text2_color'),            
            'dm_font' => $dm_font,
            'bd_bg_color' => Mage::getStoreConfig('galavineyard/body/bd_bg_color'),
            'bd_bg2_color' => Mage::getStoreConfig('galavineyard/body/bd_bg2_color'),
            'bd_bg3_color' => Mage::getStoreConfig('galavineyard/body/bd_bg3_color'),
			'bd_bg_image' => $bd_bg_image,
            'bd_bg_position' => Mage::getStoreConfig('galavineyard/body/bd_bg_position'),
			'bd_bg_repeat' => Mage::getStoreConfig('galavineyard/body/bd_bg_repeat'),
			'bd_text_color' => Mage::getStoreConfig('galavineyard/body/bd_text_color'),
			'bd_text2_color' => Mage::getStoreConfig('galavineyard/body/bd_text2_color'),
			'bd_text3_color' => Mage::getStoreConfig('galavineyard/body/bd_text3_color'),
            'bd_text4_color' => Mage::getStoreConfig('galavineyard/body/bd_text4_color'),
			'bd_line_color' => Mage::getStoreConfig('galavineyard/body/bd_line_color'),
            'bd_line2_color' => Mage::getStoreConfig('galavineyard/body/bd_line2_color'),
			'bd_box_shadow' => Mage::getStoreConfig('galavineyard/body/bd_box_shadow'),
			'bd_rounded_corner' => Mage::getStoreConfig('galavineyard/body/bd_rounded_corner'),
            'foot_bg_color' => Mage::getStoreConfig('galavineyard/footer/foot_bg_color'),            
            'foot_bg_image' => $f_bg_image,
            'foot_bg_position' => Mage::getStoreConfig('galavineyard/footer/foot_bg_position'),
			'foot_bg_repeat' => Mage::getStoreConfig('galavineyard/footer/foot_bg_repeat'),
			'foot_text_color' => Mage::getStoreConfig('galavineyard/footer/foot_text_color'),
			'foot_text2_color' => Mage::getStoreConfig('galavineyard/footer/foot_text2_color'),
            'foot_text3_color' => Mage::getStoreConfig('galavineyard/footer/foot_text3_color'),
            'foot_line_color' => Mage::getStoreConfig('galavineyard/footer/foot_line_color'),
            'foot_line2_color' => Mage::getStoreConfig('galavineyard/footer/foot_line2_color'),
            'btn1_bg_color' => Mage::getStoreConfig('galavineyard/button/btn1_bg_color'),
			'btn1_text_color' => Mage::getStoreConfig('galavineyard/button/btn1_text_color'),
			'btn1_line_color' => Mage::getStoreConfig('galavineyard/button/btn1_line_color'),
			'btn1_font' => Mage::getStoreConfig('galavineyard/button/btn1_font'),
            'btn2_bg_color' => Mage::getStoreConfig('galavineyard/button/btn2_bg_color'),
			'btn2_text_color' => Mage::getStoreConfig('galavineyard/button/btn2_text_color'),
			'btn2_line_color' => Mage::getStoreConfig('galavineyard/button/btn2_line_color'),
			'btn2_font' => Mage::getStoreConfig('galavineyard/button/btn2_font'),
		);
	} 
	
	public function getImageBackgroundColor() {
		$color = Mage::getStoreConfig('galavineyard/general/image_bgcolor');
		if (!$color) $color = '#ffffff';
		$color = str_replace('#', '', $color);
		return array(
			hexdec(substr($color, 0, 2)),
			hexdec(substr($color, 2, 2)),
			hexdec(substr($color, 4, 2))
		);
	}
	
    public function getCategoriesCustom($parent,$curId){
				
		try{
			$children = $parent->getChildrenCategories();
						
		}
		catch(Exception $e){
			return '';
		}
		return $children;
	}
	
	public function insertStaticBlock($dataBlock) {
		// insert a block to db if not exists
		$block = Mage::getModel('cms/block')->getCollection()->addFieldToFilter('identifier', $dataBlock['identifier'])->getFirstItem();
		if (!$block->getId())
			$block->setData($dataBlock)->save();
		return $block;
	}
	
	public function insertPage($dataPage) {
		$page = Mage::getModel('cms/page')->getCollection()->addFieldToFilter('identifier', $dataPage['identifier'])->getFirstItem();
		if (!$page->getId())
			$page->setData($dataPage)->save();
		return $page;
	}
    
    // For search by category
    public function getCategoriesCustomSearch($parent,$curId){
		$result = '';
		if($parent->getLevel() == 1){
            $result = "<option value='0'>".$this->getCatNameCustom($parent)."</option>";
		}			
		else{
			$result = "<option value='".$parent->getId()."' ";
			
			if($curId){
				if($curId	==	$parent->getId()) $result .= " selected='selected'";
			}
			$result .= ">".$this->getCatNameCustom($parent)."</option>";			
		}
		
		try{
			$children = $parent->getChildrenCategories();
			
			if(count($children) > 0){
				foreach($children as $cat){
					$result .= $this->getCategoriesCustomSearch($cat,$curId);
				}
			}
		}
		catch(Exception $e){
			return '';
		}
        //var_dump($result);
		return $result;
	}
	
	public function getCatNameCustom($category){
		$level = $category->getLevel();
		$html = '';
		for($i = 0;$i < $level;$i++){
			$html .= '&mdash;&ndash;';
		}
		if($level == 1)	return $html.' '.$this->__("All Categories");
		else return $html.' '.$category->getName();
	}
    public function getAllManu()
    {
        $product = Mage::getModel('catalog/product');
        $attributes = Mage::getResourceModel('eav/entity_attribute_collection')
                  ->setEntityTypeFilter($product->getResource()->getTypeId())
                  ->addFieldToFilter('attribute_code', 'manufacturer');
        $attribute = $attributes->getFirstItem()->setEntity($product->getResource());
        $manufacturers = $attribute->getSource()->getAllOptions(false);
        return $manufacturers;
    }
    
    public function getSelectBox($attributeCode, $label = '', $defaultSelect = null, $extraParams = null){
        $options            = array();
        $product            = Mage::getModel('catalog/product');
        $attribute          = $product->getResource()->getAttribute($attributeCode);
        if($attribute->usesSource()){
            $options = $attribute->getSource()->getAllOptions(false);
            array_unshift($options, array('label' => $label, 'value' => ''));
        }
     
        $select = Mage::app()->getLayout()->createBlock('core/html_select')
                ->setName($attributeCode)
                ->setId($attributeCode)
                ->setTitle($label)
                ->setValue($defaultSelect)
                ->setExtraParams($extraParams)
                ->setOptions($options);
        return $select->getHtml();
    }
    
    public function getLabelProducts($id){
		$product = Mage::getModel('catalog/product')->load($id);
		$attributes = $product->getAttributes();
		$new = 'em_label_new';
		$newValue = 0;
		if(array_key_exists($new , $attributes)){
			$attributesobj = $attributes["{$new}"];
			$newValue = $attributesobj->getFrontend()->getValue($product);
			if($newValue=='Yes'){
				$newValue = 1;
			}else{
				$newValue = 0;
			}
		}
		$sale = 'em_label_saleoff';
		$saleValue = 0;
		if(array_key_exists($sale , $attributes)){
			$attributesobj = $attributes["{$sale}"];
			$saleValue = $attributesobj->getFrontend()->getValue($product);
			if($saleValue=='Yes'){
				$saleValue = 1;
			}else{
				$saleValue = 0;
			}
		}
		$best = 'em_label_bestseller';
		$bestValue = 0;
		if(array_key_exists($best , $attributes)){
			$attributesobj = $attributes["{$best}"];
			$bestValue = $attributesobj->getFrontend()->getValue($product);
			if($bestValue=='Yes'){
				$bestValue = 1;
			}else{
				$bestValue = 0;
			}
		}
		$html	=	"";
        if($newValue != 0){$htmnew="new";}
        if($saleValue != 0){$htmlsale="sale";};
        if($bestValue != 0){$htmlbest="bestseller";};
		if($newValue == 0 && $saleValue == 0 &&	$bestValue == 0 ){
			return $html;
		}else{
			$html	.=	'<span class="productlabels_icons">';
			if($newValue != 0)
				$html	.=		'<span class="label new"></span>';
			if($saleValue != 0)
				$html	.=		'<span class="label sale"></span>';
			if($bestValue != 0)
				$html	.=		'<span class="label bestseller"></span>';
			$html	.=	'</span>';

			return $html;
		}
	}
    
    public function checkMobilePhp() {
		require_once(Mage::getBaseDir('lib') . DS . 'em/Mobile_Detect.php');
		$detect = new Mobile_Detect();
        $checkmobile = $detect->isMobile();
        $checktablet = $detect->isTablet();
        if($checkmobile){
            if($checktablet){
                return 'false';
            }else{
                return 'true';
            }
            
        }else{
            return 'false';
        }
	}
    
    public function checkMobile() {
		require_once(Mage::getBaseDir('lib') . DS . 'em/Mobile_Detect.php');
		$detect = new Mobile_Detect();
        $checkmobile = $detect->isMobile();
        if($checkmobile){
            return 'true';            
        }else{
            return 'false';
        }
	}

    public function checkTabletPhp() {
		require_once(Mage::getBaseDir('lib') . DS . 'em/Mobile_Detect.php');
		$detect = new Mobile_Detect();
        $checktablet = $detect->isTablet();
        if($checktablet){
            return 'true';
        }else{
            return 'false';
        }
	}

	public function getActionReview(){
		$url = Mage::helper('core/url')->getCurrentUrl();
		$url_check = 'wishlist/index/configure';
		if(stripos($url,$url_check)){
			$id = Mage::registry('current_product')->getId();
			return Mage::getUrl('review/product/post/', array('id' => $id,'_secure' => true));
		} else {
			$url_check2 = 'checkout/cart/configure';
			if(stripos($url,$url_check2)){
				$id = Mage::getSingleton('catalog/session')->getLastViewedProductId();
				return Mage::getUrl('review/product/post/', array('id' => $id,'_secure' => true));
			}else{
				$productId = Mage::app()->getRequest()->getParam('id', false);
				return Mage::getUrl('review/product/post', array('id' => $productId,'_secure' => true));
			}
		}
	}

}