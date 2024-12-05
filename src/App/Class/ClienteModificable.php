<?php

namespace App\Class;

use App\Class\Cliente;
use App\Model\UsuarioModel;
use Exception;
use Ramsey\Uuid\Uuid;

class ClienteModificable extends Cliente{

    public static function crearClienteAPartirDeUnArray(array $datosCliente): Cliente {
        // Verifica si la clase concreta que deseas usar está definida
        if (!class_exists('ClienteConcreto')) {
            throw new Exception('No se puede instanciar la clase Cliente directamente. Define una clase concreta que extienda Cliente.');
        }

        // Instanciar el cliente a partir de la clase concreta
        $cliente = new ClienteModificable();

        // Seteando los datos del cliente
        $cliente->setUuid($datosCliente['clientuuid'] ?? Uuid::uuid4());
        $cliente->setNombre($datosCliente['clientname'] ?? "Sin nombre");
        $cliente->setDireccion($datosCliente['clientaddress'] ?? "Sin dirección");
        $cliente->setAbierto((bool)($datosCliente['clientisopen'] ?? 0));
        $cliente->setCoste((float)($datosCliente['clientcost'] ?? 0.0));

        // Relacionar el cliente con un usuario, si se proporciona el UUID del usuario
        if (isset($datosCliente['useruuid'])) {
            $usuario = UsuarioModel::leerUsuario($datosCliente['useruuid']);
            if ($usuario) {
                $cliente->setUsuario($usuario);
            } else {
                throw new Exception("No se encontró un usuario con el UUID proporcionado.");
            }
        }

        return $cliente;
    }

    function comprobarDisponibilidad(): bool
    {
        return false;
    }
}