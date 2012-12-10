<?php
class NoteController extends Zend_Controller_Action
{
    /** affichage des note du client */
	public function indexAction()
	{
        $idClient = $this->_request->getParam('idClient');
        // Chargement du model TNote
        $tableNote = new TNote;

        // Requetage par clé primaire
        $requeteNote = $tableNote   ->select()
                                    ->from($tableNote)
                                    ->where('idClient = ?', $idClient)
                                    ->order(array('dateAjout desc'));

        $note = $tableNote->fetchAll($requeteNote);
        $this->view->notes = $note;
	}

    /** ajoute d'une note */
	public function ajouterAction()
	{
        // Recuperation de l'Id Client
        $idClient = $this->_request->getParam('idClient');
        
		// creation de l'objet formulaire
        $form = new FNote;

        // affichage du formulaire
        $this->view->formNote = $form;

        // traitement du formulaire
        // si le formulaire a été soumis
        if ($this->_request->isPost()) {
        	// on recupere les éléments
            $formData = $this->_request->getPost();

            // si le formulaire passe au controle des validateurs
            if ($form->isValid($formData)) {

            	//on envoi la requete
                $note = new TNote;
                $row = $note->createRow();
                $row->idClient          = $idClient;
                $row->note        		= $form->getValue('note');
                $row->dateAjout         = time();

                $result = $row->save();
		
				// RAZ du formulaire
                $form->reset();

                // on recharge la page
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoUrl("client/detail/id/" . $idClient);
            }
        }
	}
}