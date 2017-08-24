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
    // guarda nuevo cargo y retorna un listado de todos los existentes
    public function cargoGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                 = ($request->get('id_contacto', false)) ? $request->get('id_contacto'): 0;
            $nombre             = ucfirst($request->get('cargo_nombre'));
            $obs                = $request->get('cargo_obs');
            $valid = false;
            $em = $this->getDoctrine()->getManager();
            $id_new ='';
            $lista_cargos = '';//listado final a retornar
            
            /*If de validacion de cargo por nombre*/
            if (!$em->getRepository('AdminBundle:Cargo')->findOneBy(array('nombre'=>$nombre))) {
                $valid = true;
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
                /*Retorna listado de todos los cargos*/    
                $cargos = $em->getRepository('AdminBundle:Cargo')->findAll();
                
                $lista_cargos = '';//listado final a retornar
                foreach ($cargos as $result) {
                    if($lista_cargos==''){
                        $lista_cargos .= '<option value="">Seleccione</option>';
                    }
                    $lista_cargos .= '<option value="'.$result->getId().'"> '.$result->getNombre().'</option>';
                }
            }//Fin validacion por nombre
           
        }
        $response = new JsonResponse();
        $response->setData(array('result' => $result,'valid'=>$valid,'id_new' => $id_new, 'lista_cargos'=>$lista_cargos));        
        return $response;
    }
    // Retorna listado de todos los cargos 
    public function cargarListadoAllAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $cargos = $em->getRepository('AdminBundle:Cargo')->findAll();        
        $lista_cargos = '';
        foreach ($cargos as $result) {
            if($lista_cargos==''){
                $lista_cargos .= '<option value="">Seleccione</option>';
            }
            $lista_cargos .= '<option value="'.$result->getId().'"> '.$result->getNombre().'</option>';
        }    
        $response = new JsonResponse();
        $response->setData(array( 'listaCargos'=>$lista_cargos));        
        return $response;
    }
}