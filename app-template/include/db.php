<?php 

try{
    $db = new PDO(DNS, DB_USER, DB_PASS);
}catch(exeption $e){
    echo $e->getMessage();
}
?>