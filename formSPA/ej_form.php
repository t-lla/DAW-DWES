<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $servername = "localhost";
    $username = "root"; // Usuario por defecto de XAMPP
    $password = ""; // Contraseña vacía por defecto en XAMPP
    $dbname = "ej_form"; // Nombre de la base de datos

    $conn = new mysqli($servername, $username, $password, $dbname); //creo la conexión a la bbdd

    if ($conn->connect_error) {
        die("Conexión fallida: " . $conn->connect_error); //capturo el posible error de conexión
    }

    //recibo datos del formulario
    $nombre = $_POST['nombre'];
    $email = $_POST['email'];
    $tlf = $_POST['tlf'];
    $fecha = $_POST['fecha'];
    $genero = $_POST['genero'];
    $pais = $_POST['pais'];


    //consultas preparadas
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre, email, telefono, fecha_nacimiento, genero, pais) VALUES (?, ?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error en la preparación de la consulta: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $nombre, $email, $tlf, $fecha, $genero, $pais);

    //ejecutar la consulta para que, al hacerse, nos devuelva a ej_form.html
    if ($stmt->execute()) {
        echo "<script>alert('Registro exitoso'); window.location.href = 'ej_form.html';</script>";
    } else {
        die("Error al insertar datos: " . $stmt->error);
    }

    //cerramos la conexión
    $stmt->close();
    $conn->close();

}
?>