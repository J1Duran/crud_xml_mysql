<?php
require_once 'currency.entidad.php';
require_once 'currency.model.php';

// Instanciamos Currency y su Model
$curr = new Currency();
$model = new CurrencyModel();

if(isset($_REQUEST['action']))
{
    switch($_REQUEST['action'])
    {
        //En caso de que se ejecute el submit, a travez de un QueryString pasamos las acciones a realizar en el action
        //serian Registrar y Actualizar
        case 'actualizar':
            $curr->__SET('id',              $_REQUEST['id']);
            $curr->__SET('name',          $_REQUEST['name']);
            $curr->__SET('code',        $_REQUEST['code']);
            $curr->__SET('num',            $_REQUEST['num']);
            $curr->__SET('simbol', $_REQUEST['simbol']);
            $model->Actualizar($curr);
            header('Location: index.php');
            break;

        case 'registrar':
            $curr->__SET('name',          $_REQUEST['name']);
            $curr->__SET('code',        $_REQUEST['code']);
            $curr->__SET('num',            $_REQUEST['num']);
            $curr->__SET('simbol', $_REQUEST['simbol']);

            $model->Registrar($curr);
            header('Location: index.php');
            break;
        // Igualmente cuando se elimina o edita un registro se pasa a travez href, el metodo PHP a ejecutar junto con su ID
        case 'eliminar':
            $model->Eliminar($_REQUEST['id']);
            header('Location: index.php');
            break;

        case 'editar':
            $curr = $model->Obtener($_REQUEST['id']);
            break;
    }
}


?>

<!DOCTYPE html>
<html lang="es">
<head>
    <title>Prueba</title>
    <link rel="stylesheet" href="http://yui.yahooapis.com/pure/0.5.0/pure-min.css">
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
<body style="padding:15px;">

<div class="pure-g">
    <div class="pure-u-1-12">
        <form action="?action=<?php echo $curr->id > 0 ? 'actualizar' : 'registrar'; ?>" method="post" id="formulario" class="pure-form pure-form-stacked" style="margin-bottom:30px;">

            <input type="hidden" name="id" value="<?php echo $curr->__GET('id'); ?>" />

            <table style="width:500px;">
                <tr>
                    <th style="text-align:left;">Name</th>
                    <td><input type="text" name="name" value="<?php echo $curr->__GET('name'); ?>" style="width:100%;" /></td>
                </tr>
                <tr>
                    <th style="text-align:left;">Code</th>
                    <td><input type="text" name="code" value="<?php echo $curr->__GET('code'); ?>" style="width:100%;" /></td>
                </tr>
                <tr>
                    <th style="text-align:left;">Numeric</th>
                    <td>
                        <input type="text" name="num" value="<?php echo $curr->__GET('num'); ?>" style="width:100%;"

                    </td>
                </tr>
                <tr>
                    <th style="text-align:left;">Simbol</th>
                    <td><input type="text" name="simbol" value="<?php echo $curr->__GET('simbol'); ?>" style="width:100%;" /></td>
                </tr>
                <tr>
                    <td colspan="2">
                        <button type="submit" class="pure-button pure-button-primary">Guardar</button>
                    </td>
                    <td colspan="2">
                        <input type="text" name="busqueda" placeholder="Buscar por nombre"><br>
                        <button type="button" id="btn_enviar" class="pure-button pure-button-primary">Buscar</button>

<!--                        <a href="index.php" onclick="xajax_procesar_formulario(xajax.getFormValues('formulario'))">Buscar</a>-->

<!--                        <input type="submit" value="Enviar" name="buscar">-->
                    </td>
<!--                    <td>-->
<!--                        <input type="submit" onclick = "this.form.action = 'index.php'" value="registrar" />-->
<!--                        <input type="submit" onclick = "this.form.action = 'index.php'" value="buscar" />-->
<!--                    </td>-->
                </tr>
            </table>
        </form>
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
            <?php foreach($model->Listar() as $r): ?>
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

    </div>
</div>

</body>
</html>