<?php
/**
 * vehicles.php
 *
 * @package default
 */


/*
 * Autor: Thomas Arend
 * Stand: 22.12.2022
 *
 * Better quick and dirty than perfect but never!
 *
 * Securety check: No direct calls are allowed
 */

global $OVCTest;

isset($OVCTest) or exit ( "No direct calls!" ) ;

include_once "db.php";
include_once "lib.php";

/* Retrieve the results fom database and print out the rows  */

class vehicles extends DBtable {

	public $id   = 0;
	public $time_of_observation = 0;
	public $vt_id = 1;
	public $pax  = -1;

	/*
    Create object.
 */

	/**
	 *
	 */
	public function __construct() {

		parent::__construct();

	}


	/**
	 *
	 * @param array   $arr
	 */

	public function set(array $arr) {

		if (array_key_exists('id', $arr)) {
			$this->id = trim( $arr['id']);
		} else {
			$this->id = NULL;
		}

		if (array_key_exists('time_of_observation', $arr)) {
			$this->time_of_observation = trim( $arr['time_of_observation']);
		} else {
			$this->time_of_observation = NULL;
		}

		if (array_key_exists('vt_id', $arr)) {
			$this->vt_id = trim( $arr['vt_id']);
		} else {
			$this->vt_id = NULL;
		}

		if (array_key_exists('pax', $arr)) {
			$this->pax = trim( $arr['pax']);
		} else {
			$this->pax = NULL;
		}

	}


	/**
	 *
	 * @param unknown $reset (optional)
	 */

	function copyrow($reset = FALSE) {

		parent::copyrow();

		$this->set($this->rres);

	}


	/**
	 *
	 * Look up a record and 
	 * @param unknown $id
	 */

	function look_up($id) {

		if (is_null($id) or !is_numeric($id)) {

			$SQL = 'select * from vehicles limit 1;';

		} else {

			$SQL = 'select * from vehicles where id =' . $id . ' limit 1;';

		}

		if ($this->select($SQL)) {

			$this->fetchrow(TRUE);

		}

	}


	/**
	 *
	 * @return unknown
	 */


	/**
	 *
	 * @return unknown
	 *
	 */
	function add_vehicle() {

		/* 
		 * id is an auto increment keyvalue
		 * 
		 * time_of_observation default is current time
		 * 
		 */
		
		$INSERT = 'insert into vehicles (vt_id, pax) values('
			. $this->vt_id
			. ' , ' . $this->pax
			. ' );' ;
		$this->insert($INSERT);
	
	}

	/**
	 *
	 */
	
	function list ( $listlimit = 5) {

		$SQL = 'select V.id as id'
		. ', V.time_of_observation as time_of_observation'
		. ', VT.vehicle_type as vehicle_type'
		. ', case when V.pax > 5 then ">5"'
		. ' else'
			. ' case when V.pax = -1'
			. ' then "?"'
			. ' else V.pax'
		. ' end end as pax'
		. ' from vehicles as V'
		. ' join vehicle_types as VT'
		. ' on V.vt_id = VT.id'
		. ' order by V.time_of_observation desc'
		. ' limit ' . $listlimit . ' ;';
		
		if ( $this->select($SQL) ) {


			// Table header
?>

<div class="table-wrapper contact-wrapper">

<table>
<thead>
<tr>
<th id="thselect" class="VehicleId">
Id
</th>
<th id="thTOO" class="TiemOfObservation">
Zeitpunkt
</th>
<th id="thArt" class="VehicleType">
Art
</th>

<th id="thPax" class="Pax">
Insassen
</th>
</tr>
</thead>
<tbody>

<?php

			while ($this->fetchrow()) {

				/* Table of Records */

				print ( '<tr>' );
				print ( '<td class="center result radiobutton">' );
				print ( '<input type="radio" id="Vehicle'
					. $this->id
					. '" name="Vehicle" value="'
					. $this->id
					. '" '
					. '>' ) ;

				print ( "</td>" );

				print ( '<td class="left result">' . $this->data['time_of_observation'] . '</td>' );
				print ( '<td class="left result">' . htmlentities($this->data['vehicle_type']) . '</td>' );
				print ( '<td class="left result">' . $this->data['pax'] . '</td>' );
				print ( "</tr>" );

			} /* end while */
?>

</tbody>
</table>
</div>

<?php
		} /* end if */
		else {
			print ( "<p>No vehicles found.</p>" );
		}

	} /* end of contact.list */


}


?>
