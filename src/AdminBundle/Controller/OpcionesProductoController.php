<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\OpcionesProducto;

use \stdClass;

class OpcionesProductoController extends Controller
{
    public function contactoIndexAction()
    {

        return $this->render('AdminBundle:OpcionesProducto:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'opcionesproducto',
            'menu_o_con'   => 'opcionesproducto'
        ));
    }

    public function opcionesProductoNuevoAction()
    {
        $titulo  = 'Nueva Opcion de Producto';

        return $this->render('AdminBundle:OpcionesProducto:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'opcionesproducto',
            'submenu'         => 'opcionesproducto_nuevo'
        ));
    }
    // guarda nueva opcionesproducto
    public function opcionesProductoGuardarAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id                 = ($request->get('id_contacto', false)) ? $request->get('id_contacto'): 0;
            $nombre             = ucfirst($request->get('opcion_nombre'));
            $valor              = $request->get('opcion_valor');
            $observacion        = $request->get('opcion_obs');    
            $imagen             = ($request->files->get('contacto_img', false))? $request->files->get('contacto_img'): null;
            $id_unidades   = $request->get('opcion_unidades');
            $id_categoria   = $request->get('opcion_categorias');
            $em = $this->getDoctrine()->getManager();
            if( !$opcionProducto = $em->getRepository('AdminBundle:OpcionesProducto')->findOneBy(array( 'id' => $id )) )
            {
                $opcionProducto = new OpcionesProducto();                
            }
            $opcionProducto->setNombre($nombre);
            $opcionProducto->setValor($valor);
            $opcionProducto->setCategorias($em->getRepository('AdminBundle:Categorias')->findOneBy(array('id'=>$id_categoria)));
            $opcionProducto->setDescripcion($observacion);

            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $opcionProducto->setImagen($dir_image);
            }
            $em->persist($opcionProducto);
            $em->flush();
            $result = true;
            $id_new = $opcionProducto->getId();
        }

        $response = new JsonResponse();
        $response->setData(array('result' => $result, 'id_new' => $id_new));
        
        return $response;
    }
    public function ajaxOpcionesProductoGuardarAction(Request $request)
    {
        $nombre  = $request->get('nombre');            
        $valor   = $request->get('valor');
        $id_categoria   = $request->get('id_categoria');
        $observacion   = $request->get('observaciones');
        //$imagen  = ($request->files->get('contacto_img', false))? $request->files->get('contacto_img'): null;
        $em = $this->getDoctrine()->getManager();      
        $opcionProducto = new OpcionesProducto();
        $opcionProducto->setNombre($nombre);
        $opcionProducto->setValor($valor);
        $opcionProducto->setCategorias($em->getRepository('AdminBundle:Categorias')->findOneBy(array('id'=>$id_categoria)));
        $opcionProducto->setDescripcion($observacion);
        // // guardar imagen
        // if ($imagen)
        // {
        //     $dir_image = $this->subirImagen($imagen);
        //     $opcionProducto->setImagen($dir_image);
        // }
        $em->persist($opcionProducto);
        $em->flush();            
        $id_new = $opcionProducto->getId();        
        $response = new JsonResponse();
        $response->setData(array('id_new' => $id_new));
        
        return $response;
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/opcionesProducto'
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