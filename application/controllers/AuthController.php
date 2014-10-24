<?php

class AuthController extends Zend_Controller_Action
{

    public function init()
    {
        
    }

    public function indexAction()
    {
        $this->forward('registered');
    }

    public function registeredAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('index', 'index');
        }
        $form = new Application_Form_Registered();
        $this->view->form = $form;
        if($this->getRequest()->getPost())
        {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                $userModel = new Application_Model_Users();
                $userModel->createUser($formData['login'], md5($formData['password']), 
                        $formData['name'], $formData['email']);
                if($this->authUser($formData['login'], $formData['password']))
                {
                   $this->_helper->redirector('index', 'index');
                }
                else
                {
                    $this->view->errorMsg = "Ошибка регистрации";
                }
            }
            else
            {
                $this->view->errorMsg = "Введены неверные данные";
            }
        }
        
    }

    public function loginAction()
    {
        if(Zend_Auth::getInstance()->hasIdentity())
        {
            $this->_helper->redirector('index', 'index');
        }
        $form = new Application_Form_Login();
        $this->view->form = $form;
        if($this->getRequest()->getPost())
        {
            $formData = $this->getRequest()->getPost();
            if($form->isValid($formData))
            {
                if($this->authUser($formData['login'], $formData['password']))
                {
                    $this->_helper->redirector('index', 'index');
                }
                else
                {
                    $this->view->errorMsg = "Ошибка авторизации";
                }
            }
            else
            {
                $this->view->errorMsg = "Введены неверные данные";
            }
        }
    }

    public function logoutAction()
    {
        Zend_Auth::getInstance()->clearIdentity();
        $this->_helper->redirector('index', 'index');
    }
    
    /**
     * 
     * @param string $login
     * @param string $password
     * @return boolean
     */
    protected function authUser($login, $password)
    {

        $authAdapter = new Zend_Auth_Adapter_DbTable(Zend_Db_Table::getDefaultAdapter());
        $authAdapter->setTableName('users')
                ->setIdentityColumn('login')
                ->setCredentialColumn('password')
        ;
        $authAdapter->setIdentity($login)
                ->setCredential(md5($password));
        $auth = Zend_Auth::getInstance();
        $result = $auth->authenticate($authAdapter);
        if($result->isValid())
        {
            $userInfo = $authAdapter->getResultRowObject();
            $authStorage = $auth->getStorage();
            $authStorage->write($userInfo);
            return true;
        }
        return false;
    }

}



