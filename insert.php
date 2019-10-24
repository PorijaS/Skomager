<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'xpo01.skp-dp');
   define('DB_PASSWORD', 'q43zz4qq');
   define('DB_DATABASE', 'xpo01_skp_dp_sde_dk');
   $mysqli = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);


   $navn = mysqli_real_escape_string($mysqli, $_REQUEST['navn']);
   $email = mysqli_real_escape_string($mysqli, $_REQUEST['email']);
   $alder = mysqli_real_escape_string($mysqli, $_REQUEST['alder']);
   $sko = mysqli_real_escape_string($mysqli, $_REQUEST['sko']);

   $sql_e = "SELECT * FROM email WHERE email='$email'";
   $res_e = mysqli_query($mysqli, $sql_e);

   $sql_i = "insert into email (email) values ('$email')";

   if(mysqli_num_rows($res_e) > 0)
   {
     echo "<script type='text/javascript'>alert('Desværre... Email er allerede taget!');</script>";
   }
   else if($mysqli->query($sql_i) == true){
     $lastID = $mysqli->insert_id;
     $sql = "insert into SkoS (ID, navn, email_id, alder, sko) values ('$lastID', '$navn', '$lastID', '$alder', '$sko')";

     $mysqli->query($sql);
     header("Location: index.php");
        exit;
   } else {
     $message = "ERROR: Could not able to execute $sql. " . mysqli.error($mysqli);
     echo "<script type='text/javascript'>alert('$message');</script>";
   }

   mysqli_close($mysqli);
?>
