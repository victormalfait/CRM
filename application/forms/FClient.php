<?php

class FClient extends Zend_Form
{

	private $idUtilisateur;
	private $controllerAction;
 
	public function init()
	{
		//parametrer le formulaire
		$this->setName('client');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FClient');

		// Descativer les décorateurs par defaut
		$this->clearDecorators();

		// creation du décorateur pour les elements
		$decorators = array(
		    array('ViewHelper'),
		    array('Errors'),
		    array('Label', array('class' => 'label')),
		    array('HtmlTag', array('tag' => 'li'))
		);

		// creation du décorateur pour les elements Jquery
		$decoratorsJquery = array(
		    array('UiWidgetElement'),
		    array('Errors'),
		    array('Label', array('class' => 'label')),
		    array('HtmlTag', array('tag' => 'li'))
		);

		// creation d'un decorateur pour le formulaire
		$decoratorsForm = array(
			'FormElements',
			array('HtmlTag', array('tag' => 'ul')),
			array(
				array('DivTag' => 'HtmlTag'),
				array('tag' => 'div', 'class' => 'div-form')
			),
			'Form'
		);

		$eNom = new Zend_Form_Element_Text('nom');
		$eNom		->setLabel('Nom')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->addValidator('notEmpty')
		            ->setDecorators($decorators);

		$ePrenom = new Zend_Form_Element_Text('prenom');
		$ePrenom	->setLabel('prenom')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->addValidator('notEmpty')
		            ->setDecorators($decorators);

		$eEmail = new Zend_Form_Element_Text('email');
		$eEmail		->setLabel('E-mail')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->addValidator('notEmpty')
		            ->setDecorators($decorators);
       
 /******************************* JQuery Autocomplete + hidden (recuperation d'id) ***********************************/
	   	$baseurl = Zend_Controller_Front::getInstance()->getBaseUrl();

	    $eSociete = new ZendX_JQuery_Form_Element_AutoComplete('societe');
	    $eSociete	->setLabel('Société')
			      	->setRequired(true)
			      	->setAttrib('required', 'required')
			      	->setFilters(array('StripTags'))->addFilter('StringTrim')
		            ->addValidator('notEmpty')
		            ->setDecorators($decoratorsJquery)
			      	->setJQueryParams(array('source' => $baseurl.'/client/searchsociete',
			      							'select' => new Zend_Json_Expr(
                                                    "function(event, ui) {
                                                        $('#idSociete').val(ui.item.id)
                                                    }"
											)));


        $eIdSociete = new Zend_Form_Element_Hidden('idSociete');
        $eIdSociete->setDecorators($decorators);
/************************************************************************************************/

		$eTelephone = new Zend_Form_Element_Text('telephone');
		$eTelephone	->setLabel('Téléphone')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')->setAttrib('maxlength', '10')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->addValidator('notEmpty')
		            ->setDecorators($decorators);


		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit 	->setLabel('Valider')
					->setAttrib('id', 'submitbutton');
					

		$eAnnuler = new Zend_Form_Element_Reset('annuler');
		$eAnnuler 	->setLabel('Annuler')
					->setAttrib('id', 'annulerbutton')
					->setAttrib('class', 'close');
					

		// Ajout des element au formulaire
		$elements = array($eNom, $ePrenom, $eEmail, $eSociete, $eIdSociete, $eTelephone, $eSubmit, $eAnnuler);
		$this->addElements($elements);

		// Ajout du decorateur au formulaire
		$this->setDecorators($decoratorsForm);

/*===========================PRÉ REMPLISSAGE DU FORMULAIRE==============================*/
		// on recupere la valeur de l'id utilisateur
		$idClient = $this->getidClient();

		// si on a une valeur ...
		if (isset ( $idClient ) && $idClient != "") {

			// ... on charde le model de base de donnée Client,
			$tableClient = new TClient ( );
			// on envoi la requete pour recupere les informations de l'utilisateur
            $client = $tableClient  ->find($idClient)
                                    ->current();

            // Recherche des infos sur la societe du client
            $societe = $client->findParentRow('TSociete');

			// si on a un retour
			if ($client != null) {
				// on peuple le formulaire avec les information demandé
				$client = $client->toArray ();
				$societe = $societe->toArray ();
				$this->populate ( $client );
				$this->populate ( $societe );
			}
			
			// on change le label du bouton
			$eSubmit->setLabel ( 'Modifier' );
		}

	}


	/**
	 * @param $idClient the $idClient to set
	 */
	public function setidClient($idClient) {
		$this->idUtilisateur = $idClient;
	}

	/**
	 * @return the $idClient
	 */
	public function getidClient() {
		return $this->idUtilisateur;
	}
 
}