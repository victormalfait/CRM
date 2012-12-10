<?php

class FInscription extends Zend_Form
{

	public function init()
	{
        // Parametre du formulaire
        $this->setName('inscription');
		$this->setMethod('post');
		$this->setAction('');
		$this->setAttrib('id', 'FInscription');

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

		// Création des éléments
		$eId = new Zend_Form_Element_Hidden ( 'idUtilisateur' );
		$eId 		->setDecorators($decorators);

		$eNom = new Zend_Form_Element_Text('nom');
		$eNom		->setLabel('Nom')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addValidator('notEmpty')
					->setDecorators($decorators);

		$ePrenom = new Zend_Form_Element_Text('prenom');
		$ePrenom	->setLabel('Prenom')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addValidator('notEmpty')
					->setDecorators($decorators);

		$eEmail = new Zend_Form_Element_Text('email');
		$eEmail		->setLabel('Email')
					->setRequired(true)
					->setAttrib('required', 'required')
					->addValidator('notEmpty')->addValidator ( 'EmailAddress' )->addValidator ( new Zend_Validate_Db_NoRecordExists ( 'utilisateur', 'email' ))
					->setDecorators($decorators);

		$ePassword = new Zend_Form_Element_Password ( 'password' );
		$ePassword 	->setLabel ( 'Mot de passe' )
					->addFilter ( 'StripTags' )->addFilter ( 'StringTrim' )
					->setRequired ( true )
					->setAttrib('required', 'required')
					->setDecorators($decorators);

		$ePassword2 = new Zend_Form_Element_Password ( 'password2' );
		$ePassword2	->setLabel ( 'Confirmation' )
					->addFilter ( 'StripTags' )->addFilter ( 'StringTrim' )
					->setAttrib('required', 'required')
					->setDecorators($decorators);

		$eSubmit = new Zend_Form_Element_Submit ( 'submit' );
		$eSubmit 	->setAttrib ( 'id', 'submitbutton' )
					->setLabel ( 'Validation' );

		// Ajout des éléments au formulaire
		$elements = array ($eId, $eNom, $ePrenom, $eEmail, $ePassword, $ePassword2, $eSubmit );
		$this->addElements ( $elements );

		// Ajout du decorateur au formulaire
		$this->setDecorators($decoratorsForm);
	}
}

// public function isValid($data)
// {
// 	$this->getElement('password')->addValidator(new App_Validate_PasswordMatch($data['password2']));
	
// 	if ($this->getElement('email')->getValue() == $data['email']){
// 		$this->getElement('email')->removeValidator ( "Zend_Validate_Db_NoRecordExists" );
// 	}

// 	return parent::isValid($data);
// }

class App_Validate_PasswordMatch extends Zend_Validate_Abstract
{
    const PASSWORD_MISMATCH = 'passwordMismatch';
    protected $_compare;
    protected $_messageTemplates = array(
        self::PASSWORD_MISMATCH => "PASSWORD_MISMATCH"
    );

    public function __construct($compare){
        $this->_compare = $compare;
    }

    public function isValid($value){
        $this->_setValue((string) $value);

        if ($value !== $this->_compare)  {
            $this->_error(self::PASSWORD_MISMATCH);
            return false;
        }

        return true;
    }
}