<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dwes.css">
    <!-- Latest compiled and minified JavaScript -->
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    

    <link type="image/x-icon" href="img/ghost.png" rel="shortcut icon" />
</head>

<body >
    <nav class='navbar navbar-default'>
            <div class='container-fluid'>
                <div class='navbar-header'>
                    <a class='navbar-brand'> <img alt='Brand' src='img/ghost.png'></a>
                </div>
                <ul class='nav navbar-nav'>
                    <li class='active'>
                        <a href='#'>  PROYECTO_8 JM_B  <span class='sr-only'>(current)</span></a>
                    </li>
                    <li><a href='#'>LISTADO PLAYAS DESDE dB MYSQL</a> 
                    </li>
                </ul>
            </div>
    </nav>
    <?php
        if (isset($_POST['idMunicipio'])) $idSelect = $_POST['idMunicipio'];
        try {
            $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
            $coneccion = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones);
            $coneccion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch (PDOException $e) {
            $error = $e->getCode();
            $mensaje = $e->getMessage();
        }

    ?>
<div class="container container-fluid">
         <h1 id="encabezado">Tarea 3: Listado de playas</h1>
    <div> 
        <form id="form" name="formulario" action="<?php $_SERVER['PHP_SELF'] ?>" method="post">

            <div class="panel panel-info tn-group">       
                <div class="row">
                <div class="col-md-4">
                    <h3 style="padding: 2% !important;">Seleccione un Municipio</h3>
                </div>                  
                    <div class="col-md-4 ">
                        <select name="id" id="id" style=" width: 100% !important;
                        height: 100% !important;padding: 8% !important;
                        font-size: 18px;text-align: center !important;
                        background-color: #EEEEEE;">
                <?php 
                    $sql= "SELECT * FROM municipio ";
                    $res = $coneccion->query($sql);
                        if($res){
                            $value = $res->fetch();
                            while ($value != null) {
                                echo "<option value='${value['idMunicipio']}'>";
                                if (isset($idSelect) && $idSelect == $value['idMunicipio']){
                                    // echo " selected='true'";  
                                }
                                
                                echo htmlentities($value['nombreMun'])."</option>";     
                                $value  = $res->fetch();
                            }     
                            /*   <select name="idioma">
                                    <option value="español">Español</option>
                                    <option value="ingles">inglés</option>
                             </select> */
                        }   
                ?>  
                        </select>
                    </div>
                    <div class="col-md-4">
                        <button class="btn btn-success" type="submit"  name="enviar" 
                            style="width: 50% !important;padding: 5% !important;">enviar</button>
                    </div>
                </div>
            </div>                 
        </form>
    </div>
</div>
        

<div class="container">
 <?php
        if (!isset($error) && isset($idSelect)) {
        $sql = <<<SQL
        SELECT playas.*
        FROM playas INNER JOIN municipio ON municipio.idMunicipio = playas.idMun
        WHERE playas.idMun='$idSelect'
SQL;
        $resultado = $coneccion->query($sql);
        if($resultado) {
            $linea = $resultado->fetch();

                echo    '<form id="form"  action="editar2.php" method="post"> 
                        <div class="panel panel-primary">
                        <div class="panel-heading">PLAYAS</div>';
                echo   '<table class="table">';

            while ($linea != null) {
               
                $idPlaya=$linea['idPlaya'];
                $idMun=$linea['idMun'];
                $nombre=$linea['nombre'];
                $direccion=$linea['direccion'];
                $descripcion=$linea['descripcion'];
                $playaSize=$linea['playaSize'];
                $longitud=$linea['longitud'];
                $latitud=$linea['latitud'];
                $imagen=$linea['imagen'];

                echo "<input type='text' name='idPlaya' value='$idPlaya'/>";
                echo "<tr><td><button  class='btn-primary btn-lg' t><h2>$nombre</h2></button></td>";
                    
                echo "<td><button class='btn btn-info' type='submit' value='idPlaya' name='edit'>Select</button></td></tr>";
             
                $linea = $resultado->fetch();

            }
            echo '</table></form> </div>';
          }
        }
 /*   
<th>DESCRIPCIÓN </th><th>DIRECCION</th><th>TAMAÑO</th><th>LONGITUD</th><th>LATITUD
</th><th>IMAGEN</th>*/           
/*idPlaya
idMun
nombre
descripcion
direccion
playaSize
longitud
latitud
imagen */
// ype='submit' value='idEdit' name='edit'
//         echo  "<td>$descripcion</td>";
//         echo  "<td>$direccion;</td>";
//         echo  "<td>$playaSize;</td>";
//         echo  "<td>$longitud;</td>";
//         echo  "<td>$latitud;</td>";
//         // echo  "<td><img src='.base64_encode($imagen);'/></td>";
// echo '<img src="data:image/jpeg;base64,'.base64_encode($imagen).'" style="width="50px; height="50px;"/>';   

// echo  "<input type='hidden' name='idEdit' value='$idPlaya'/>
//         <tr>
//         <div class='list-group list-group-item-info'>

//         <button type='submit' aria-label='Right Align' class='list-group-item' value='nombre' name='nombre'>$nombre
//         <span class='badge'>$idPlaya</span>

//         </button>
//         </div></tr>";

?>   
</div>

    <br><div class="spacio"></div>
    <div class="well well-sm footer-info text-primary">
        <p>DWE 2017-UT8 JM_Banchero</p>
    </div>
</body>
</html>
