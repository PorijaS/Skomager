<?php
   define('DB_SERVER', 'localhost');
   define('DB_USERNAME', 'xpo01.skp-dp');
   define('DB_PASSWORD', 'q43zz4qq');
   define('DB_DATABASE', 'xpo01_skp_dp_sde_dk');
   $mysqli = mysqli_connect(DB_SERVER,DB_USERNAME,DB_PASSWORD,DB_DATABASE);
?>
<head>
	<title>Brugere</title>

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" type="text/css" href="index.css">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
</head>
<body>
	<?php
		if($_GET['type'] == 'graf')
		{
			echo "<h1>Graf</h1>
			<div class='center'><a href='index.php'><input type='submit' style='margin-top: 10px;' class='btn btn-success' value='Vis Brugere'></a></div>

			<div id='piechart'></div>";
		}
		else if($_GET['type'] == 'indtast')
		{
    echo "<h1>Indtast</h1>

    <div id=login-box>

    <div class=left-box>

    <form class=form2 action=insert.php method=post>
    <input type=text name=navn placeholder=Navn>
    <input type=email name=email placeholder=E-Mail>
    <input type=text name=alder placeholder=Alder>
    <input type=text name=sko placeholder=Sko-Størrelse>
    <br><br>
    <input type=submit value=Indsæt>
    </form>
    <br>
    <a href='index.php'><input type='submit' style='margin-top: 10px;' class='btn btn-success' value='Vis Brugere'></a>

    </div>
    <div class=right-box>
    </div>
    </div>";

    }
    else
    {
			echo "<h1>Brugere Oplysninger</h1>
			<div class='center'><a href='index.php?type=graf'><input type='submit' style='margin-top: 10px;' class='btn btn-success' value='Vis Graf'></a></div>
      <div class='center'><a href='index.php?type=indtast'><input type='submit' style='margin-top: 10px;' class='btn btn-success' value='Indtast'></a></div>
			<p class='txtcenter copy'>
			  <table style='margin-top: 10px;' id='customers'>
			  <tr>
			  <th style='width: auto'>Navn</th>
			  <th style='width: auto'>Email</th>
			  <th style='width: auto'>Alder</th>
			  <th style='width: auto'>Sko Størrelse</th>
			  </tr>";

			$sqlProjects = "SELECT * FROM SkoS";

			$resultProjects = mysqli_query($mysqli, $sqlProjects);

			while( $row = $resultProjects->fetch_assoc())
			{
				echo "<tr>
					  <td>".$row['navn']."</td>
					  <td>".$row['email']."</td>
					  <td>".$row['alder']."</td>
					  <td>".$row['sko']."</td>
				</tr>";
			}

			echo "</table><script src='index.js'></script>";
		}
	?>

	<script type="text/javascript">
		// Load google charts
    google.charts.load('current', {'packages':['corechart']});
		google.charts.setOnLoadCallback(drawChart);

		// Draw the chart and set the chart values
		function drawChart() {
		  var data = google.visualization.arrayToDataTable([
		  ['Størrelser', 'Sko'],
		  <?php
			$skostr = array();

			$sqlProjects = "SELECT * FROM SkoS";

			$resultProjects = mysqli_query($mysqli, $sqlProjects);

			while( $row = $resultProjects->fetch_assoc())
			{
				$skostr[$row['sko']][0] = $row['sko'];
				$skostr[$row['sko']][1]++;
			}

			$currentIteration = 0;

			foreach ($skostr as $value)
			{
				$currentIteration++;

				if($currentIteration >= count($skostr))
				{
					echo "['".$value[0]."', ".$value[1]."]";
				}
				else
				{
					echo "['".$value[0]."', ".$value[1]."],\n";
				}
			}
		  ?>
		]);

		  // Optional; add a title and set the width and height of the chart
		  var options = {'title':'Sko Størrelser', 'width':950, 'height':800};

		  // Display the chart inside the <div> element with id="piechart"
      var chart = new google.visualization.PieChart(document.getElementById('piechart'));
		  chart.draw(data, options);
		}
	</script>
</body>
