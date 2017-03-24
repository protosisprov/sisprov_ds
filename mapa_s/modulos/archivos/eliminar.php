 <?php
//print_r($_POST);
  echo $_FILES['archivo']['name'] . "<br>";
//  echo "Tipo: " . $_FILES['archivo']['type'] . "<br>";
//  echo "Tamaño: " . ($_FILES["archivo"]["size"] / 1024) . " kB<br>";
//  echo "Carpeta temporal: " . $_FILES['archivo']['tmp_name'];
//  echo ("subidas/" . $_POST['sector']."-".$_POST['estado'].".pdf");
   unlink("subidas/" . $_POST['sector']."-".$_POST['estado'].".pdf");
?>