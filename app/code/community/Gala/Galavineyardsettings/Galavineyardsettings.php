<?php
/**
 * @deprecated use Mage::helper('galavineyardsettings') instead
 * @methods:
 * - get[Section]_[ConfigName]($defaultValue = '')
 */
class Gala_Galavineyardsettings_Galavineyardsettings
{
	static function __callStatic($name, $args) {
		if (method_exists(self, $name))
			call_user_func_array(array(self, $name), $args);
			
		elseif (preg_match('/^get([^_][a-zA-Z0-9_]+)$/', $name, $m)) {
			$segs = explode('_', $m[1]);
			foreach ($segs as $i => $seg)
				$segs[$i] = strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1_$2', $seg));

			$value = Mage::getStoreConfig('galavineyard/'.implode('/', $segs));
			if (!$value) $value = @$args[0];
			return $value;
		}
		
		else 
			call_user_func_array(array(self, $name), $args);
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
}