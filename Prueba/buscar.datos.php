<?php
require_once 'currency.entidad.php';
require_once 'currency.model.php';
$model = new CurrencyModel();
$pdo = new PDO('mysql:host=localhost;dbname=currencies', 'root', '1234');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <title>Prueba</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
    <!--    <script src="/JQuery/jquery-1.11.3.min.js"></script>-->
    <script src="http://code.jquery.com/jquery-1.11.3.min.js"></script>

    <script>
        $(function(){
            $("#btn_enviar").click(function(){
                var url = "buscar.datos.php"; // URL donde se encuentra el Script
                $.ajax({
                    type: "POST",
                    url: url,
                    data: $("#formulario").serialize(), // Se adjuntan los datos del formulario.
                    success: function(data)
                    {
                        $("#respuesta").html(data);
                    }
                });

                return false; // Esto es para evitar que se ejecute el submit del formulario
            });
        });
    </script>

</head>
<body>
        <h4 style="text-align:left;">Resultados de Busqueda:</h4>
        <table class="pure-table pure-table-horizontal">
            <div id="respuesta">
            </div>
            <thead>
            <tr>
                <th style="text-align:left;">ID</th>
                <th style="text-align:left;">NAME</th>
                <th style="text-align:left;">NUMERIC</th>
                <th style="text-align:left;">SIMBOL</th>
                <th style="text-align:left;">CODE</th>
                <th></th>
                <th></th>
            </tr>
            </thead>
            <?php foreach($model->Buscar() as $r): ?>
                <tr>
                    <td><?php echo $r->__GET('id'); ?></td>
                    <td><?php echo $r->__GET('name'); ?></td>
                    <td><?php echo $r->__GET('num') ; ?></td>
                    <td><?php echo $r->__GET('simbol'); ?></td>
                    <td><?php echo $r->__GET('code'); ?></td>
                    <td>
                        <a href="?action=editar&id=<?php echo $r->id; ?>">Editar</a>
                    </td>
                    <td>
                        <a href="?action=eliminar&id=<?php echo $r->id; ?>">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <hr size="2px" color="black" />
</body>
</html>
