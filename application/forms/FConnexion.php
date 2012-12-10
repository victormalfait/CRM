<?php

class FConnexion extends Zend_Form
{
 
	public function init()
	{
		//parametrer le formulaire
		$this->setName('connexion');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FConnexion');

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

		$eEmail = new Zend_Form_Element_Text('email');
		$eEmail		->setLabel('E-mail')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->setDecorators($decorators);


		$ePass = new Zend_Form_Element_Password('password');
		$ePass 		->setLabel('Mot de passe')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addFilter('StripTags')
					->addFilter('StringTrim')
		            ->setDecorators($decorators);


		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit 	->setAttrib('id', 'submitbutton')
					->setLabel('Se connecter');

		$elements = array($eEmail,$ePass, $eSubmit);
		$this->addElements($elements);

		// Ajout du decorateur au formulaire
		// $this->setDecorators($decoratorsForm);
	}
 
}