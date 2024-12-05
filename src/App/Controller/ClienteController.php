<?php

namespace App\Controller;
use App\Class\Cliente;
use App\Class\Usuario;
use App\Class\Telefono;
use App\Excepcions\DeleteClientException;
use App\Excepcions\ReadClientException;
use App\Model\clienteModel;
use App\Controller\InterfaceController;
use Respect\Validation\Exceptions\NestedValidationException;
use Respect\Validation\Validator;

include_once "InterfaceController.php";

class ClienteController implements InterfaceController
{
    //GET /clients
    public function index($api){
        include_once DIRECTORIO_VISTAS."/Clients/indexClient.php";
    }

    //GET /clients/create
    public function create($api){
        //Aquí mostraríamos el formulario de registro
        include_once DIRECTORIO_VISTAS."/Clients/createClient.php";
        echo "Formulario de registro de un cliente";

    }

    //POST /clients
    public function store($api)
    {
        $errores = '';

        try {
            // Validación de los datos del cliente usando Respect\Validation
            Validator::key('clientname', Validator::stringType()->notEmpty()->length(1, 100))
                ->key('clientaddress', Validator::optional(Validator::stringType()->length(1, 255)))
                ->key('clientisopen', Validator::boolType())
                ->key('clientcost', Validator::numeric()->positive())
                ->key('useruuid', Validator::stringType()->notEmpty()->length(36, 36))
                ->assert($_POST);
        } catch (NestedValidationException $exception) {
            $errores = $exception->getMessages();
        }

        //Comprobamos si ha habido errores
        if (is_array($errores)){
            include_once DIRECTORIO_VISTAS."/Clients/errorClient.php";
        }else{
            $cliente=Usuario::crearClienteAPartirDeUnArray($_POST);
        }
        //Guardamos el cliente
        $cliente->save();

        //Creación del cliente
        if ($api){
            http_response_code(201);
            header('Content-Type: application/json');
            echo json_encode($cliente);
        }else{
            $informacion=['Se ha creado el usuario correctamente'];
            $_SESSION['clientname']=$cliente->getNombre();
            $_SESSION['clientuuid']=$cliente->getUuid();
            include_once DIRECTORIO_VISTAS."informacion.php";
        }
    }


    //GET /clients/{id_usuario}/edit
    public function edit($id,$api){
        //Comprobar que el cliente exista y cargar los datos
        $cliente=ClienteModel::leerCliente($id);
        if (!$cliente){
            $errores[]="Usuario no encontrado";
            include_once DIRECTORIO_VISTAS."errores.php";
            exit();
        }else{
            include_once DIRECTORIO_VISTAS."Clients/editClient.php"; //Revisar
        }
    }


    //PUT /clients/{id_usuario}
    public function update($id,$api){
        // Obtén el cliente actual desde el modelo
        $cliente = ClienteModel::leerCliente($id);

        // Leer los datos enviados a través de PUT
        parse_str(file_get_contents("php://input"), $datos_put_para_editar);

        // Filtramos y validamos los datos recibidos
        try {
            Validator::key('clientname', Validator::optional(Validator::stringType()->notEmpty()->length(3, 100)), false)
                ->key('clientaddress', Validator::optional(Validator::stringType()->length(1, 255)), false)
                ->key('clientisopen', Validator::optional(Validator::boolType()), false)
                ->key('clientcost', Validator::optional(Validator::numeric()->positive()), false)
                ->key('clientphones', Validator::optional(Validator::arrayType()), false)
                ->key('userdata', Validator::optional(Validator::json()), false)
                ->assert($datos_put_para_editar);
        } catch (NestedValidationException $exception) {
            $errores = $exception->getMessages();
        }

        // Manejar errores de validación
        if (isset($errores) && is_array($errores)) {
            if ($api) {
                http_response_code(400);
                header('Content-Type: application/json');
                echo json_encode(['errors' => $errores]);
                return;
            } else {
                include_once DIRECTORIO_VISTAS . '/Clients/errorClient.php';
                return;
            }
        }

        // Actualizar los datos del cliente
        $cliente->setNombre($datos_put_para_editar['clientname'] ?? $cliente->getNombre());
        $cliente->setDireccion($datos_put_para_editar['clientaddress'] ?? $cliente->getDireccion());
        $cliente->setAbierto($datos_put_para_editar['clientisopen'] ?? $cliente->isAbierto());
        $cliente->setCoste($datos_put_para_editar['clientcost'] ?? $cliente->getCoste());
        $cliente->setTelefonos($datos_put_para_editar['clientphones'] ?? $cliente->getTelefonos());

        // Guardar el cliente actualizado en la base de datos
        $cliente->save();

        // Responder a la solicitud
        if ($api) {
            http_response_code(200);
            header('Content-Type: application/json');
            echo json_encode($cliente);
        } else {
            $_SESSION['clientename'] = $cliente->getNombre();
            $_SESSION['clienteuuid'] = $cliente->getUuid();
            $informacion = ['Se ha actualizado el cliente correctamente'];
            include_once DIRECTORIO_VISTAS . "informacion.php";
        }

    }


    //GET /clients/{id_usuario}
    public function show($id, $api){
        //Mostraría los datos de un solo usuario
        echo "Mostar los datos del cliente $id";
    }


    //DELETE /clients/{id_usuario}
    public function destroy($id, $api){
        //Borrar los datos de un usuario
        echo "Función para borrar los datos del cliente $id";
    }

}