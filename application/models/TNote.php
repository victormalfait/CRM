<?php

class TNote extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'note';
	protected $_primary = 'idNote';

	protected $_referenceMap = array(
		"Client" => array(
			"columns" => "idClient",
			"refTableClass" => "TClient")
		);
}
