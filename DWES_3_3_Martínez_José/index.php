<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Project/PHP/PHPProject.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>Índice</title>
    </head>
    <body>
        <?php
        //Creación de conexión a la base de datos
        $conexionBD = new mysqli();
        //Ejecución de la conexión y comprobacion de errores
        try {
            $conexionBD->connect("localhost", "root", "", "espectaculos");
        } catch (Exception $ex) {
            echo "ERROR: " . $ex->getMessage();
        }
        ?>
        <h2>Registros de la tabla de Espectáculo que no tienen estrellas: <h2>
                <?php
                //Realizamos una transacción para controlar que se devuelva la tabla sino , no hay registros por actualizar
                $conexionBD->autocommit(false);
                //Control de excepciones en caso de error o fallo.
                try {
                    //Realizamos una consulta de aquellos espectaculos que no tengan estrellas
                    $consultaEspectaculosSinEstrellas = $conexionBD->query('SELECT * FROM espectaculo WHERE estrellas IS NULL');
                    //Realizamos la consulta de actualización de las estrellas por registros
                    $consultaDeActualizacionEspectaculosEstrellas = $conexionBD->query('UPDATE espectaculo SET estrellas = 1 WHERE estrellas IS NULL');
                    //Realizamos una consulta que muestra todos los registros actualizados
                    $consultaTodosLosEspectaculos = $conexionBD->query('SELECT *  FROM espectaculo');
                } catch (Exception $ex) {
                    echo "ERROR:" . $ex->getMessage();
                }
                $consultaEspectaculosSinEstrellasCorrecta = $consultaEspectaculosSinEstrellas;
                if ($consultaEspectaculosSinEstrellasCorrecta) {
                    ?>
                    <table border="1">
                        <?php
                        $contador = 0;
                        while ($fila = $consultaEspectaculosSinEstrellas->fetch_assoc()) {
                            if ($contador == 0) {
                                ?>
                                <tr>
                                    <?php foreach ($fila as $clavesEspectaculosSinEstrellas => $datosEspectaculosSinEstrellas) { ?>
                                        <th><?php
                                            //Imprimimos las claves 
                                            print $clavesEspectaculosSinEstrellas;
                                            ?></th>
                                    <?php } ?>
                                </tr> 
                            <?php } ?>
                            <tr>
                                <?php foreach ($fila as $clave => $espectaculosSinEstrellas) { ?>
                                    <td>
                                        <?php echo $espectaculosSinEstrellas ?>
                                    </td>
                                <?php } ?>
                            </tr>
                            <?php $contador++; ?>
                        <?php } ?>
                    </table>
                    <?php $conexionBD->commit(); ?>
                <?php } else { ?>
                    <?php
                    echo "No hay registros con 0 estrellas";
                    $conexionBD->rollback();
                }
                ?>
                <br>
                <h2>Realizamos la actualización de los registros que no tienen estrellas</h2>
                <?php
                //Realizamos una transacción para controlar los posibles errores en caso de que la consulta no se ejecute
                $conexionBD->autocommit(false);
                $todoCorrecto = $consultaDeActualizacionEspectaculosEstrellas;
                if ($todoCorrecto) {
                    echo "Los registros han sido actualizados, filas afectadas: $conexionBD->affected_rows";
                    $conexionBD->commit();
                } else {
                    //Sino revertimos los cambios
                    echo "Los registros no han sido actualizados, filas afectadas: $conexionBD->affected_rows.";
                    $conexionBD->rollback();
                }
                ?>
                <h2>Generamos una tabla que contenga todos las claves y valores de los campos de la tabla Espectáculo actualizados</h2>
                <?php
                //Realizamos una consulta que muestre los registros actualizados de la tabla espectaculo
                ?>
                </br></br>
                <table border="1">
                    <?php
                    $contador = 0;
                    while ($fila = $consultaTodosLosEspectaculos->fetch_assoc()) {
                        if ($contador == 0) {
                            ?>
                            <tr>
                                <?php foreach ($fila as $clavesEspectaculos => $datosEspectaculos) { ?>
                                    <th><?php
                                        //Imprimimos las claves 
                                        print $clavesEspectaculos;
                                        ?></th>
                                <?php } ?>
                            </tr> 
                        <?php } ?>
                        <tr>
                            <?php foreach ($fila as $clave => $datos) { ?>
                                <td>
                                    <?php echo $datos ?>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php $contador++; ?>
                    <?php } ?>
                </table>
                <?php $conexionBD->close(); ?>
                </body>
                </html>
