<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Vendedor;

use \stdClass;

class VendedorController extends Controller
{
    public function vendedorIndexAction()
    {

        return $this->render('AdminBundle:Vendedores:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'vendedor',
            'menu_o_con'   => 'vendedor'
        ));
    }

    public function vendedorNuevoAction()
    {
        $titulo  = 'Nuevo Vendedores';

        return $this->render('AdminBundle:Vendedores:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'vendedor',
            'submenu'         => 'vendedor_nuevo'
        ));
    }

    // carga la taba de contactos en el index
    public function vendedorCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $where = array('estado' => 1);

        $lista_vendedor = array();

        if($vendedor = $em->getRepository('AdminBundle:Vendedor')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($vendedor as $value)
            {
                $datos = new stdClass();
                
                $datos->id                 = $value->getId();
                $datos->primer_nombre      = $value->getPrimerNombre();
                $datos->apellido_paterno   = $value->getSegundoNombre();
                $datos->email              = $value->getCorreo();
                $datos->celular            = $value->getCelular();
                
                $lista_vendedor[]  = $datos;

            }
        }

        return $this->render('AdminBundle:Layouts:tabla_vendedor_index.html.twig', array(
            'lista_vendedor' => $lista_vendedor
        ));
    }

    // guarda nuevo contacto
    public function vendedorGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                        = ($request->get('vendedor_id', false)) ? $request->get('vendedor_id'): 0;
            $primer_nombre             = ucfirst($request->get('primer_nombre'));
            $segundo_nombre            = ucfirst($request->get('segundo_nombre'));
            $apellido_paterno          = ucfirst($request->get('apellido_paterno'));
            $apellido_materno          = ucfirst($request->get('apellido_materno'));
            $dni                       = $request->get('dni');
            $sexo                      = ucfirst($request->get('sexo'));
            //$fecha_nacimiento          = $request->get('fecha_nacimiento');
            $comuna                    = ucfirst($request->get('comuna'));
            $provincia                 = ucfirst($request->get('provincia'));
            $region                    = ucfirst($request->get('region'));
            $dir_villa_pobl            = ucfirst($request->get('dir_villa_pobl'));
            $dir_calle                 = ucfirst($request->get('dir_calle'));
            $dir_numero_casa           = $request->get('dir_numero_casa');
            $dir_numero_depto          = $request->get('dir_numero_depto');
            $dir_numero_piso           = $request->get('dir_numero_piso');
            $telefono                  = $request->get('telefono');
            $celular                   = $request->get('celular');
            $email                     = $request->get('email');
            $skype                     = $request->get('skype');

            $observacion               = ucfirst($request->get('obs'));
            $imagen                    = ($request->files->get('img_vendedor', false))? $request->files->get('img_vendedor'): null;

            $em = $this->getDoctrine()->getManager();

            if( !$contacto = $em->getRepository('AdminBundle:Vendedor')->findOneBy(array( 'id' => $id )) )
            {
                $contacto = new Vendedor();
                $contacto->setEstado(1);                
                $contacto->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));                
            }

            $contacto->setPrimerNombre($primer_nombre);
            $contacto->setSegundoNombre($segundo_nombre);
            $contacto->setApellidoPaterno($apellido_paterno);
            $contacto->setApellidoMaterno($apellido_materno);
            $contacto->setDni($dni);
            $contacto->setSexo($sexo);
            //$contacto->setFechaNacimiento($fecha_nacimiento);                
            $contacto->setComuna($comuna);
            $contacto->setProvincia($provincia);
            $contacto->setRegion($region);
            $contacto->setDirVillaPbla($dir_villa_pobl);
            $contacto->setDirCalle($dir_calle);
            $contacto->setDirNumeroCasa($dir_numero_casa);
            $contacto->setDirNumeroDepartamento($dir_numero_depto);
            $contacto->setDirNumeroPiso($dir_numero_piso);                
            $contacto->setTelefono($telefono);
            $contacto->setCelular($celular);
            $contacto->setCorreo($email);
            $contacto->setSkype($skype);
                
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

        }

        //return $this->redirectToRoute('admin_contacto_nuevo');
        echo json_encode(array('result' => $result));
        exit;
    }

    // cargar formulario para editar
    public function vendedorEditarAction(Request $request)
    {

        $titulo  = 'Editar Vendedor';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $vendedor = $em->getRepository('AdminBundle:Vendedor')->findOneBy(array('id' => $id));        
        
        $data = array();

        $data['id']                = $vendedor->getId();
        $data['primer_nombre']     = $vendedor->getPrimerNombre();
        $data['segundo_nombre']    = $vendedor->getSegundoNombre();
        $data['apellido_paterno']  = $vendedor->getApellidoPaterno();
        $data['apellido_materno']  = $vendedor->getApellidoMaterno();
        
        $data['dni']               = $vendedor->getDni();
        $data['sexo']              = $vendedor->getSexo();
        $data['fecha_nacto']       = $vendedor->getFechaNacimiento();
        
        $data['comuna']            = $vendedor->getComuna();
        $data['provincia']         = $vendedor->getProvincia();
        $data['region']            = $vendedor->getRegion();
        $data['dir_villa_pobl']    = $vendedor->getDirVillaPbla();
        $data['dir_calle']         = $vendedor->getDirCalle();
        $data['dir_numero_casa']   = $vendedor->getDirNumeroCasa();
        $data['dir_numero_depto']  = $vendedor->getDirNumeroDepartamento();
        $data['dir_numero_piso']   = $vendedor->getDirNumeroPiso();
        
        $data['telefono']          = $vendedor->getTelefono();
        $data['celular']           = $vendedor->getCelular();
        $data['email']             = $vendedor->getCorreo();
        $data['skype']             = $vendedor->getSkype();
        $data['obs']               = $vendedor->getObservacion();
        $data['imagen']            = $vendedor->getImagen();

        // carga de datos con la lista de contactos vinculados a la empresa
        //$lista_contempre = array();
        //if( $cont_empre = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkEmpresa' => $id )) )
        //{
        //    foreach($cont_empre as $value)
        //    {
        //        $datos = new stdClass();                
        //        $datos->id_contacto            = $value->getId();
        //        $datos->pri_nombre_fkcont      = $value->getFkContacto()->getPrimerNombre();
        //        $datos->seg_nombre_fkcont      = $value->getFkContacto()->getSegundoNombre();
        //        $datos->apellido_pate_fkcont   = $value->getFkContacto()->getApellidoPaterno();
        //        $datos->apellido_mate_fkcont   = $value->getFkContacto()->getApellidoMaterno();                
        //        $lista_contempre[]  = $datos;
        //    }
        //}
        
        return $this->render('AdminBundle:Vendedores:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'data'            => $data,
            'submenu'         => 'vendedor_nuevo',
            'form'            => 'activo',
            'menu_o_con'      => 'vendedor'
        ));
    }
    
    // elimanr un vendedor
    public function vendedorEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $vendedor = $em->getRepository('AdminBundle:Vendedor')->findOneBy(array('id' => $id,'estado' => 1)) )
        {
            $vendedor->setEstado(0);
            $em->persist($vendedor);
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/vendedor'
            );
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                $imagen->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }

}
