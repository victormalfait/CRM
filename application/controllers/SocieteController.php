<?php

class SocieteController extends Zend_Controller_Action
{

	public function init()
	{
        // mise en place du contexte ajax
		$ajaxContext = $this->_helper->getHelper('AjaxContext');
        $ajaxContext->addActionContext('search', 'html')
                    ->initContext();
              
		// si on a une requete ajax
        if ($this->_request->isXmlHttpRequest())
        {
            // on desactive le layout
            $this->_helper->layout->disableLayout();
        }
	}

	public function ajouterAction()
	{
        // creation de l'objet formulaire
        $form = new FSociete;

        // affichage du formulaire
        $this->view->formSociete = $form;

        // traitement du formulaire
        // si le formulaire a été soumis
        if ($this->_request->isPost()) {
        	// on recupere les éléments
            $formData = $this->_request->getPost();

            // si le formulaire passe au controle des validateurs
            if ($form->isValid($formData)) {
                // on charge le model TClient
                $users = new TSociete;

            	//on créer un nouveau client
                $row = $users->createRow();

	            // on envoi les données
                $row->societe       = $form->getValue('societe');
                $row->adresse       = $form->getValue('adresse');
                $row->codePostal    = $form->getValue('codePostal');
                $row->ville         = $form->getValue('ville');

                // on enregistre les changements 
                $row->save();

				// RAZ du formulaire
                $form->reset();

                // on recharge la page
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoUrl("client/index");

            }
        }
	}

	public function searchAction()
	{
		// On recupere la valeur passer en parametre
        $search = $this->_getParam('val') . '%';
		// $search = 'inss%';
		// On charge le model TSociete
		$tableSociete = new TSociete;

		// on chercher si on a une societe commençant par la valeur
		$requeteSociete = $tableSociete	->select()
										->from($tableSociete)
										->where('societe LIKE ?', $search);
		$societe = $tableSociete->fetchAll($requeteSociete);

        // on envoi a la vue
		$this->view->societe = $societe;
	}
}