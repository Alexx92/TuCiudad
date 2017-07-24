<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Contacto;
use AdminBundle\Entity\Empresa;
use AdminBundle\Entity\ContacEmpre;

use \stdClass;

class ContactoController extends Controller
{
    public function contactoIndexAction()
    {

        return $this->render('AdminBundle:Contacto:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'contacto',
            'menu_o_con'   => 'contacto'
        ));
    }

    public function contactoNuevoAction()
    {
        $titulo  = 'Nuevo Contacto';

        return $this->render('AdminBundle:Contacto:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'contacto',
            'submenu'         => 'contacto_nuevo'
        ));
    }    

    // carga la taba de contactos en el index
    public function contactoCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $where = array('estado' => 1);

        $lista_contacto = array();

        if($contacto = $em->getRepository('AdminBundle:Contacto')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($contacto as $value)
            {
                $datos = new stdClass();
                
                $datos->id             = $value->getId();
                $datos->nombre         = $value->getPrimerNombre();
                $datos->apellido       = $value->getApellidoPaterno();
                $datos->email          = $value->getCorreo();
                $datos->telefono       = $value->getTelefono();
                
                $lista_contacto[]  = $datos;

            }
        }

        //return $lista_contacto;
        return $this->render('AdminBundle:Layouts:tabla_contacto_index.html.twig', array(
            'lista_contacto' => $lista_contacto
        ));
    }

    // guarda nuevo contacto
    public function contactoGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                 = ($request->get('id_contacto', false)) ? $request->get('id_contacto'): 0;
            $primer_nombre      = ucfirst($request->get('contacto_pri_nomb'));
            $segundo_nombre     = ucfirst($request->get('contacto_seg_nomb'));
            $apellido_paterno   = ucfirst($request->get('contacto_ape_pate'));
            $apellido_materno   = ucfirst($request->get('contacto_ape_mate'));
            $email              = $request->get('contacto_email');
            $telefono           = $request->get('contacto_fono');
            $cargo              = ucfirst($request->get('contacto_cargo'));
            $observacion        = ucfirst($request->get('contacto_obs'));
            $imagen             = ($request->files->get('contacto_img', false))? $request->files->get('contacto_img'): null;

            $em = $this->getDoctrine()->getManager();

            if( !$contacto = $em->getRepository('AdminBundle:Contacto')->findOneBy(array( 'id' => $id )) )
            {
                $contacto = new Contacto();
                $contacto->setEstado(1);
                $contacto->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
                
            }

            $contacto->setPrimerNombre($primer_nombre);
            $contacto->setSegundoNombre($segundo_nombre);
            $contacto->setApellidoPaterno($apellido_paterno);
            $contacto->setApellidoMaterno($apellido_materno);
            $contacto->setCorreo($email);
            $contacto->setTelefono($telefono);
            $contacto->setCargo($cargo);
            $contacto->setObservacion($observacion);
            

            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $contacto->setImagen($dir_image);
            }

            $em->persist($contacto);
            $em->flush();
            
            $result = true;
            $id_new = $contacto->getId();
        }
        // echo json_encode(array('result' => $result));
        // exit;

        $response = new JsonResponse();
        $response->setData(array('result' => $result, 'id_new' => $id_new));
        
        return $response;
    }

    // cargar formulario para editar
    public function contactoEditarAction(Request $request)
    {

        $titulo  = 'Editar Contacto';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $contacto = $em->getRepository('AdminBundle:Contacto')->findOneBy(array('id' => $id));
        
        $data = array();

        $data['id']                = $contacto->getId();
        $data['primer_nombre']     = $contacto->getPrimerNombre();
        $data['segundo_nombre']    = $contacto->getSegundoNombre();
        $data['apellido_paterno']  = $contacto->getApellidoPaterno();
        $data['apellido_materno']  = $contacto->getApellidoMaterno();
        $data['email']             = $contacto->getCorreo();
        $data['telefono']          = $contacto->getTelefono();
        $data['cargo']             = $contacto->getCargo();
        $data['observacion']       = $contacto->getObservacion();
        $data['imagen']            = $contacto->getImagen();

        // carga de datos con la lista de empresas vinculadas al contacto
        $lista_emprecont = array();
        
        if( $cont_empre = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkContacto' => $id )) )
        {
            foreach($cont_empre as $value)
            {
                $datos = new stdClass();
                
                $datos->id_contempr     = $value->getId();
                $datos->nombre_fkempre  = $value->getFkEmpresa()->getNombre();
                //$datos->id_fkcont       = $value->getFkContacto()->getId();
                //$datos->id_fkempre      = $value->getFkEmpresa()->getId();
                
                $lista_emprecont[]  = $datos;

            }
        }

        return $this->render('AdminBundle:Contacto:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'data'            => $data,
            'lista_emprecont' => $lista_emprecont,
            'menu'            => 'nuevo',
            'submenu'         => 'contacto_nuevo',
            'form'            => 'activo',
            'menu_o_con'      => 'contacto'
        ));
    }

    // elimanr un contacto
    public function contactoEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $contacto = $em->getRepository('AdminBundle:Contacto')->findOneBy(array('id' => $id,'estado' => 1)) )
        {
            $contacto->setEstado(0);
            $em->persist($contacto);
            $em->flush();
        }

        echo json_encode(array(true));
        exit;
    }

    // subir imagenes
    private function subirImagen($imagen)
    {
        $result = null;
        if($imagen)
        {
            $obj = array(
                'filesize'      => $imagen->getClientSize(),
                'filetype'      => $imagen->getClientMimeType(),
                'fileextension' => $imagen->getClientOriginalExtension(),
                'filenewname'   => uniqid().".".$imagen->getClientOriginalExtension(),
                'filenewpath'   => __DIR__.'/../../../web/uploads/contacto'
            );
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                $imagen->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }

    
    // ajax buscar empresas 
    public function buscarDataAction(Request $request)
    {
        $data = $request->get('bosq_box');    
        dump($data);    
        $em = $this->getDoctrine()->getManager();
 
        $query = $em->createQuery(''
                . 'SELECT c.id, c.nombre '
                . 'FROM AdminBundle:Empresa c ' 
                . 'WHERE (c.nombre LIKE :data AND c.estado = 1) '
                . 'ORDER BY c.nombre ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getResult();        
        $empreLista = '';
        foreach ($results as $result) {
            $empreLista .= '<li class="ele" role="presentation"><span role="menuitem" data-id="'.$result['id'].'" data-name="'.$result['nombre'].'">'.$result['nombre'].'</span></li>';
        }

 
        $response = new JsonResponse();
        $response->setData(array('empreLista' => $empreLista));
        
        return $response;
    }

    // ajax guardar relaciones cliente-empresa
    public function ajax_guardar_empresaAction(Request $request)
    {
        $id = (false);
        $id_cont = $request->get('id_cont');
        $id_empre = $request->get('id_empre');

        if( $request->getMethod() == 'POST' )
        {
            $em = $this->getDoctrine()->getManager();

            $Fkcontacto = $em->getRepository('AdminBundle:Contacto')->findOneBy(array('id' => $id_cont));            
            $Fkempresa  = $em->getRepository('AdminBundle:Empresa')->findOneBy(array('id' => $id_empre));

            if( !$cli_empre = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array( 'id' => $id )) )
            {
                $cli_empre = new ContacEmpre();
                $cli_empre->setFkContacto($Fkcontacto);
                $cli_empre->setFkEmpresa($Fkempresa);
                $em->persist($cli_empre);
                $em->flush();
            }

        }

        $response = new JsonResponse();
        $response->setData(array('cli_empre' => $cli_empre));
        
        return $response;
    }

    // ajax para quitar empresas viculadas a clientes
    public function ajax_borrar_empresaAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        
        if ($delete = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array('id' => $id)))
        {
            $em->remove($delete);
            $em->flush();
        }

        echo json_encode(array(true));
        exit;
    }

}