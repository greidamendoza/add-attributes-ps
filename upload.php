<?php
   session_start();

   include '../../config/config.inc.php';
   include 'includes/Csv.php';
   include 'includes/functions.php';   

   $error = '';
   $success = '';

   if (isset($_POST['btnSubmit'])) {

      if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {

         $fileTmpPath = $_FILES['file']['tmp_name'];
         $fileName = $_FILES['file']['name'];

         $uploadFileDir = './temp/';
         $pathFile = $uploadFileDir . $fileName;

         if(!move_uploaded_file($fileTmpPath, $pathFile)) {
            
            $error = 'Error al subir archivo.';

         } else {

            $processCsv = new Csv($pathFile);
            $data = $processCsv->csvToArray();

            for ($i=1; $i<=count($data); $i++) {

               $idProduct = $data[$i][0];
               $idAttribute = $data[$i][1];
               $SpecificPricePercentage = $data[$i][2];
               $link = $data[$i][3];
               
               $product = new Product($idProduct);
               $referenceProduct = $product->reference;

               if($product->active == 1) {
                  
                  $exists = existsAttribute($product, $idAttribute);

                  if ($exists == 0) {
                     
                     $idProductAttribute = addCombination($product, $referenceProduct, $idAttribute);
                     if ($idProductAttribute > 0) {
                        $suppliers = getSuppliers($product);

                        foreach ($suppliers as $id_supplier => $valor) {
                           $product->addSupplierReference($id_supplier, (int)$idProductAttribute, $referenceProduct.'-P');                        
                        }

                        $product->checkDefaultAttributes();

                        if($SpecificPricePercentage > 0){
                           $reduction = $SpecificPricePercentage/100;
                           addSpecificPrice($product, $idProductAttribute, $reduction, 'percentage');
                        }

                        addWarehouseCentral($product, $idProductAttribute);

                        addLink($product, $link);
                     }
                     
                  }
               }
            }
            
            $success = 'Se han procesado los datos en Prestashop';
         }
      }
   }
   
   if (strlen($error)) {
      $_SESSION['error'] = $error;
   } else {
      $_SESSION['success'] = $success;
   }
   header("Location: index.php");
?>
