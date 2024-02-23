<?php 


$mysqli = @new mysqli('localhost', 'wi180151_md', 'Chacra2018', 'wi180151_md');

if (isset($_POST['enviar']))
{
	
  $filename=$_FILES["file"]["name"];
  $info = new SplFileInfo($filename);
  $extension = pathinfo($info->getFilename(), PATHINFO_EXTENSION);

   if($extension == 'csv')
   {
	$filename = $_FILES['file']['tmp_name'];
	$handle = fopen($filename, "r");

	while( ($data = fgetcsv($handle, 1000, ",") ) !== FALSE )
	{
      $timestamp = strtotime($data[5]);
  
      $q = "INSERT INTO tachos (idvariedad, codigo, subcodigo, fechaalta, destino, inactivo) VALUES (
		".$data[1].",".$data[3].",'".$data[4]."','".date("Y-m-d", $timestamp)."',".$data[6].",".$data[7]."
      )";
   echo $q;
   echo"<br>";
	$mysqli->query($q);
   }

      fclose($handle);
   }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <title>Importación</title>
</head>
<body>
	
<form enctype="multipart/form-data" method="post" action="">
   CSV File:<input type="file" name="file" id="file">
   <input type="submit" value="Enviar" name="enviar">
</form>

</body>
</html>