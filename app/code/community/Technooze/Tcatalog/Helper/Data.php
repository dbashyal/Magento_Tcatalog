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
class Technooze_Tcatalog_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function removeComparison()
   	{
        return 1;
   	}

    public function currentProduct()
   	{
        return Mage::registry('product');
   	}

    public function getAttributeAdminLabel($attributeCode, $item){
        ///trunk/app/code/core/Mage/Eav/Model/Config.php
        $entityType = Mage::getModel('eav/config')->getEntityType('catalog_product');
        //$entityTypeId = $entityType->getEntityTypeId();
        $attributeModel = Mage::getModel('eav/entity_attribute')->loadByCode($entityType, $attributeCode);
        $_collection = Mage::getResourceModel('eav/entity_attribute_option_collection')
                          ->setAttributeFilter($attributeModel->getId())
                        ->setStoreFilter(0)
                        ->load();

        foreach( $_collection->toOptionArray() as $_cur_option ) {
            if ($_cur_option['value'] == $item->getValue()){ return $_cur_option['label']; }
        }
        return $item->getLabel();
    }
}