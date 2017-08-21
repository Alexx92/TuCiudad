<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Categorias;

use \stdClass;

class CategoriasController extends Controller
{
    public function CategoriasIndexAction()
    {

        return $this->render('AdminBundle:Categorias:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'Categorias',
            'menu_o_con'   => 'Categorias'
        ));
    }

    public function CategoriasNuevoAction()
    {
        $titulo  = 'Nueva Categoria';
        $fecha = new \DateTime(date("d-m-Y H:i:s"));

        return $this->render('AdminBundle:Categorias:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'fecha'           =>  $fecha,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'Categorias',
            'submenu'         => 'Categorias_nuevo'
        ));
    }

    // carga la taba de Categorias en el index
    public function CategoriasCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $where = array('estado' => 1);

        $lista_Categorias = array();

        if($Categorias = $em->getRepository('AdminBundle:Categorias')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($Categorias as $value)
            {
                $datos = new stdClass();
                
                $datos->id             = $value->getId();
                $datos->cat_nombre     = $value->getNombre();
                $datos->imagen         = $value->getImagen();
                $datos->fechaIngreso   = $value->getFechaIngreso();
                
                $lista_Categorias[]    = $datos;

            }
        }

        return $this->render('AdminBundle:Layouts:tabla_categorias_index.html.twig', array(
            'lista_Categorias' => $lista_Categorias
        ));
    }

    // guarda nuevo Categorias
    public function CategoriasGuardarAction(Request $request)
    {
        $result = false;
        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id               = ($request->get('cat_id', false)) ? $request->get('cat_id'): 0;
            $cat_nombre       = ucfirst($request->get('cat_nombre'));
            $imagen           = ($request->files->get('cat_imagen', false))? $request->files->get('cat_imagen'): null;
            $em = $this->getDoctrine()->getManager();
            if( !$Categorias = $em->getRepository('AdminBundle:Categorias')->findOneBy(array( 'id' => $id )) )
            {
                $Categorias = new Categorias();
                $Categorias->setEstado(1);                
                $Categorias->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
            }
            $Categorias->setNombre($cat_nombre);
            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $Categorias->setImagen($dir_image);
            }

            $em->persist($Categorias);
            $em->flush();
            
           
            $result = true;

        }

        echo json_encode(array('result' => $result));
        exit;
    }
    // guarda nuevo Categoria en Producto
    public function categoriasGuardarProductoAction(Request $request)
    {
             // captura de datos desde el formulario
             $id               = ($request->get('cat_id', false)) ? $request->get('cat_id'): 0;
             
            $cat_nombre       = ucfirst($request->get('cat_nombre'));
            $imagen           = ($request->files->get('cat_imagen', false))? $request->files->get('cat_imagen'): null;
            $em = $this->getDoctrine()->getManager();
            if( !$Categorias = $em->getRepository('AdminBundle:Categorias')->findOneBy(array( 'id' => $id )) )
            {
                $Categorias = new Categorias();
                $Categorias->setEstado(1);
                $Categorias->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
            }
            $Categorias->setNombre($cat_nombre);
            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $Categorias->setImagen($dir_image);
            }

            $em->persist($Categorias);
            $em->flush();    

            $lista_categorias = $em->getRepository('AdminBundle:Categorias')->findAll();
            $listadoXcas="";        
            foreach ($lista_categorias as $result) {
                if($listadoXcas==''){
                       $listadoXcas .= '<option value="">Seleccione</option>';
                }                   
                $listadoXcas .= '<option value="'.$result->getId().'">'.$result->getNombre().'</option>';
            }
            $response = new JsonResponse();
            $response->setData(array('listadoXcas' => $listadoXcas));            
            return $response;
    }

    // cargar formulario para editar
    public function CategoriasEditarAction(Request $request)
    {

        $titulo  = 'Editar Categorias';

        $id = $request->get('id', false);

        $em = $this->getDoctrine()->getManager();

        $Categorias = $em->getRepository('AdminBundle:Categorias')->findOneBy(array('id' => $id));        
        
        $data = array();

        $data['cat_id']            = $Categorias->getId();
        $data['cat_nombre']   = $Categorias->getNombre();        
        $data['cat_fechaIngreso']   = $Categorias->getFechaIngreso();
        $data['cat_imagen']        = $Categorias->getImagen();
       
        return $this->render('AdminBundle:Categorias:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'data'            => $data,
            'submenu'         => 'categorias_nuevo',
            'menu_o_con'      => 'categorias'
        ));
       /*   dump($data);
        exit;*/
    }
    
    // elimanar un Categorias
    public function CategoriasEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $Categorias = $em->getRepository('AdminBundle:Categorias')->findOneBy(array('id' => $id)) )
        {
            $Categorias->setEstado(0);
            $em->persist($Categorias);
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/categoria'
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
