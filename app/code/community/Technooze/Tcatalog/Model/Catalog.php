<?php
/**
 * Technooze_Tcatalog extension
 *
 * NOTICE OF LICENSE
 *
 * This source file is subject to the Open Software License (OSL 3.0)
 * that is bundled with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://opensource.org/licenses/osl-3.0.php
 *
 * @category   Technooze
 * @package    Technooze_Tcatalog
 * @copyright  Copyright (c) 2008 Technooze LLC
 * @license    http://opensource.org/licenses/osl-3.0.php  Open Software License (OSL 3.0)
 */

/**
 *
 * @category Technooze
 * @package  Technooze_Tcatalog
 * @module   Tcatalog
 * @author   Damodar Bashyal (enjoygame @ hotmail.com)
 */
class Technooze_Tcatalog_Model_Catalog extends Mage_Core_Model_Abstract
{
    public function _construct()
    {
        parent::_construct();
        $this->_init('tcatalog/catalog');
    }

    /**
     * Purpose of this function is to get any atrribute value,
     * but now it's set to support for weight only which is urgent
     * for the project at the moment.
     * Probably will expand it with better logics next time.
     *
     * @param int|object $product
     * @param array|string $attributes
     * @return array
     */
    public function getAttributeValue($product = 0, $attributes = array()){
        $attr = array();
        $weight = 0;
        $single = (is_array($attributes) ? 0 : 1);
        $attributes = (array)$attributes;

        if(!$product && !Mage::registry('current_product')){
            return array();
        }
        $product = ($product ? $product : Mage::registry('current_product'));

        if(!is_object($product) && !empty($product)){
            // load product data
            $product = (int)$product;
            $product = Mage::getModel('catalog/product')->load($product);
        }

        // check to see if the product is of type configurable
        if($product->getData('type_id') == Mage_Catalog_Model_Product_Type::TYPE_CONFIGURABLE){
            $collection = Mage::getModel('catalog/product_type_configurable')

              // Retrieve related products collection
              ->getUsedProductCollection($product);

            foreach($attributes as $a){
              // make sure requested attributes are included in the loaded data
                $collection->addAttributeToSelect($a);
            }

              // let's sort the collection by weight in descending order
            $collection->setOrder('weight', 'desc')

              // and we are after just one record, so set the limit as 1
              ->setPageSize(1);
        } else/* if($product->getData('type_id') == Mage_Catalog_Model_Product_Type::TYPE_SIMPLE)*/{
            $collection = Mage::getModel('catalog/product')->getCollection();
            $collection->addAttributeToSelect('*');
            $collection->addFieldToFilter('sku', $product->getData('sku'));
        }

        // let's go through the collection
        foreach($collection as $v){
            // save weight info as float
            $wt = (float)$v->getData('weight');

            // now check and use the highest weight,
            // either defined or received from product info
            $weight = (($weight > $wt) ? $weight : $wt);

            $attr['weight'] = $weight;
        }

        // if we are after just one value, then return value only
        if($single){
            return array_shift($attr);
        }

        // if not single then return full array
        return $attr;
    }
}