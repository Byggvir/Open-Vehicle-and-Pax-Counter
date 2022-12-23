<?php
/**
 * db.php
 *
 * @package default
 * @see db.php
 */


/*
 * Autor: Thomas Arend
 * Stand: 23.12.2022
 *
 * Better quick and dirty than perfect but never!
 *
 * Security token to detect direct calls of included libraries. */

global $OVCTest;

isset($OVCTest) or exit ( "No direct calls!" ) ;

$SITE   = 'localhost';

$DBHOST = "localhost";
$DBDB   = "ovc";
$DBUSER = "ovc";

/* Please change password, here and in setup.sql */

$DBPASS = "PleaseChangePassword'";

?>
