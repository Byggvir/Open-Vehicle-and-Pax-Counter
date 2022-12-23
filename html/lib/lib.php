<?php
/**
 * lib.php
 *
 * @package default
 * @see db.php
 * @see FahrzeugArt.php
 * @see Zaehlungen.php
 */


global $OVCTest;
isset ($OVCTest) or exit ( "No direct calls!" ) ;

/**
 *
 * @param unknown $id_a
 * @param unknown $id_b
 * @return unknown
 */

function checked($id_a, $id_b) {

	if ( $id_a == $id_b ) {
		return "checked";
	}
	else {
		return "";
	}
}


/**
 *
 * @param unknown $msg
 */

function mydebug($msg) {

	global $debugmsg ;
	$debugmsg .="<p>" . $msg ."</p>";

}

/**
 *
 * @param unknown $b
 * @return unknown
 */

function janein($b) {

	if ($b) {
		return "Ja";
	} else {
		return "Nein";
	};

}


/**
 *
 * @param unknown $datetime
 * @return unknown
 */

function DateTimeDEU( $datetime ) {

	$temp = new DateTime($datetime);
	return $temp->format('d.m.Y H:i');

}

?>
