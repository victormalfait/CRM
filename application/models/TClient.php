<?php

class TClient extends Zend_Db_Table_Abstract
{
	
	protected $_name = 'client';
	protected $_primary = 'idClient';

	protected $_referenceMap = array(
		"Societe" => array(
			"columns" => "idSociete",
			"refTableClass" => "TSociete")
		);
	
}