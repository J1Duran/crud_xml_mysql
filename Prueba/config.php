

<?php

    $db_host='localhost';
    $db_usuario='root';
    $db_password='1234';
    $db_nombre ='currencies';
    if (!($con=mysql_connect($db_host, $db_usuario, $db_password)))
    {
        echo "Error al conectar a la base de datos.";
        exit();
    }
    if (!mysql_select_db($db_nombre,$con))
    {
        echo "Error al seleccionarla base de datos.";
        exit();
    }

?>