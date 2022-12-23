<?php
/**
 *vehicle_types.php
 *
 * @package default
 */


/*
 * Autor: Thomas Arend
 * Stand: 23.12.2022
 *
 * Better quick and dirty than perfect but never!
 *
 * Securety check: No direct calls are allowed
 */

global $OVCTest;

isset($OVCTest) or exit ( "No direct calls!" ) ;

include_once "db.php";
include_once "lib.php";

/*
+---------------+------------+------+-----+---------+----------------+
| Field         | Type       | Null | Key | Default | Extra          |
+---------------+------------+------+-----+---------+----------------+
| id            | BIGINT(20) | NO   | PRI | NULL    | auto_increment |
| Art           | CAHR(32)   | YES  | MUL | NULL    | Default "Pkw"  |
+---------------+------------+------+-----+---------+----------------+
*/

class vehicle_types extends DBtable {

	public $id            = 1 ;
	public $vehicle_type  = "Pkw" ;

	/**
	 *
	 */

	public function __construct() {

		parent::__construct();
	}


	/**
	 *
	 * @param unknown $reset (optional)
	 */

	function copyrow($reset = FALSE) {

		parent::copyrow();

		$this->id = $this->rres['id'];
		$this->vehicle_type = $this->rres['vehicle_type'];


	}



	/**
	 *
	 * @param unknown $id
	 */
	
	function look_up($id) {

		if (is_null($id) or !is_numeric($id)) {
			$SQL = 'select * from vehicle_types order by id limit 1;';
		} else {
			$SQL = 'select * from vehicle_types where id =' . $id . ' limit 1;';
		}
		if ($this->select($SQL)) {
			$this->fetchrow(TRUE);
		}

	}


	/**
	 *
	 * @return unknown
	 */
	function insert_into_db() {

		$SQL = 'insert into vehicle_types '
			. ' values ( NULL'
			. ','  . $this->vehicle_type
			. ');';


		if ($this->conn->query($SQL) === TRUE) {
			$msg = "Data set created.";
		} else {
			$msg = "Table error: Data set was not created.";
		}

		return $msg;

	}


	/**
	 *
	 */
	function list ($vt_id) {
		
		$SQL = 'select VT.id as id ,'
			. ' VT.vehicle_type as vehicle_type'
			. ' from vehicle_types as VT order by VT.id;';
		
		if ( $this->select($SQL) ) {

			while ($this->fetchrow()) {

				/* Table of Records */

				print ( '<option id="VehicleType'
					. $this->id
					. '" name="VehicleType" value="'
					. $this->id
					. '" '
					.  checked($this->id , $vt_id ));

				print ( ' >' . htmlentities($this->vehicle_type) . '</option>' . PHP_EOL ) ;


			} /* end while */
?>

</tbody>
</table>
</div>

<?php
		} /* end if */
		else {
			print ( "<p>No vehicle types found.</p>" );
		}

	} /* end of vehicle_types.list */


}


?>
