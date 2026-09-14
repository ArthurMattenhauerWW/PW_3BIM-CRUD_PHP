<?php 
include "functions.php"; 
try {
  if (isset($_GET['id'])){
    delete($_GET['id']);
   } // else {
//     die("ERRO: ID não definido.");
//   }
}

catch (Exception $e) {
    $_SESSION['message'] = "Não foi possível realizar a operação.<br>{$e->getMEssage()}";
    $_SESSION['type'] = "danger";
}
?>