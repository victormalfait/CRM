<?php

class FFiltre extends Zend_Form
{
 
	public function init()
	{
		//parametrer le formulaire
		$this->setName('filtre');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FFiltre');

		// Descativer les decorateurs par defaut
		$this->clearDecorators();

		// creation du décorateur pour les elements
		$decorators = array(
		    array('ViewHelper'),
		    array('Errors'),
		    array('Label', array('style' => 'display:none;')),
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

		$array = 
		$eDepartement = new Zend_Form_Element_Select('departement');
		$eDepartement	->setLabel('Departement')
			            ->addMultiOptions(array('first' => 'Département', 'Département' => array('02' => 'Aisne', '60' => 'Oise', '80' => 'Somme')))
			        	->setRequired(true)
			        	->setAttrib('required', 'required')
			        	->setAttrib('class', 'select')
			            ->addFilter('StripTags')
			            ->addFilter('StringTrim')
			            ->setDecorators($decorators);


		$eVille = new Zend_Form_Element_Select('ville');
		$eVille		->setLabel('Ville')
					->addMultiOptions(array('first' => 'Ville', 'Ville' => array('Amiens' => 'Amiens', 'Creil' => 'Creil', 'Saint-Quentin' => 'Saint-Quentin')))
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
			        ->setDecorators($decorators);


		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit 	->setAttrib('id', 'submitbutton')
					->setLabel('Valider');


		$eAnnuler = new Zend_Form_Element_Reset('annuler');
		$eAnnuler 	->setLabel('Annuler')
					->setAttrib('id', 'annulerbutton')
					->setAttrib('class', 'close');

		$elements = array($eDepartement, $eVille, $eSubmit, $eAnnuler);
		$this->addElements($elements);

		// Ajout du decorateur au formulaire
		$this->setDecorators($decoratorsForm);
	}
 
}