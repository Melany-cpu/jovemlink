<?php

    $hostBD   = "localhost";
    $userBD   = "root"; 
    $senhaBD  = "root"; 
    $database = "jovemlink"; 

    $conn = mysqli_connect($hostBD, $userBD, $senhaBD, $database);

    if (!$conn) {
        // Exibe o motivo exato retornado pelo servidor MySQL
        echo "<div style='color:red; background:#ffe6e6; padding:10px; border:1px solid red;'>";
        echo "<strong>Erro de Conexão MySQL:</strong> " . mysqli_connect_error() . "<br>";
        echo "<strong>Código do Erro:</strong> " . mysqli_connect_errno();
        echo "</div>";
        exit();
    }

?>