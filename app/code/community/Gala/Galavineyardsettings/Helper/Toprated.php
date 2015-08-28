<?php
/**
 * @methods:
 * - get[Section]_[ConfigName]($defaultValue = '')
 */
class Gala_Galavineyardsettings_Helper_toprated extends Mage_Core_Helper_Abstract
{
	public function getTopRatedProducts($limit) {

         $limit = 5;
 
    // get all visible products
    $_products = Mage::getModel('catalog/product')->getCollection();
    $_products->setVisibility(Mage::getSingleton('catalog/product_visibility')->getVisibleInCatalogIds());
    $_products->addAttributeToSelect('*')->addStoreFilter();           
         
    $_rating = array();
 
    foreach($_products as $_product) { 
     
        $storeId = Mage::app()->getStore()->getId();
 
        // get ratings for individual product
        $_productRating = Mage::getModel('review/review_summary')
                            ->setStoreId($storeId)
                            ->load($_product->getId());
          
        $_rating[] = array(
                     'rating' => $_productRating['rating_summary'],
                     'product' => $_product                        
                    );             
    }
 
    // sort in descending order of rating
    arsort($_rating);
     
    // returning limited number of products and ratings
    return array_slice($_rating, 0, $limit);
    }
}


