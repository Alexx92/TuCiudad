<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Cargo;

use \stdClass;

class CargoController extends Controller
{
    public function cargoIndexAction()
    {

        return $this->render('AdminBundle:Cargo:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'cargo',
            'menu_o_con'   => 'cargo'
        ));
    }

    public function cargoNuevoAction()
    {
        $titulo  = 'Nueva Opcion de Producto';

        return $this->render('AdminBundle:Cargo:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'cargo',
            'submenu'         => 'opcionesproducto_nuevo'
        ));
    }
    // guarda nueva cargo
    public function cargoGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                 = ($request->get('id_contacto', false)) ? $request->get('id_contacto'): 0;
            $nombre             = ucfirst($request->get('nombre'));
            $obs                = $request->get('obs');

            $em = $this->getDoctrine()->getManager();

            if( !$cargo = $em->getRepository('AdminBundle:Cargo')->findOneBy(array( 'id' => $id )) )
            {
                $cargo = new cargo();
            }

            $cargo->setNombre($nombre);       
            $cargo->setObservacion($obs);   

            $em->persist($cargo);
            $em->flush();            
            $result = true;
            $id_new = $cargo->getId();
        }
        $response = new JsonResponse();
        $response->setData(array('result' => $result, 'id_new' => $id_new));        
        return $response;
    }
    public function ajaxCargoGuardarAction(Request $request)
    {
        $nombre  = $request->get('nombre');            
        $obs   = $request->get('obs');
        $em = $this->getDoctrine()->getManager();

        $cargo = new Cargo();
        $cargo->setNombre($nombre);
        $cargo->setObservacion($obs);
  
        $em->persist($cargo);
        $em->flush();            
        $id_new = $cargo->getId();

        $cargos = $em->getRepository('AdminBundle:Cargo')->findAll();

        $lista_cargos = '';
        $op = true;
        foreach ($cargos as $result) {
            if($lista_cargos==''){
                $lista_cargos .= '<option value="">Seleccione</option>';
            }
            $lista_cargos .= '<option value="'.$result->getId().'"> '.$result->getNombre().'</option>';
        }
        $response = new JsonResponse();
        $response->setData(array('lista_cargos' => $lista_cargos));        
        return $response;
    }
}