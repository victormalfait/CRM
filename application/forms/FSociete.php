<?php

class FSociete extends Zend_Form
{
 
	public function init()
	{
		//parametrer le formulaire
		$this->setName('societe');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FSociete');

		// Descativer les decorateurs par defaut
		$this->clearDecorators();

		// creation du décorateur pour les elements
		$decorators = array(
		    array('ViewHelper'),
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

		$eNom = new Zend_Form_Element_Text('societe');
		$eNom		->setLabel('Société')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->setDecorators($decorators);


		$eAdresse = new Zend_Form_Element_Text('adresse');
		$eAdresse	->setLabel('Adresse')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addFilter('StripTags')
					->addFilter('StringTrim')
		            ->setDecorators($decorators);


		$eCodePostal = new Zend_Form_Element_Text('codePostal');
		$eCodePostal	->setLabel('Code Postal')
						->setRequired(true)
						->setAttrib('required', 'required')->setAttrib('maxlength', '5')
						->addFilter('StripTags')
						->addFilter('StringTrim')
			            ->setDecorators($decorators);


		$eVille = new Zend_Form_Element_Text('ville');
		$eVille	->setLabel('Ville')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addFilter('StripTags')
					->addFilter('StringTrim')
		            ->setDecorators($decorators);		            		            


		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit 	->setAttrib('id', 'submitbutton')
					->setLabel('Enregistrer');


		$eAnnuler = new Zend_Form_Element_Reset('annuler');
		$eAnnuler 	->setLabel('Annuler')
					->setAttrib('id', 'annulerbutton')
					->setAttrib('class', 'close');


		$elements = array($eNom, $eAdresse,$eCodePostal, $eVille, $eSubmit, $eAnnuler);
		$this->addElements($elements);

		// Ajout du decorateur au formulaire
		$this->setDecorators($decoratorsForm);
	}
 
	public function getSociete($search)
	{
        // charger le model
        $tableSociete = new TSociete;

        $search = $search.'%';
        $societes = $tableSociete 	->select()
                                    ->from($tableSociete, array('idSociete','societe'))
                                    ->where('societe LIKE ?', $search);
        
        $societesFind = $tableSociete->fetchAll($societes);

		return $societesFind;
	}

}