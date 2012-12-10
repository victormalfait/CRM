<?php
class Bootstrap extends Zend_Application_Bootstrap_Bootstrap
{
	public function run()
	{
		parent::run();
	}

	/** initialisation et stockage de la configuration */
	protected function _initConfig()
	{
		Zend_Registry::set('config', new Zend_Config($this->getOptions()));
	}

	/** initialisation de l'API personnalisée "CRM" */
	protected function _initLoaderCRM()
	{
		$autoloader = Zend_Loader_Autoloader::getInstance();
		$autoloader->registerNamespace('CRM_');
		$autoloader->setFallbackAutoloader(true);
	}

	/** initialisation des sessions et de l'espace de nom crm pour les sessions */
	protected function _initSession()
	{
		$sessionConfig = Zend_Registry::get('config')->session;
    	Zend_Session::setOptions($sessionConfig->toArray());
		$session = new Zend_Session_Namespace('crm', true);
		return $session;
	}

	/** initialisation et stockage de la base de données */
	protected function _initDb()
	{
		$db = Zend_Db::factory(Zend_Registry::get('config')->database);
		Zend_Db_Table_Abstract::setDefaultAdapter($db);
		Zend_Registry::set('db', $db);
	}

	/** Initialisation de l'empilage des actions */
	protected function _initActionStack()
	{
	    $actionStack = Zend_Controller_Action_HelperBroker::getStaticHelper('actionStack');
		// $actionStack->actionToStack(new Zend_Controller_Request_Simple('afficher', 'menu', 'default'));
	    return $actionStack;
	}

	/** initialiser Zend_View */
	protected function _initView()
	{
		// Chargement de Zend_View
	    $view = new Zend_View();

	    //... code de paramétrage de votre vue : titre, doctype ...
	    $view->doctype('HTML5');
	}

	/** Initialisation de JQuery */
	protected function _initJQuery() {

		// Chargement de Zend_View
        $view = new Zend_View();

        // 
		$view->addHelperPath('ZendX/JQuery/View/Helper/', 'ZendX_JQuery_View_Helper');

		// Ajout au viewRenderer
		$viewRenderer = new Zend_Controller_Action_Helper_ViewRenderer();
		$viewRenderer->setView($view);
		Zend_Controller_Action_HelperBroker::addHelper($viewRenderer);

		return $view;

    }

	// /** Initialisation des Acls */
	// protected function _initAcl() {

	// 	// chargement de Zend_Acl
	// 	$acl = new Zend_Acl;

	// 	// Mise en place des rôles
	// 	$acl->addRole('guest')
	// 		->addRole('member');

	// 	// Mise en place des resources
	// 	$acl->addResource('client')
	// 		->addResource('index')
	// 		->addResource('login')
	// 		->addResource('menu')
	// 		->addResource('note')
	// 		->addResource('societe')
	// 		->addResource('tache');

	// 	// Mise en place des regles
	// 	$acl->deny('guest', null);
	// 	$acl->allow('guest', 'login', 'inscription');
	// 	$acl->allow('member', null);
	// 	$acl->deny('member', 'login', 'inscription');

	// 	// on enregistre notre acl
	// 	Zend_Registry::set('acl', $acl);

	// 	// on test les droits d'acces
	// 	echo $acl->isAllowed('guest', 'login', 'inscription') ? 'Autorise' : 'Refuse';
	// }
}