
<?php 

    function conectarBD() {
        mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

        try {
            $db = new mysqli('localhost', 'root', 'root', 'bienesraices_crud');
            $db->set_charset('utf8'); // para evitar problemas con acentos
            return $db;
        } catch (mysqli_sql_exception $e) {
            echo "Error en la conexión: " . $e->getMessage();
            exit;
        }
    }
?>

<script src="../../src/js/app.js"></script>