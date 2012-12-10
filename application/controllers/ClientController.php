<?php
class ClientController extends Zend_Controller_Action
{

    public function init()
    {
        // Ajout du helper d'action JQuery autoComplete
        Zend_Controller_Action_HelperBroker::addHelper( new ZendX_JQuery_Controller_Action_Helper_AutoComplete());
    }

    /** afficher la liste des client par defaut */
	public function indexAction()
	{
		// charger le model
		$tableClient = new TClient;

        // Requete
        $listeRequete = $tableClient 	->select()
                                    	->from($tableClient, array('idClient', 'nom', 'prenom'));

        // envoi du resultat a la vue
        $this->view->clients = $tableClient->fetchAll($listeRequete);

        // Message du detail client lorsqu'aucun client n'a été choisi
        $this->view->messages = $this->_helper->FlashMessenger->getMessages();

	}

    /** afficher la liste des client en resumé et paginé */
	public function listeAction()
	{
        $tableClient = new TClient;
        // on charge le model TSociete
        $tableSociete = new TSociete;

        // Récuperation le filtre
        $filtre = $this->_getParam('filtre') . '%';

        // si un filtre a été demandé
        if (isset($filtre)) {

            // on recupere les clients correspondant au filtre demandé
            $client = $tableClient  ->select()
                                    ->setIntegrityCheck(false)
                                    ->from('client')
                                    ->join('societe', 'client.idSociete = societe.idSociete')
                                    ->where('codePostal LIKE ?', $filtre)
                                    ->orwhere('ville LIKE ?', $filtre);
        }
        else { //sinon        
            // on recupere tout les clients 
            $client = $tableClient->fetchAll();
        }

        // on instancie Zend Paginator
        $pageClient = Zend_Paginator::factory($client);
        
        // on recupere le numero de page dans le paginator
        $pageClient->setCurrentPageNumber($this->_getParam('page'));

        // on envoi le resultat a la vue
        $this->view->clients = $pageClient;

	}

    /** créer /modifier un client */
	public function editAction()
	{
        // Recuperation de l'Id Client
        $idClient = $this->_request->getParam('idClient');

        // creation de l'objet formulaire
        $form = new FClient;

        // envoi de l'id client au formulaire
        $form->setidClient($idClient);
        $form->init ();

        // affichage du formulaire
        $this->view->formClient = $form;

        // traitement du formulaire
        // si le formulaire a été soumis
        if ($this->_request->isPost()) {
        	// on recupere les éléments
            $formData = $this->_request->getPost();

            // si le formulaire passe au controle des validateurs
            if ($form->isValid($formData)) {
                // on charge le model TClient
                $users = new TClient;

                // Si on a un idClient
                if (isset ( $idClient ) && $idClient != "") {
                    // On recupere le client a mettre a jour
                    $row = $users   ->find($idClient)
                                    ->current();
                }
                else { // sinon
                	//on créer un nouveau client
                    $row = $users->createRow();
                }

	            // on envoi les données
                $row->nom           = $form->getValue('nom');
                $row->prenom        = $form->getValue('prenom');
                $row->email         = $form->getValue('email');
                $row->idSociete     = $form->getValue('idSociete');
                $row->telephone     = $form->getValue('telephone');

                // on enregistre les changements 
                $row->save();

				// RAZ du formulaire
                $form->reset();

                // Si on a un idClient
                if (isset ( $idClient ) && $idClient != "") {
                    // on recharge la page
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoUrl("client/detail/id/" . $idClient);
                }
                else { // sinon 
                    // on recharge la page
                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoUrl("client/detail");
                }

            }
        }
	}

    /** afficher le detail  d'un client */
	public function detailAction()
	{
        // Récuperation de l'id de client à détailler
        $idClient = $this->_getParam('id');
        $this->view->idClient = $idClient;

        // si on a un id client
        if (isset($idClient)) {
            // chargement du model
            $tableClient = new TClient;

            // Requete par clé primaire
            $client = $tableClient  ->find($idClient)
                                    ->current();
            // Si le client existe
            if ($client!= null)
            {
                // Recherche des infos sur la societe du client
                $societe = $client->findParentRow('TSociete');

                // envoi du resultat a la vue
                $this->view->client = $client;
                $this->view->societe = $societe;
            }
            else { // Sinon (le client n'existe pas)
                // Message d'erreur si aucun id n'a été trouvé
                $message = "Le client selectionné n'existe pas";
                $this->_helper->FlashMessenger($message);

                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoUrl("client/index");
            }
        }
        else { // sinon (on a pas d'id client )
            // Message d'erreur si aucun id n'a été trouvé
            $message = "Vous n'avez pas selectionné de client";
            $this->_helper->FlashMessenger($message);

            $redirector = $this->_helper->getHelper('Redirector');
            $redirector->gotoUrl("client/index");
        }

	}

    /** filtrer les client */
	public function filtreAction()
	{
        // creation de l'objet formulaire
        $form = new FFiltre;

        // affichage du formulaire
        $this->view->formFiltre = $form;

        // traitement du formulaire
        // si le formulaire a été soumis
        if ($this->_request->isPost()) {
            // on recupere les éléments
            $formData = $this->_request->getPost();

            // si le formulaire passe au controle des validateurs
            if ($form->isValid($formData)) {
                // On recupere les données du formulaire
                $departement    = $form->getValue('departement');
                $ville          = $form->getValue('ville');

                if ($departement != 'first') {
                    $filtre = $departement;
                }
                
                if ($ville != 'first') {
                    $filtre = $ville;
                }
                if (($departement == 'first') && ($ville == 'first')){
                    // Message d'erreur si aucun id n'a été trouvé
                    $message = "Aucun filtre n'a été sélectionné";
                    $this->_helper->FlashMessenger($message);

                    $redirector = $this->_helper->getHelper('Redirector');
                    $redirector->gotoUrl("client/index");
                }


                // on redirige la page
                $redirector = $this->_helper->getHelper('Redirector');
                $redirector->gotoUrl("client/liste/filtre/" . $filtre);

            }
        }
	}

    /** recherche des société (utiliser our l'autocomplétion) */
    public function searchsocieteAction()
    {
        // Recuperation de la valeur de la variable term dans requete
        $request = $this->getRequest();
        $search = $request->getParam('term');
        
        // Instanciation du formulaire Societe
        $formSociete = new FSociete();
        // Recuperation des donnée de societe
        $societes = $formSociete->getsociete($search);
         
        // on créer une liste vide
        $listeSociete = array();
       
        // Pour chaque element de la requete de recherche de societe 
        foreach($societes as $societe)
        {
            // On l'insere dans la liste des societe
            // $listeSociete[$societe['idSociete']] = $societe['nom'];
            $listeSociete[] = array(
                'id'=>$societe['idSociete'],
                'label'=>$societe['societe']                 
               );
        }

        $this->_helper->json(array_values($listeSociete));
    }
}