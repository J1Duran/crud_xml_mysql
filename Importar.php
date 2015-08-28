<?php
//Seleccionamos archivo.xml
$xml_file = 'currencies.xml';

if (file_exists($xml_file)) { //Comprobamos que exista
    $xml = simplexml_load_file($xml_file); //Leemos el archivo xml
    echo $xml;
} else {
    exit('Error al intentar abrir el fichero '.$xml_file);
}

//Establecemos la conexion con la BD currencies
require 'config.php';
$NumRegistros=0;
$registros=$xml->CcyTbl;
foreach ($registros->CcyNtry as $ccy) {
    // Insertamos en la tabla Currency
    $qry = "INSERT INTO Currency ".
        "(name,code,num)".
        " VALUES ('$ccy->CcyNm', ". "'$ccy->Ccy', ". "'$ccy->CcyNbr' ".")";
    $result = mysql_query($qry) or die(mysql_error());
    $NumRegistros++; //Llevamos cuenta de los registros subidos a la BD
}

echo "<br/>";
echo "-------------------------------------------<br/>";
echo "Total de registros importados: $NumRegistros properties<br/>";
echo "-------------------------------------------<br/>";

?>