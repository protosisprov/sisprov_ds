 <?php
//print_r($_POST);
if ($_FILES['archivo']["error"] > 0)
  {
  echo "Error: " . $_FILES['archivo']['error'] . "<br>";
  }
else
  {
  echo $_FILES['archivo']['name'] . "<br>";
//  echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
//  echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
//  echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
   move_uploaded_file($_FILES['archivo']['tmp_name'],"subidas/" . $_POST['sector']."-".$_POST['estado'].".pdf");
   }
?>