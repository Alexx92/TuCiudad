<?php
// src/AdminBundle/Entity/User.php

namespace AdminBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
 */
class User extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;
    // protected $int;

    public function __construct()
    {
        parent::__construct();
        // your own logic
        //$this->roles = array('ROLE_ADMIN');
        // $this->setRol($int);
    }
    public function setRol($int){
        if ($int == 1) {
            $this->roles = array('ROLE_ADMIN_A');
        } else { 
            if ($int == 2) {
                $this->roles = array('ROLE_ADMIN_B');
            }else{
                if ($int == 3) {
                    $this->roles = array('ROLE_ADMIN_C');
                }else{
                    if ($int == 4) {
                        $this->roles = array('ROLE_ADMIN_D');
                    } else {
                        if ($int == 5) {
                            $this->roles = array('ROLE_VENTA_A');
                        } else {
                            if ($int == 6) {
                                $this->roles = array('ROLE_VENTA_B');
                            } else {
                                if ($int == 7) {
                                    $this->roles = array('ROLE_TRABAJADOR');
                                }
                            }
                        }                        
                    }                    
                }
            }
        }
    }      
}
