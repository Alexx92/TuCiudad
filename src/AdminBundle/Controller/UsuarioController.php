<?php

namespace AdminBundle\Controller;
// --
use FOS\UserBundle\Event\FilterUserResponseEvent;
use FOS\UserBundle\Event\FormEvent;
use FOS\UserBundle\Event\GetResponseUserEvent;
use FOS\UserBundle\Form\Factory\FactoryInterface;
use FOS\UserBundle\FOSUserEvents;
use FOS\UserBundle\Model\UserInterface;
use FOS\UserBundle\Model\UserManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

// ---
// use Symfony\Bundle\FrameworkBundle\Controller\Controller;
// use Symfony\Component\HttpFoundation\Request;
// use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Usuario;

use \stdClass;

class UsuarioController extends Controller
{
    public function usuarioIndexAction()
    {

        return $this->render('AdminBundle:usuario:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'usuario',
            'menu_o_con'   => 'usuario'
        ));
    }

    public function usuarioNuevoAction(Request $request)
    {
        $titulo  = 'Nuevo usuario';

        $em = $this->getDoctrine()->getManager();        
        $roles = $em->getRepository('AdminBundle:Rol')->findAll();

        return $this->render('AdminBundle:Usuario:nuevo.html.twig',array(
            'titulo'            => $titulo,
            'roles'             => $roles,
            'lista_area'        => null,
            'menu'              => 'nuevo',
            'menu_o_con'        => 'usuario',
            'submenu'           => 'usuario_nuevo'
        ));
    }

    // carga la taba de contactos en el index
    public function usuarioCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $lista_usuario = array();

        if($usuario = $em->getRepository('AdminBundle:Usuario')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($usuario as $value)
            {
                $datos = new stdClass();
                
                $datos->id                 = $value->getId();
                $datos->primer_nombre      = $value->getPrimerNombre();
                $datos->apellido_paterno   = $value->getSegundoNombre();
                $datos->email              = $value->getCorreo();
                $datos->celular            = $value->getCelular();
                
                $lista_usuario[]  = $datos;

            }
        }

        return $this->render('AdminBundle:Layouts:tabla_usuario_index.html.twig', array(
            'lista_usuario' => $lista_usuario
        ));
    }

    // guarda nuevo usuario
    public function usuarioGuardarAction(Request $request)
    {
  
        $result = false;
        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id               = ($request->get('usuario_id', false)) ? $request->get('usuario_id'): 0;
            $id_personal      = $request->get('personal_id');
            $rol              = $request->get('roles');
            $pass              = $request->get('pass1');
                        

            $em = $this->getDoctrine()->getManager();            
            $personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('id'=>$id_personal));
            $userManager = $this->container->get('fos_user.user_manager');
            $username = $this->generarUsername($id_personal);            
            if (!$user =$userManager->findUserByEmail($personal->getCorreo()))
            {
                $user = $userManager->createUser();
                $user->setEnabled(true);
                $user->setEmail($personal->getCorreo());
                $username = $this->generarUsername($id_personal);
                $user->setUsername($username);                
            }

            $user->setRol($rol);
            $user->setPlainPassword($pass);
            $userManager->updateUser($user);
            $personal->setUsername($username);
            $em->persist($personal);
            $em->flush();
            $usuario_id = $em->getRepository('AdminBundle:Usuario')->findOneBy(array('email'=>$personal->getCorreo()))->getId();
            $result = true;
        }
        $response = new JsonResponse();
        $response->setData(array('result' => $result,'usuario_id'=>$usuario_id));        
        return $response;
    }

    // cargar formulario para editar
    public function usuarioEditarAction(Request $request)
    {

        $titulo  = 'Editar usuario';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $usuario = $em->getRepository('AdminBundle:usuario')->findOneBy(array('id' => $id));        
       
    }
    private  function generarUsername($id_personal)
    {
       // $id_personal = $request->get('id', false);     
        $em = $this->getDoctrine()->getManager();
        $personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('id'=>$id_personal));         
        $username = ' ';       
         for ($i=0; !$this->esValido($username); $i++) {
            $k=$i+3;
            if ($k<=strlen($personal->getApellidoPaterno())) {
                $username = $this->quitar_tildes($personal->getPrimerNombre()).''.substr($this->quitar_tildes($personal->getApellidoPaterno()),0,$k);                
            }else{
                $username = $personal->getPrimerNombre().''.$personal->getApellidoMaterno().''.substr($personal->getApellidoMaterno(),0,($i-strlen ($personal->getApellidoPaterno())));
            }
        }
        return strtolower($username);      
    }
    private function quitar_tildes($cadena) {
        //$cade = utf8_decode($cadena);
        $no_permitidas= array ('á','é','í','ó','ú',/*,'Á','É','Í','Ó','Ú','ñ'/*,'À','Ã','Ì','Ò','Ù','Ã™','Ã “,'Ã¨','Ã¬','Ã²','Ã¹','ç','Ç','Ã¢','ê','Ã®','Ã´','Ã»','Ã‚','ÃŠ','ÃŽ','Ã'','Ã›','ü','Ã¶','Ã–','Ã¯','Ã¤','«','Ò','Ã','Ã„','Ã‹','Ñ','à','è','ì','ò','ù'*/);
        $permitidas= array ('a','e','i','o','u',/*,'A','E','I','O','U','n','N','A','E','I','O','U','a','e','i','o','u','c','C','a','e','i','o','u','A','E','I','O','U','u','o','O','i','a','e','U','I','A','E','N','a','e','i','o','u'*/);
        $texto = str_replace($no_permitidas, $permitidas ,$cadena);
        return $texto;
    }
    private function esValido($username){  
        $valid = false;
        if ($username!=' ') {
            $em = $this->getDoctrine()->getManager();        
            if (!$em->getRepository('AdminBundle:Usuario')->findOneBy(array('username'=>$username))) {
                $valid = true;
            }
        }
       
        return $valid;
    }
}
  

