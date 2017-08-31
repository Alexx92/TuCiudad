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

class EmpresasController extends Controller
{
    public function empresaIndexAction()
    {

        return $this->render('AdminBundle:Empresas:index.html.twig',array(
        	'submenu'         => 'empresa',
            'menu_o_con'      => 'empresa'
        ));
    }

    public function empresaNuevoAction()
    {
        // Titulo que se mostrara en la barra de navegacion
        $titulo = 'Nueva Empresa';

        $em = $this->getDoctrine()->getManager();
        $lista_regiones = $em->getRepository('AdminBundle:DefRegion')->findAll();        

        return $this->render('AdminBundle:Empresas:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'lista_regiones'  => $lista_regiones,
            'lista_provincias' => null,
            'lista_comunas'    => null,
            'nombreRegion'     => null,
            'nombreProvincia'  => null,
            'nombreComuna'     => null,
        	'submenu'         => 'empresa_nueva',
            'menu_o_con'      => 'empresa'
        ));
    }

    //carga taba
    public function empresaCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $where = array('estado' => 1);

        $lista_empresa = array();

        if($contacto = $em->getRepository('AdminBundle:Empresa')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($contacto as $value)
            {
                $datos = new stdClass();
                
                $datos->id             = $value->getId();
                $datos->rut            = $value->getRut();
                $datos->nombre         = $value->getNombre();
                $datos->email          = $value->getCorreo();
                $datos->telefono       = $value->getTelefono();
                
                $lista_empresa[]  = $datos;

            }
        }

        //return $lista_contacto;
        return $this->render('AdminBundle:Layouts:tabla_empresa_index.html.twig', array(
            'lista_empresa' => $lista_empresa
        ));
    }

    // guardar datos
    public function empresaGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                 = ($request->get('empre_id', false)) ? $request->get('empre_id'): 0;
            $nombre             = ucfirst($request->get('empre_nombre'));
            $rsocial            = ucfirst($request->get('empre_razon_soc'));
            $rut                = $request->get('empre_rut');
            $comuna             = $request->get('comunas');
            $provincia          = $request->get('provincias');
            $region             = $request->get('regiones');
            $dir_villa_pobl     = ucfirst($request->get('empre_villa_pobl'));
            $dir_calle          = ucfirst($request->get('empre_calle'));
            $dir_numero         = $request->get('empre_nume');
            $dir_numero_depto   = $request->get('empre_num_dpto');
            $dir_numero_piso    = $request->get('empre_dpto_piso');
            $celular            = $request->get('empre_celular');
            $telefono           = $request->get('empre_telefono');
            $mail               = $request->get('empre_mail');
            $web                = $request->get('empre_web');
            $obs                = ucfirst($request->get('empre_obs'));
            $coordenadas        = $request->get('empre_gmap');
            $imagen             = ($request->files->get('empre_img', false))? $request->files->get('empre_img'): null;

            // carga de datos hacia la base de datos
            $em = $this->getDoctrine()->getManager();

            if( !$empresa = $em->getRepository('AdminBundle:Empresa')->findOneBy(array( 'id' => $id )) )
            {
                $empresa = new Empresa();
                $empresa->setEstado(1);
                $empresa->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));                
            }

            $empresa->setNombre($nombre);
            $empresa->setRazonsocial($rsocial);
            $empresa->setRut($rut);            
            $empresa->setComuna($comuna);
            $empresa->setProvincia($provincia);
            $empresa->setRegion($region);
            $empresa->setDirVillaPbla($dir_villa_pobl);
            $empresa->setDirCalle($dir_calle);
            $empresa->setDirNumero($dir_numero);
            $empresa->setDirNumeroDepartamento($dir_numero_depto);
            $empresa->setDirNumeroPiso($dir_numero_piso);            
            $empresa->setTelefono($telefono);
            $empresa->setCelular($celular);
            $empresa->setCorreo($mail);
            $empresa->setWeb($web);
            $empresa->setObservacion($obs);
            $empresa->setCoordenadas($coordenadas);
            $empresa->setEstadoEmpresa($em->getRepository('AdminBundle:EstadoEmpresa')->findOneBy(array('id'=>1)));
            
            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $empresa->setImagen($dir_image);
            }            

            $em->persist($empresa);
            $em->flush();
            $result = true;

        }
        $response = new JsonResponse();
        $response->setData(array('result' => $result,'id_new'=>$empresa->getId()));        
        return $response;        
    }

    // cargar formulario para editar
    public function empresaEditarAction(Request $request)
    {

        $titulo  = 'Editar Empresa';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $empresa = $em->getRepository('AdminBundle:Empresa')->findOneBy(array('id' => $id));

        
        $data = array();

        $data['id']                = $empresa->getId();
        $data['nombre']            = $empresa->getNombre();
        $data['rsocial']           = $empresa->getRazonsocial();
        $data['rut']               = $empresa->getRut();
        
        $data['comuna']            = $empresa->getComuna();
        $data['provincia']         = $empresa->getProvincia();
        $data['region']            = $empresa->getRegion();
        $data['dir_villa_pobl']    = $empresa->getDirVillaPbla();
        $data['dir_calle']         = $empresa->getDirCalle();
        $data['dir_numero']        = $empresa->getDirNumero();
        $data['dir_numero_depto']  = $empresa->getDirNumeroDepartamento();
        $data['dir_numero_piso']   = $empresa->getDirNumeroPiso();
        
        $data['telefono']          = $empresa->getTelefono();
        $data['celular']           = $empresa->getCelular();
        $data['email']             = $empresa->getCorreo();
        $data['web']               = $empresa->getWeb();
        $data['obs']               = $empresa->getObservacion();
        $data['coordenadas']       = $empresa->getCoordenadas();
        $data['imagen']            = $empresa->getImagen();

        // carga de datos con la lista de contactos vinculados a la empresa
        $lista_contempre = array();
        if( $cont_empre = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkEmpresa' => $id )) )
        {
            foreach($cont_empre as $value)
            {
                $datos = new stdClass();
                $datos->id_contacto            = $value->getId();
                $datos->pri_nombre_fkcont      = $value->getFkContacto()->getPrimerNombre();
                $datos->seg_nombre_fkcont      = $value->getFkContacto()->getSegundoNombre();
                $datos->apellido_pate_fkcont   = $value->getFkContacto()->getApellidoPaterno();
                $datos->apellido_mate_fkcont   = $value->getFkContacto()->getApellidoMaterno();
                
                $lista_contempre[]  = $datos;

            }
        }

        $region = $em->getRepository('AdminBundle:DefRegion')->findOneBy(array( 'regIdPk' => $empresa->getRegion()));
        $nombreRegion =$region->getRegRomano()." ".$region->getRegNombre();
        $provincia = $em->getRepository('AdminBundle:DefProvincia')->findOneBy(array( 'proIdPk' => $empresa->getProvincia()));
        $nombreProvincia = $provincia->getProNombre();
        $comuna = $em->getRepository('AdminBundle:DefComuna')->findOneBy(array( 'comIdPk' => $empresa->getComuna()));
        $nombreComuna = $comuna->getComNombre();

        $lista_regiones = $em->getRepository('AdminBundle:DefRegion')->findAll();        
        $lista_provincias = $em->getRepository('AdminBundle:DefProvincia')->findBy(array('proRegionFk'=>$empresa->getRegion()));        
        $lista_comunas = $em->getRepository('AdminBundle:DefComuna')->findBy(array('comProvinciaFk'=>$empresa->getProvincia()));           

        return $this->render('AdminBundle:Empresas:nuevo.html.twig',array(
            'titulo'           => $titulo,
            'data'             => $data,
            'lista_regiones'   => $lista_regiones,
            'lista_provincias' => $lista_provincias,
            'lista_comunas'    => $lista_comunas,
            'nombreRegion'     => $nombreRegion,
            'nombreProvincia'  => $nombreProvincia,
            'nombreComuna'     => $nombreComuna,
            'lista_contempre'  => $lista_contempre,
            'submenu'          => 'empresa_nueva',
            'form'             => 'activo',
            'menu_o_con'       => 'empresa'
        ));
    }

    // eliminar empresa
    public function empresaEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $data = $em->getRepository('AdminBundle:Empresa')->findOneBy(array('id' => $id,'estado' => 1)) )
        {
            $data->setEstado(0);
            $em->persist($data);
            $em->flush();
        }

        echo json_encode(array(true));
        exit;
    }

    // subir imagen al servidor
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/empresa'
            );
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                $imagen->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }


    // ajax buscar contacto 
    public function buscarcontactoAction(Request $request)
    {
        $data = $request->get('busq_cont');
        
        $em = $this->getDoctrine()->getManager();
 
        $query = $em->createQuery(''
                . 'SELECT c.id, c.primerNombre, c.segundoNombre, c.apellidoPaterno ,c.apellidoMaterno '
                . 'FROM AdminBundle:Contacto c ' 
                . 'WHERE c.primerNombre LIKE :data '
                . 'OR c.segundoNombre LIKE :data '
                . 'OR c.apellidoPaterno LIKE :data '
                . 'OR c.apellidoMaterno LIKE :data '
                . 'AND c.estado = 1'
                . 'ORDER BY c.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getResult();
        
        $contactoLista = '';
        foreach ($results as $result) {
            $bold_prinombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['primerNombre']);
            $bold_segnombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['segundoNombre']);
            $bold_apellpat = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['apellidoPaterno']);
            $bold_apellmat = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['apellidoMaterno']);
            $contactoLista .= '<li class="ele" role="presentation"><span role="menuitem" data-id="'.$result['id'].'" data-name="'.$result['primerNombre'].'"  data-apellido="'.$result['apellidoPaterno'].'">'.$bold_prinombre.' '.$bold_segnombre.' '.$bold_apellpat.' '.$bold_apellmat.'</span></li>';
        }
 
        $response = new JsonResponse();
        $response->setData(array('contactoLista' => $contactoLista));
        
        return $response;
    }

    // ajax guardar relaciones empresa-cliente
    public function ajax_guardar_contactoAction(Request $request)
    {
        $id = (false);
        $id_cont = $request->get('id_cont');
        $id_empre = $request->get('id_empre');
        $valid = false;

        if( $request->getMethod() == 'POST' )
        {
            $em = $this->getDoctrine()->getManager();

            $Fkcontacto = $em->getRepository('AdminBundle:Contacto')->findOneBy(array('id' => $id_cont));            
            $Fkempresa  = $em->getRepository('AdminBundle:Empresa')->findOneBy(array('id' => $id_empre));

            if( !$cli_empre = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array( 'fkContacto' => $id_cont,'fkEmpresa'=>$id_empre )) )
            {
                $cli_empre = new ContacEmpre();
                $cli_empre->setFkContacto($Fkcontacto);
                $cli_empre->setFkEmpresa($Fkempresa);
                $em->persist($cli_empre);
                $em->flush();
                $valid = true;
            }

        }

        $response = new JsonResponse();
        $response->setData(array('valid'=>$valid,'cli_empre' => $cli_empre->getId()));
        
        return $response;
    }

    // ajax para quitar clientes viculadas a empresas
    public function ajax_borrar_contactoAction(Request $request)
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
    public function cargarProvinciasAction(Request $request){

        $data = $request->get('id_region');

        $em = $this->getDoctrine()->getManager();

        $provincias = $em->getRepository('AdminBundle:DefProvincia')->findBy(array('proRegionFk'=>$data)); 

        $lista_provincias = '';
        foreach ($provincias as $result) {
            if($lista_provincias==''){
                $lista_provincias .= '<option value="">Seleccione Provincia</option>';
            }
            $lista_provincias .= '<option value="'.$result->getProIdPk().'">' .$result->getProNombre(). '</option>';
        }
        $response = new JsonResponse();
        $response->setData(array('provincias' => $lista_provincias));
        
        return $response;
    }

    public function cargarComunasAction(Request $request)
    {
        $data = $request->get('id_provincia');
        $em = $this->getDoctrine()->getManager();
        $comunas = $em->getRepository('AdminBundle:DefComuna')->findBy(array('comProvinciaFk'=>$data)); 
        $lista_comunas = '';
        foreach ($comunas as $result) {
            if($lista_comunas==''){
                $lista_comunas .= '<option value="">Seleccione Comuna</option>';
            }
            $lista_comunas .= '<option value="'.$result->getComIdPk().'">' .$result->getComNombre(). '</option>';
        }
        $response = new JsonResponse();
        $response->setData(array('comunas' => $lista_comunas));
        
        return $response;
    }
    public function cargarLocalizacionAction(Request $request){

        $pkcomuna    = $request->get('id_comuna');
        $pkprovincia = $request->get('id_provincia'); 
        $em = $this->getDoctrine()->getManager();

        $comuna = $em->getRepository('AdminBundle:DefComuna')->findOneBy(array('comIdPk'=>$pkcomuna));
        $provincia = $em->getRepository('AdminBundle:DefProvincia')->findOneBy(array('proIdPk'=>$pkprovincia));

        $name_comuna    =  '<option value="'.$pkcomuna.'">' .$comuna->getComNombre(). '</option>';
        $name_provincia    =  '<option value="'.$pkprovincia.'">' .$provincia->getProNombre(). '</option>';
      //  $name_comuna    = $comuna->getComNombre();
       // $name_provincia = $provincia->getProNombre();

        $response = new JsonResponse();
        $response->setData(array('nameComuna' => $name_comuna, 'nameProvincia'=>$name_provincia));
        
        return $response;
    }
}