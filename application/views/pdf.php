<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title><?= $title_pdf; ?></title>
    <style>
    #table {
        font-family: "Trebuchet MS", Arial, Helvetica, sans-serif;
        border-collapse: collapse;
        width: 100%;
    }

    #table td {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: right;
    }

    #table th {
        border: 1px solid #ddd;
        padding: 8px;
    }

    #table tr:nth-child(even) {
        background-color: #fff;
    }

    #table tr:hover {
        background-color: #ddd;
    }

    #table th {
        padding-top: 10px;
        padding-bottom: 10px;
        text-align: right;
        background-color: #4CAF50;
        color: white;
        text-align: center;
    }

    #table td.left {
        border: 1px solid #ddd;
        padding: 8px;
        text-align: left;
    }

    tr.title {
        text-align: center;
    }
    </style>
</head>

<body>

    <?php
	//Setting database
	$db_host = 'localhost'; // Name Server
	$db_user = 'root'; // User Server
	$db_pass = ''; // Password Server
	$db_name = 'ecommerce'; // Name Database

	//Datetime
	// date_default_timezone_set('Asia/Jakarta');
	// $datetime_variable = new DateTime(); // Datetime


	//connection database
	$conn = mysqli_connect($db_host, $db_user, $db_pass, $db_name);
	if (!$conn) {
		die('Gagal terhubung MySQL: ' . mysqli_connect_error());
	}
	//Select table name
	$sql = 'SELECT order_date, total_price FROM orders';

	$query = mysqli_query($conn, $sql);

	if (!$query) {
		die('SQL Error: ' . mysqli_error($conn));
	}


	//Tables
	echo '<div style="text-align:center">
				<h3>INCOMES</h3>
			</div>
			<table id="table">
				<thead>
					<tr>
					<th>MONTH</th>
						<th>TOTAL INCOME</th>
					</tr>
				</thead>
				<tbody>';
	//Row tables
	$total = 0;
	while ($row = mysqli_fetch_array($query)) {
		$total += $row['total_price'];
		$date = $row['order_date'];
		$newDate = date('F', strtotime($date));

		echo '<tr>
					<td class="left">' . $newDate . '</td>
					<td>' . 'Rp ' . number_format($row['total_price'], 0, ',', '.') . '</td> 
			</tr>';
	}
	echo '
	<tr>
	<td>' . '</td>
						<td>' . 'Total : Rp ' . number_format($total, 0, ',', '.') . '</td>

	</tr>
			</tbody>
		</table>';

	// Apakah kita perlu menjalankan fungsi mysqli_free_result() ini? baca bagian VII
	mysqli_free_result($query);

	// Apakah kita perlu menjalankan fungsi mysqli_close() ini? baca bagian VII
	mysqli_close($conn);
	?>
</body>


</html>
