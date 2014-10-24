<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Users
 *
 * @author lisper
 */
class Application_Model_Users extends Zend_Db_Table
{
    /**
     * @var string 
     */
    protected $_name = 'users';
    /**
     * @param string $login
     * @param string $pass
     * @param string $name
     * @param string $email
     * @return boolean
     */
    public function createUser($login, $pass, $name, $email)
    {
        $data = array(
            'login' => $login,
            'password' => $pass,
            'name' => $name,
            'email' => $email
        );
        $this->insert($data);
    }
}
