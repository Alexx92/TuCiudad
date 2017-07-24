<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction()
    {
    	// Titulo que se mostrara en la barra de navegacion
    	$titulo = 'Inicio';


        return $this->render('AdminBundle:Default:index.html.twig',array(
        	'titulo'     => $titulo,
        	'menu'       => '',
        	'submenu'    => 'default',
            'menu_o_con' => ''
        ));
    }

}
