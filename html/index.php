<?php
/**
 * index.php
 *
 * @package default
 */


?>
<!DOCTYPE html>
<html lang="de-DE" class="no-js">

<?php

/*
 * Autor: Thomas Arend
 * Stand: 30.12.2018
 *
 * Better quick and dirty than perfect but never!
 *
/* Security token to detect direct calls of included libraries. */

$OVCTest = "Started";

include_once "lib/lib.php" ;

include_once "lib/db.php" ;
include_once "lib/vehicle_types.php" ;
include_once "lib/vehicles.php" ;

$DEBUG = FALSE;
$message = "";
$debugmsg = "";

filter_var_array($_POST, FILTER_SANITIZE_SPECIAL_CHARS);


if (array_key_exists('countit', $_POST)) {
	$countit = $_POST['countit'];
}
else {
	$countit = "";
}
$PARAMS = $_POST;

$V = new vehicles () ;
$V->set($PARAMS);

if ( ! empty($countit) and empty($V->vt_id) ) {
	$message .= "No vehicle type.";
} else {

	switch ($countit) {

	case "OK" :
		$message .= $V->add_vehicle() . '<br />';

		break;

	}
}

echo $message;

?>

<head>

	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta http-equiv="expires" content="0">
	<meta http-equiv="cache-control" content="no-cache">
	<meta http-equiv="pragma" content="no-cache">
	<meta name="theme-color" content="#00dd00">
	<meta name="description" content="Open Vehicle Counter">
	<meta name="keywords" lang="de" content="Vehicle,Counter,Passenger">
	<meta name="format-detection" content="telephone=yes">
	<link rel="stylesheet" type="text/css" href="css/style.css">

    <title>Open Vehicle Counter</title>

</head>

<body>

<h1>Vehicle counter</h1>

<main class="container">

<section class="box">
	<h3>Describe vehicle</h3>
	
	<div id="header" class="page-header">

		<div>


			<form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" id="vehicle" >

				<label for="vt_id">Type of vehilce:<br /></label>

				<select id="vt_id" name="vt_id">
				<?php

				$VTList = new vehicle_types();
				$VTList->list(1);
				unset($VTList);

				?>
				</select>

				<br />

				<label for="pax">Number of pax:<br /></label>

				<select id="pax" name="pax">

					<option value="1" >1</option>
					<option value="2" >2</option>
					<option value="3" >3</option>
					<option value="4" >4</option>
					<option value="5" >5</option>
					<option value="6" >&gt;5</option>
					<option value="-1" >Unbekannt</option>

				</select>

				<div class="button" >

					<button id="countit"
						name="countit"
						type="submit"
						value="OK"
						style="color: green; font-weight: bold;">Count vehicle</button>

				</div>
		
			</form>
		
		</div>
		
	</div>

</section>

<section class="box">

	<h3>Liste</h3>

	<?php

	$V->list();

	?>

</section>

</main>

</body>
</html>
