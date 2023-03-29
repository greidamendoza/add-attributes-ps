<?php
   function existsAttribute($product, $idAttribute)
   {
      $attributes = $product->getAttributesGroups(4);

      $exists = 0;
      foreach($attributes as $attr){
         if($attr['id_attribute'] == $idAttribute) {
            $exists = 1;
            break;
         }
      }

      return $exists;
   }

   function addCombination($product, $reference, $idAttribute)
   {
      $idProductAttribute = 0;
      $idProductAttribute = $product->addCombinationEntity('', 0, '', '', '', 0, '', $reference, null, '', '', '', '', '', array(), '');
      if($idProductAttribute > 0) {
         StockAvailable::setProductDependsOnStock((int)$product->id, $product->depends_on_stock, null, (int)$idProductAttribute);
         StockAvailable::setProductOutOfStock((int)$product->id, $product->out_of_stock, null, (int)$idProductAttribute);

         $combination = new Combination((int)$idProductAttribute);
         $combination->setAttributes(array($idAttribute));

         $product->checkDefaultAttributes();

         return $idProductAttribute;
      }
   }

   function getSuppliers($product)
   {
      $suppliers = [];
      $sql = "SELECT
                  ps_product_supplier.id_product_attribute, 
                  ps_product_supplier.id_product,
                  ps_product_supplier.product_supplier_reference, 
                  ps_supplier.id_supplier, 
                  ps_supplier.`name`
               FROM
                  ps_supplier
                  INNER JOIN
                  ps_product_supplier
                  ON 
                     ps_supplier.id_supplier = ps_product_supplier.id_supplier
                  WHERE ps_product_supplier.id_product = ".$product->id;
      $result = Db::getInstance()->executeS($sql);
      foreach($result as $row) {
         $suppliers[$row['id_supplier']] = $row['name'];
      }

      return $suppliers;
   }

   function addSpecificPrice($product, $idProductAttribute, $reduction, $reductionType)
   { 
      $specificPrice = new SpecificPrice();
      $specificPrice->id_product = $product->id;
      $specificPrice->id_product_attribute = $idProductAttribute;
      $specificPrice->id_shop = 1;
      $specificPrice->id_currency = 0;
      $specificPrice->id_country = 0;
      $specificPrice->id_group = 0;
      $specificPrice->id_customer = 0;
      $specificPrice->price = -1;
      $specificPrice->from_quantity = 1;
      $specificPrice->reduction = $reduction;
      $specificPrice->reduction_type = $reductionType;
      $specificPrice->reduction_tax = 0;
      $specificPrice->from = 0;
      $specificPrice->to = 0;
      
      if($specificPrice->add()){
         return true;
      }else{
         return false;
      }
   }

   function addWarehouseCentral($product, $idProductAttribute)
   {
      if (Warehouse::exists(2)) {
         $warehouse_location_entity = new WarehouseProductLocation();
         $warehouse_location_entity->id_product = (int)$product->id;
         $warehouse_location_entity->id_product_attribute = (int)$idProductAttribute;
         $warehouse_location_entity->id_warehouse = 2;
         if (WarehouseProductLocation::getProductLocation((int)$product->id, (int)$idProductAttribute, 2) !== false) {
            $warehouse_location_entity->update();
         } else {
            $warehouse_location_entity->save();
         }  
      }
   }

   function addLink($product, $link) {
      if(strlen($link)) {
         $sql = "INSERT IGNORE INTO ps_sbitbuttonrepair (id_product, url) VALUES ('".$product->id."', '".$link."')";
		   Db::getInstance()->execute($sql);
      }      
   }
?>