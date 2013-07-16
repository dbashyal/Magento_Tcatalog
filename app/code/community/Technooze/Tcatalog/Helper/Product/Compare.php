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
class Technooze_Tcatalog_Helper_Product_Compare extends Mage_Catalog_Helper_Product_Compare
{
    // enable or disable products comparison
    private $_enable = false;

    public function __construct(){
        $this->_enable = Mage::getStoreConfig('catalog/recently_products/compared_count');
    }

    /**
     * Retrieve url for adding product to compare list
     *
     * @param   Mage_Catalog_Model_Product $product
     * @return  boolean|string
     */
    public function getAddUrl($product)
    {
        // To disable product comparison:
        // Go to System > Configuration > Catalog: Catalog > Recently Viewed/Compared Products
        // Set 'Default Recently Compared Products' count to 0
        if($this->_enable) {
            return parent::getAddUrl($product);
        }
        return $this->_enable;
    }
}