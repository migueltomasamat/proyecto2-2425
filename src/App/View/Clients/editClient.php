<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cliente</title>
</head>
<body>
<h2>Editar Cliente</h2>
<form method="post" action="/modificarCliente">
    <!-- UUID del Cliente -->
    <input type="hidden" name="clientuuid" value="<?= $cliente->getUuid() ?>">

    <!-- Nombre -->
    <label for="nombre">Nombre:</label>
    <input type="text" name="clientname" id="nombre" value="<?= $cliente->getNombre() ?>" required><br>

    <!-- Dirección -->
    <label for="direccion">Dirección:</label>
    <input type="text" name="clientaddress" id="direccion" value="<?= $cliente->getDireccion() ?>" required><br>

    <!-- Coste -->
    <label for="coste">Coste:</label>
    <input type="number" name="clientcost" id="coste" step="0.01" value="<?= $cliente->getCoste() ?>" min="0" required><br>

    <!-- Abierto -->
    <label for="abierto">¿Abierto?:</label>
    <select name="clientisopen" id="abierto" required>
        <option value="1" <?= $cliente->isAbierto() ? 'selected' : '' ?>>Sí</option>
        <option value="0" <?= !$cliente->isAbierto() ? 'selected' : '' ?>>No</option>
    </select><br>

    <!-- Botón para guardar -->
    <input type="submit" value="Guardar Cambios">
</form>
</body>
</html>
