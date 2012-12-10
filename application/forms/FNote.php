<?php

class FNote extends Zend_Form
{
 
	public function init()
	{
		//parametrer le formulaire
		$this->setName('note');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FNote');

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

		$eNote = new Zend_Form_Element_Textarea('note');
		$eNote		->setLabel('Note')
		        	->setRequired(true)
		        	->setAttrib('required', 'required')->setAttrib('maxlength', '5000')->setAttrib('cols', '30')->setAttrib('rows', '4')
		            ->addFilter('StripTags')
		            ->addFilter('StringTrim')
		            ->setDecorators($decorators);


		$eSubmit = new Zend_Form_Element_Submit('submit');
		$eSubmit 	->setAttrib('id', 'submitbutton')
					->setAttrib('onclick', 'noteRefresh(); return false;')
					->setLabel('Enregistrer');


		$eAnnuler = new Zend_Form_Element_Reset('annuler');
		$eAnnuler 	->setLabel('Annuler')
					->setAttrib('id', 'annulerbutton')
					->setAttrib('class', 'close');

		$elements = array($eNote, $eSubmit, $eAnnuler);
		$this->addElements($elements);

		// Ajout du decorateur au formulaire
		$this->setDecorators($decoratorsForm);
	}
 
}