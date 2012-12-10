<?php
class TacheController extends Zend_Controller_Action
{

    /** affichage des tache du client */
	public function indexAction()
	{
        // Recuperation de l'id client
        $idClient = $this->_request->getParam('idClient');
        // Chargement du model TNote
        $tableTache = new TTache;

        // Si on a un id client
        if (isset ( $idClient ) && $idClient != "") {
            // On recupere dans la base de donnée toutes les taches enregistrer du client

            $requeteTache = $tableTache ->select()
                                        ->from($tableTache)
                                        ->where('idClient = ?', $idClient)
                                        ->order(array('etat asc', 'dateFin asc'));
        }
        else { // Sinon (pas d'id client)
            // On recupere dans la base de donnée les tache qu'il reste a faire par client
            $requeteTache = $tableTache ->select()
                                        ->from($tableTache)
                                        ->where('etat = ?', 0)
                                        ->order(array('dateFin asc'));
        }


        $tache = $tableTache->fetchAll($requeteTache);
        $this->view->taches = $tache;
	}

    /** ajoute d'une tache */
	public function ajouterAction()
	{
        // Recuperation de l'Id Client
        $idClient = $this->_request->getParam('idClient');

		// creation de l'objet formulaire
        $form = new FTache;

        // Envoi du formulaire a la vue
        $this->view->formTache = $form;

        // traitement du formulaire
        // si le formulaire a été soumis
        if ($this->_request->isPost()) {
        	// on recupere les éléments
            $formData = $this->_request->getPost();

            // si le formulaire passe au controle des validateurs
            if ($form->isValid($formData)) {

            	//on envoi la requete
                $tache = new TTache;
                $row = $tache->createRow();
                $row->idClient          = $idClient;
                $row->tache        		= $form->getValue('tache');
                $row->dateFin           = strtotime($form->getValue('dateFin'));
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

    /** suppression d'une tache */
	public function supprimerAction()
	{
        // Récuperation de l'id de la tache
        $idTache = $this->_getParam('id');

        // Chargement du model TTache
        $tableTache = new TTache;

        //Requetage par clé primaire
        $tache = $tableTache    ->find($idTache)
                                ->current();

        $idClient = $tache->idClient;
        //suppression de la tache
        $tache->delete();

        // on recharge la page
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoUrl("client/detail/id/" . $idClient);
	}

    /** changer l'indicateur d'une tache */
    public function etatAction()
    {
        // Récuperation de l'id de la tache
        $idTache = $this->_getParam('id');

        // Chargement du model TTache
        $tableTache = new TTache;

        // on recupere la tache a mettre a jour
        $row = $tableTache  ->find($idTache)
                            ->current();

        //on recupere l'id du client (pour la redirection)
        $idClient = $row->idClient;

        // changement de l'etat
        $row->etat = 1;
        
        // on enregistre les changements 
        $row->save();

        // on recharge la page
        $redirector = $this->_helper->getHelper('Redirector');
        $redirector->gotoUrl("client/detail/id/" . $idClient);
    }
}