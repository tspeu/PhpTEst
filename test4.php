<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>test4 UT_8 DWES JM_Banchero</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
    <link rel="stylesheet" type="text/css" href="css/style.css">
    <link rel="stylesheet" type="text/css" href="css/dwes.css">
    <!-- Latest compiled and minified JavaScript -->
    <!-- <script src="js/jquery.min.js"></script> -->
    <!-- <script src="js/bootstrap.min.js"></script> -->
    

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
                        <a href='#'> test4 PROYECTO_8 JM_B  <span class='sr-only'>(current)</span></a>
                    </li>
                    <li><a href='test4.php'>LISTADO PLAYAS DESDE dB MYSQL</a> 
                    <li><a href='altaplaya2.php'>ALTA PLAYA DESDE dB MYSQL</a></li>
                    </li>
                </ul>
            </div>
    </nav>
<div class="container container-fluid">
         <h1 id="encabezado">Listado de playas</h1>
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
                          if (isset($_POST['id'])) 
                             $idSelect = $_POST['id'];
                          try {
                              $opciones =array(PDO::MYSQL_ATTR_INIT_COMMAND=>"SET NAMES utf8");
                              $dwes = new PDO("mysql:host=localhost;dbname=playasdb", "dwes", "abc123.", $opciones);
                              $dwes->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                          }catch (PDOException $e) {
                              $error = $e->getCode();
                              $mensaje = $e->getMessage();
                          }
                    // $sql = "SELECT idMunicipio,nombreMun FROM familia";
                    $sql= "SELECT idMunicipio,nombreMun FROM municipio";
                    $res = $dwes->query($sql);
                        if($res){
                            $value = $res->fetch();
                            while ($value != null) {
                                echo "<option value='${value['idMunicipio']}'>";
                                // if (isset($idSelect) && $idSelect == $value['idMunicipio']){
                                    // echo " selected='true'";  
                                // }
                                
                                echo htmlentities($value['nombreMun'])."</option>";     
                                $value  = $res->fetch();
                            }     

                        }   
                    ?>   
                        </select>
                    </div>
                    <div class="col-md-4">
                                     <!--  name="idSelect"  value="idSelect" -->
                        <button class="btn btn-success" type="submit" 
                            style="width: 50% !important;padding: 5% !important;">enviar</button>
                    </div>
                </div>
            </div>                 
        </form>
    </div>
</div>
        

<div class="container">
 <?php
 include_once('./crud/playa.php');
 include_once('./crud/db.php');

    if (!isset($error) && isset($idSelect)) {
    $sql = <<<SQL
    SELECT playas.idPlaya,idMun,nombre,descripcion,direccion,playaSize,longitud,latitud,imagen
    FROM playas INNER JOIN municipio ON municipio.idMunicipio = playas.idMun
    WHERE playas.idMun='$idSelect'
SQL;

    $resultado = $dwes->query($sql);


    if($resultado) {
        $linea = $resultado->fetch();
            echo '<form id="form"  action="editar.php" method="post"> 
            <div class="panel panel-default">
            <div class="panel-heading">PLAYAS</div>';
            // echo '<table class="table">';
            // echo '<br><tr><th>Elegir un nombre para obtener la descripcion </th>
            // </tr></br>';
            echo  "<div class='list-group list-group-item-info'>";   
            // $listaPlayas =  DB::obtienePlayasMunicipio();
            $index =0;
            $listaPlayas = array();
        while ($linea != null) {
            
            $listaPlayas[$index]=new playa($linea);
            // $arrayname[indexname] = $value;
            // $listaPlayas
            // echo "<option value=".$row_rs_query['id'].">".$row_rs_query['descripcion']."</option>";
            $listaPlayas[$index] =array( 
                    $idPlaya=$linea['idPlaya'],
                    $idMun=$linea['idMun'],
                    $nombre=$linea['nombre'],
                    $direccion=$linea['direccion'],
                    $descripcion=$linea['descripcion'],
                    $playaSize=$linea['playaSize'],
                    $longitud=$linea['longitud'],
                    $latitud=$linea['latitud'],
                    $imagen=$linea['imagen']);

                // $idPlaya=$linea['idPlaya'];
                // $idMun=$linea['idMun'];
                // $nombre=$linea['nombre'];
                // $direccion=$linea['direccion'];
                // $descripcion=$linea['descripcion'];
                // $playaSize=$linea['playaSize'];
                // $longitud=$linea['longitud'];
                // $latitud=$linea['latitud'];
                // $imagen=$linea['imagen'];
            
            // foreach ($listaPlayas as $p) {
                // $p->getIdPlaya();
                // $p->getNombrePlaya();
                // $idPlaya->getIdPlaya();
                // $nombre->;
            // foreach($listaPlayas as $pl){
            //     $pl->muestraIdPlaya();
            // }

            echo 
            "<input type='hidden' name='idPlaya' value='$idPlaya'/>";
            // "<input type='hidden' name='idEdit' value='$p->getIdPlaya()'/>";
            // "<input type='hidden' name='idEdit' value='.$listaPlayas[$index]->getIdPlaya().'/>";

            echo
            // "<button type='submit' aria-label='Right Align' class='list-group-item' 
            // value='nombre' name='nombre'>$nombre"$listaPlayas[$index]->getNombrePlaya()  $nombre;
                "<button type='submit' aria-label='Right Align' class='list-group-item'> $nombre
                <span class='badge'>$index</span></button>";
                
            echo    
            "<button class='btn btn-info' type='submit'>Seleccionar</button> 
            <span class='badge'>$idPlaya</span>";  
            // "</button>
            // <button class='btn btn-info' type='submit' value='idEdit' 
            // name='idEdit'>Select</button>";  

           
            // }
            $linea = $resultado->fetch();
            $index++;
        
        }
            echo '</div></form> </div>';
    //   </table>
    }


        }
/*   <th>DESCRIPCIÓN </th><th>DIRECCION</th><th>TAMAÑO</th><th>LONGITUD</th><th>LATITUD
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

                // echo "<input type='text' name='idEdit' value='$idPlaya'/>";
                // echo "<tr><td><button  class=' btn-primary btn-lg ' type='submit' value='idEdit' name='edit'><h2>$nombre</h2></button></td>";
        
                //         echo  "<td>$descripcion</td>";
        //         echo  "<td>$direccion;</td>";
        //         echo  "<td>$playaSize;</td>";
        //         echo  "<td>$longitud;</td>";
        //         echo  "<td>$latitud;</td>";
        //         // echo  "<td><img src='.base64_encode($imagen);'/></td>";
        // echo '<img src="data:image/jpeg;base64,'.base64_encode($imagen).'" style="width="50px; height="50px;"/>';
               
        
        // echo "<td><button class='btn btn-info' type='submit' value='idEdit' name='edit'>Select</button></td></tr>";
       
?>   
</div>

    <br><div class="spacio"></div>
    <div class="well well-sm footer-info text-primary">
        <p>DWE 2017-UT8 JM_Banchero</p>
    </div>
</body>
</html>
