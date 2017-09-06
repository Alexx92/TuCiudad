<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Personal;

use \stdClass;

class PersonalController extends Controller
{
    public function personalIndexAction()
    {

        return $this->render('AdminBundle:Personal:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'personal',
            'menu_o_con'   => 'personal'
        ));
    }

    public function personalNuevoAction()
    {
        $titulo  = 'Nuevo Personal';
         $em = $this->getDoctrine()->getManager();
        $lista_regiones = $em->getRepository('AdminBundle:DefRegion')->findAll();    
        $lista_departamento = $em->getRepository('AdminBundle:Departamento')->findAll();

        return $this->render('AdminBundle:Personal:nuevo.html.twig',array(
            'titulo'            =>  $titulo,
            'lista_regiones'    => $lista_regiones,
            'lista_provincias'  => null,
            'lista_comunas'     => null,
            'nombreRegion'      => null,
            'nombreProvincia'   => null,
            'nombreComuna'      => null,
            'nombreArea'        => null,
            'nombreDepartamento'=>null,
            'lista_departamento'=> $lista_departamento,
            'lista_area'        => null,
            'menu'              => 'nuevo',
            'menu_o_con'        => 'personal',
            'submenu'           => 'personal_nuevo'
        ));
    }

    // carga la taba de contactos en el index
    public function personalCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $where = array('estado' => 1);

        $lista_personal = array();

        if($personal = $em->getRepository('AdminBundle:Personal')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($personal as $value)
            {
                $datos = new stdClass();
                
                $datos->id                 = $value->getId();
                $datos->primer_nombre      = $value->getPrimerNombre();
                $datos->apellido_paterno   = $value->getSegundoNombre();
                $datos->email              = $value->getCorreo();
                $datos->celular            = $value->getCelular();
                
                $lista_personal[]  = $datos;

            }
        }

        return $this->render('AdminBundle:Layouts:tabla_personal_index.html.twig', array(
            'lista_personal' => $lista_personal
        ));
    }

    // guarda nuevo personal
    public function personalGuardarAction(Request $request)
    {
        $result = false;
        $valid = false;//Retorna respuesta a script en caso de existir en la base de datos un run igual

        if( $request->getMethod() == 'POST' )
        {                  
            // captura de datos desde el formulario
            $id                        = ($request->get('personal_id', false)) ? $request->get('personal_id'): 0;
            $primer_nombre             = ucfirst($request->get('primer_nombre'));
            $segundo_nombre            = ucfirst($request->get('segundo_nombre'));
            $apellido_paterno          = ucfirst($request->get('apellido_paterno'));
            $apellido_materno          = ucfirst($request->get('apellido_materno'));
            $dni                       = $request->get('dni');
            $sexo                      = $request->get('sexo');
            $date = $request->get('fecha_nacimiento'); 
			$fecha_nacimiento = new \DateTime(date("d-m-Y H:i:s", strtotime($date)));         
            $comuna                    = ucfirst($request->get('comunas'));
            $provincia                 = ucfirst($request->get('provincias'));
            $region                    = ucfirst($request->get('regiones'));
            $dir_villa_pobl            = ucfirst($request->get('dir_villa_pobl'));
            $dir_calle                 = ucfirst($request->get('dir_calle'));
            $dir_numero_casa           = $request->get('dir_numero_casa');
            $dir_numero_depto          = $request->get('dir_numero_depto');
            $dir_numero_piso           = $request->get('dir_numero_piso');
            $telefono                  = $request->get('telefono');
            $celular                   = $request->get('celular');
            $email                     = $request->get('email');
            $skype                     = $request->get('skype');
            $area                      = $request->get('areas');

            $observacion               = ucfirst($request->get('obs'));
            $imagen                    = ($request->files->get('img_personal', false))? $request->files->get('img_personal'): null;

            $em = $this->getDoctrine()->getManager();

            if( !$personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array( 'id' => $id )) )
            {//se trata de una persona nueva
                $personal = new Personal();
                $personal->setEstado(1);
                $personal->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
                $personal->setEstadoPersonal($em->getRepository('AdminBundle:EstadoPersonal')->findOneBy(array('id'=>2)));
            }
            if ($personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array( 'dni' => $dni ))) {//valida que no alla una persona con el mismo rut
                if ($personal->getId()==$id) {                
                    $valid = true; //actualizo la variable que valida el ingreso
                    $personal->setArea($em->getRepository('AdminBundle:Area')->findOneBy(array('id'=>1)));
                    $personal->setPrimerNombre($primer_nombre);
                    $personal->setSegundoNombre($segundo_nombre);
                    $personal->setApellidoPaterno($apellido_paterno);
                    $personal->setApellidoMaterno($apellido_materno);
                    $personal->setDni($dni);
                    $personal->setSexo($sexo);
                    $personal->setFechaNacimiento($fecha_nacimiento);
                    $personal->setComuna($comuna);
                    $personal->setProvincia($provincia);
                    $personal->setRegion($region);
                    $personal->setDirVillaPbla($dir_villa_pobl);
                    $personal->setDirCalle($dir_calle);
                    $personal->setDirNumeroCasa($dir_numero_casa);
                    $personal->setDirNumeroDepartamento($dir_numero_depto);
                    $personal->setDirNumeroPiso($dir_numero_piso);
                    $personal->setTelefono($telefono);
                    $personal->setCelular($celular);
                    $personal->setCorreo($email);
                    $personal->setSkype($skype);
                    $personal->setObservacion($observacion);
                    // guardar imagen
                    if ($imagen)
                    {
                        $dir_image = $this->subirImagen($imagen);
                        $personal->setImagen($dir_image);
                    }    
                    $em->persist($personal);
                    $em->flush();
        
                    $result = true;
                }
            }

            

        }
        $response = new JsonResponse();
        $response->setData(array('result' => $result,'valid'=>$valid));        
        return $response;
        // //return $this->redirectToRoute('admin_contacto_nuevo');
        // echo json_encode(array('result' => $result));
        // exit;
    }

    // cargar formulario para editar
    public function personalEditarAction(Request $request)
    {

        $titulo  = 'Editar Personal';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('id' => $id));        
        
        $data = array();

        $data['id']                = $personal->getId();
        $data['primer_nombre']     = $personal->getPrimerNombre();
        $data['segundo_nombre']    = $personal->getSegundoNombre();
        $data['apellido_paterno']  = $personal->getApellidoPaterno();
        $data['apellido_materno']  = $personal->getApellidoMaterno();
        
        $data['dni']               = $personal->getDni();
        $data['sexo']              = $personal->getSexo();
        $sexo = ($personal->getSexo() == 1) ? "Hombre" : "Mujer" ;
        $data['fecha_nacimiento'] = date_format($personal->getFechaNacimiento(), 'd-m-Y');
        
        $data['comuna']            = $personal->getComuna();
        $data['provincia']         = $personal->getProvincia();
        $data['region']            = $personal->getRegion();
        $data['dir_villa_pobl']    = $personal->getDirVillaPbla();
        $data['dir_calle']         = $personal->getDirCalle();
        $data['dir_numero_casa']   = $personal->getDirNumeroCasa();
        $data['dir_numero_depto']  = $personal->getDirNumeroDepartamento();
        $data['dir_numero_piso']   = $personal->getDirNumeroPiso();
        
        $data['telefono']          = $personal->getTelefono();
        $data['celular']           = $personal->getCelular();
        $data['email']             = $personal->getCorreo();
        $data['skype']             = $personal->getSkype();
        $data['obs']               = $personal->getObservacion();
        $data['imagen']            = $personal->getImagen();

        $data['area']              = $personal->getArea()->getId();


        
        $region = $em->getRepository('AdminBundle:DefRegion')->findOneBy(array( 'regIdPk' => $personal->getRegion()));
        $nombreRegion =$region->getRegRomano()." ".$region->getRegNombre();
        $provincia = $em->getRepository('AdminBundle:DefProvincia')->findOneBy(array( 'proIdPk' => $personal->getProvincia()));
        $nombreProvincia = $provincia->getProNombre();
        $comuna = $em->getRepository('AdminBundle:DefComuna')->findOneBy(array( 'comIdPk' => $personal->getComuna()));
        $nombreComuna = $comuna->getComNombre();

        $area = $em->getRepository('AdminBundle:Area')->findOneBy(array( 'id' => $personal->getArea()));
        $nombreArea = $area->getNombre();

        $departamento = $em->getRepository('AdminBundle:Departamento')->findOneBy(array( 'id' => $area->getDepartamento()));
        $nombreDepartamento = $departamento->getNombre();
        $data['depa'] = $departamento->getId();
        $lista_regiones     = $em->getRepository('AdminBundle:DefRegion')->findAll();        
        $lista_provincias   = $em->getRepository('AdminBundle:DefProvincia')->findBy(array('proRegionFk'=>$personal->getRegion()));        
        $lista_comunas      = $em->getRepository('AdminBundle:DefComuna')->findBy(array('comProvinciaFk'=>$personal->getProvincia()));  

        $lista_departamento = $em->getRepository('AdminBundle:Departamento')->findAll();
        $lista_area         = $em->getRepository('AdminBundle:Area')->findBy(array('departamento'=>$departamento->getId()));

        return $this->render('AdminBundle:Personal:nuevo.html.twig',array(
            'titulo'            => $titulo,
            'data'              => $data,
            'lista_regiones'    => $lista_regiones,
            'lista_provincias'  => $lista_provincias,
            'lista_comunas'     => $lista_comunas,
            'nombreRegion'      => $nombreRegion,
            'nombreProvincia'   => $nombreProvincia,
            'nombreComuna'      => $nombreComuna,
            'nombreArea'        => $nombreArea,
            'nombreDepartamento'=> $nombreDepartamento,
            'lista_departamento'=> $lista_departamento,
            'lista_area'        => $lista_area,
            'sexo'              => $sexo,
            'submenu'           => 'personal_nuevo',
            'form'              => 'activo',
            'menu_o_con'        => 'personal'
        ));
    }
    
    // elimanr un personal
    public function personalEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('id' => $id,'estado' => 1)) )
        {
            $personal->setEstado(0);
            $em->persist($personal);
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/personal'
            );
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                $imagen->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
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
    public function cargarAreaAction(Request $request)
    {
        $data = $request->get('id_departamento');
        $em = $this->getDoctrine()->getManager();
        $areas = $em->getRepository('AdminBundle:Area')->findBy(array('departamento'=>$data)); 
        $lista_areas = '';
        foreach ($areas as $result) {
            if($lista_areas==''){
                $lista_areas .= '<option value="">Seleccione Area</option>';
            }
              $lista_areas .= '<option value="'.$result->getId().'">' .$result->getNombre(). '</option>';
           
        }
        $response = new JsonResponse();
        $response->setData(array('areas' => $lista_areas));
        
        return $response;
    }

}
