<?php
class CurrencyModel
{
    private $pdo;

    public function __CONSTRUCT()
    {
        try
        {
            $this->pdo = new PDO('mysql:host=localhost;dbname=currencies', 'root', '1234');
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }
    //funcion para listar todos los datos de la BD
    public function Listar()
    {
        try
        {
            $result = array();

            $stm = $this->pdo->prepare("SELECT * FROM Currency");
            $stm->execute();

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $curr= new Currency();

                $curr->__SET('id', $r->id);
                $curr->__SET('name', $r->name);
                $curr->__SET('code', $r->code);
                $curr->__SET('num', $r->num);
                $curr->__SET('simbol', $r->simbol);


                $result[] = $curr;
            }

            return $result;
        }
        catch(Exception $e)
        {
            die($e->getMessage());
        }
    }

    //Obtener un registro por su ID
    public function Obtener($id)
    {
        try
        {
            $stm = $this->pdo
                ->prepare("SELECT * FROM Currency WHERE id = ?");


            $stm->execute(array($id));
            $r = $stm->fetch(PDO::FETCH_OBJ);

            $curr= new Currency();

            $curr->__SET('id', $r->id);
            $curr->__SET('name', $r->name);
            $curr->__SET('code', $r->code);
            $curr->__SET('num', $r->num);
            $curr->__SET('simbol', $r->simbol);

            return $curr;
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
    //Eliminar registro
    public function Eliminar($id)
    {
        try
        {
            $stm = $this->pdo
                ->prepare("DELETE FROM Currency WHERE id = ?");

            $stm->execute(array($id));
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
    //Buscar alguna ocurrencia del campo "BUSQUEDA" en la BD con LIKE.
    public function Buscar()
    {

        try
        {
          $result = array();
            $nombre = addslashes(htmlspecialchars($_POST["busqueda"]));
//            echo $nombre;
            $stm = $this->pdo->prepare("SELECT * FROM Currency WHERE name LIKE ?");

            $stm->execute(array("%$nombre%"));

            foreach($stm->fetchAll(PDO::FETCH_OBJ) as $r)
            {
                $curr= new Currency();

                $curr->__SET('id', $r->id);
                $curr->__SET('name', $r->name);
                $curr->__SET('code', $r->code);
                $curr->__SET('num', $r->num);
                $curr->__SET('simbol', $r->simbol);

                $result[] = $curr;
            }

            return $result;
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    //Actualizar registros
    public function Actualizar(Currency $data)
    {
        try
        {
            $sql = "UPDATE Currency SET
	                    name          = ?,
						code        = ?,
						num            = ?,
						simbol = ?
				    WHERE id = ?";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->__GET('name'),
                        $data->__GET('code'),
                        $data->__GET('num'),
                        $data->__GET('simbol'),
                        $data->__GET('id')
                    )
                );
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }

    //Insertar un nuevo registro
    public function Registrar(Currency $data)
    {
        try
        {
            $sql = "INSERT INTO Currency (name,code,num,simbol)
		        VALUES (?, ?, ?, ?)";

            $this->pdo->prepare($sql)
                ->execute(
                    array(
                        $data->__GET('name'),
                        $data->__GET('code'),
                        $data->__GET('num'),
                        $data->__GET('simbol')
                    )
                );
        } catch (Exception $e)
        {
            die($e->getMessage());
        }
    }
}