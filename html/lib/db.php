<?php
/**
 * db.php
 *
 * @package default
 * @see FahrzeugArt.php
 * @see Zaehlungen.php
 */


/*
 * Autor: Thomas Arend
 * Stand: 22.12.2022
 *
 * Better quick and dirty than perfect but never!
 *
 * Security token to detect direct calls of included libraries. */

global $OVCTest;

isset($OVCTest) or exit ( "No direct calls!" ) ;

include_once "lib.php";
include_once "config.php";


class DBtable {

	public $data = array();

	public $conn = NULL;
	protected $qres = NULL;
	protected $rres = NULL;
	protected $num_rows = NULL;
	//
	// Diese Werte müssen an die Installation angepasst werden!
	//


	/**
	 *
	 */
	function __construct() {
		global $DBHOST;
		global $DBDB;
		global $DBUSER;
		global $DBPASS;

		$this->conn = new mysqli(
			$DBHOST
			, $DBUSER
			, $DBPASS
			, $DBDB )
			or die();
	}





	/**
	 *
	 */

	function __destructor() {

		$this->conn->close() ;

	}

	/**
	 *
	 * @param unknown $reset (optional)
	 */

	function copyrow($reset = FALSE) {

		if ( is_null($this->rres) !== TRUE ) {

			$reset && ($this->data = array());

			foreach ($this->rres as $key => $value) {

				$this->data[$key] = $this->rres[$key];
			}
		}
	}


	/**
	 *
	 * @param unknown $reset (optional)
	 * @return unknown
	 */

	function fetchrow($reset = FALSE) {

		if (! empty($this->qres)) {
			if ($this->rres = $this->qres->fetch_assoc()) {
				$this->copyrow($reset);
				return TRUE;
			} else {
				return FALSE;
			}
		} else {
			return FALSE;
		}
	}


	/**
	 *
	 * @return unknown
	 */
	
	public function is_connected() {
	
		if ($this->conn->connect_errno) {

			echo "Sorry, this website is experiencing problems.";

			// Something you should not do on a public site, but this example will show you
			// anyways, is print out MySQL error related information -- you might log this
		
			echo "Error: Failed to make a MySQL connection, here is why: \n";
			echo "Errno: " . $this->conn->connect_errno . "\n";
			echo "Error: " . $this->conn->connect_error . "\n";
			return FALSE;
			
			// You might want to show them something nice, but we will simply exit
		
			
		} else {
			
			return TRUE;
		}
		
	}


	/**
	 *
	 * @param unknown $SQL (optional)
	 * @param unknown $PRE (optional)
	 * @return unknown
	 */
	
	public function select( $SQL = 'select 1;', $PRE = "set @i=0;" ) {

		if (! is_null($this->qres)) {
			$this->qres->close();
		}
		if (preg_match("#^select .*#i", $SQL, $matches)) {

			$this->qres = $this->conn->query($PRE);
			$this->qres = $this->conn->query($SQL);
			if (! is_null($this->qres)) {
				$this->num_rows = $this->qres->num_rows;
			} else {
				$this->num_rows = 0;
			}
			return ! is_null($this->qres) and $this->qres->num_rows > 0;
		} else {
			$this->data = array('Error' => $SQL);
			return FALSE;
		}

	}



	/**
	 *
	 * @param unknown $SQL
	 * @return unknown
	 */
	
	public function update($SQL) {

		/*
		 * Test if $SQL is a UPDATE command 
		 *
		 * SQL syntax ist not not checked, errors will crash the application
		 * 
		 */

		if (preg_match("#^update .*;$#i", $SQL, $matches)) {
		
			return $this->conn->query($SQL) === TRUE;

		} else {

			return FALSE;

		}

	}

	/**
	 *
	 * Insert values into a table
	 * 
	 * @param unknown $SQL
	 * @return unknown
	 */
	
	public function insert($SQL) {
		
		/*
		 * Test if $SQL is a INSERT command 
		 *
		 * SQL syntax ist not not checked, errors will crash the application
		 * 
		 */
		
		preg_match("#^insert  *into .*;$#i", $SQL, $matches);
		
		if ($SQL == $matches[0]) {

			return $this->conn->query($SQL) === TRUE;

		} else {

			return FALSE;

		}

	}

	/**
	 *
	 * @param unknown $SQL
	 * @return unknown
	 */
	
	public function delete($SQL) {

		/*
		 * Test if $SQL is a DELETE command 
		 *
		 * SQL syntax ist not not checked, errors will crash the application
		 * 
		 */

		preg_match("#^delete  *from .*;$#i", $SQL, $matches);

		if ($SQL == $matches[0]) {

			$this->conn->query($SQL);
			return $this->conn->affected_rows>0;

		} else {

			return FALSE;

		}

	}


	/**
	 *
	 * write table into a CSV file
	 * 
	 * @param unknown $SQL (optional)
	 */

	public function write_csv($SQL='select 1;') {

		$output = fopen('php://output', 'w');

		$this->select($SQL);
		// loop over the rows, outputting them
		while ($this->fetchrow()) {

			fputcsv($output, $this->data);

		}

	}

}

?>
