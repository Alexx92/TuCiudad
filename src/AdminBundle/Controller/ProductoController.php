<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Producto;
use AdminBundle\Entity\ProductoCategoria;
use AdminBundle\Entity\Categorias;

use \stdClass;

class ProductoController extends Controller
{
    public function productoIndexAction()
    {

        return $this->render('AdminBundle:Producto:index.html.twig',array(
            'menu'         => 'index',
            'submenu'      => 'producto',
            'menu_o_con'   => 'producto'
        ));
    }

    public function productoNuevoAction()
    {
        $titulo  = 'Nuevo Producto / Servicio';
         

        return $this->render('AdminBundle:Producto:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'liscat'          =>  null,
            'menu'            => 'nuevo',
            'menu_o_con'      => 'producto',
            'submenu'         => 'producto_nuevo'
        ));
    }

    // carga la taba de producto en el index
    public function productoCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

        $where = array('estado' => 1);

        $lista_producto = array();

        if($producto = $em->getRepository('AdminBundle:Producto')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($producto as $value)
            {
                $datos = new stdClass();
                
                $datos->id            = $value->getId();
                $datos->prod_nombre   = $value->getNombre();
                $datos->prod_cod      = $value->getCodigoProd();
                $datos->prod_valor    = $value->getValorUnitario();
                
                $lista_producto[]  = $datos;

            }
        }

        return $this->render('AdminBundle:Layouts:tabla_producto_index.html.twig', array(
            'lista_producto' => $lista_producto
        ));
    }

    // guarda nuevo producto
    public function productoGuardarAction(Request $request)
    {
        $result = false;
        //$namecat = $request->get('namecat');

        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id               = ($request->get('prod_id', false)) ? $request->get('prod_id'): 0;
            $prod_nombre      = ucfirst($request->get('prod_nombre'));
            $prod_codigo      = $request->get('prod_codigo');
            $prod_descp       = ucfirst($request->get('prod_descp'));
            $prod_valor       = $request->get('prod_valor');
            /*valor de id de select categoria*/
            //$valselect        = $request->get('selectcat');
            $valorCheck       = $request->get('check');
            $tiempoProduccion = $request->get('time');

            $observacion      = ucfirst($request->get('prod_obs'));
            $imagen           = ($request->files->get('prod_imagen', false))? $request->files->get('prod_imagen'): null;

            $em = $this->getDoctrine()->getManager();
            if( !$producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array( 'id' => $id )) )
            {
                $producto = new Producto();
                $producto->setEstado(1);                
                $producto->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));            
            }

            $producto->setNombre($prod_nombre);
            $producto->setCodigoProd($prod_codigo);
            $producto->setDescripcion($prod_descp);
            $producto->setValorUnitario($prod_valor);                
            $producto->setObservacion($observacion);
            $producto->setTipo($valorCheck);
            $producto->setTiempoApxProduccion($tiempoProduccion);

            // guardar imagen
            if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $producto->setImagen($dir_image);
            }          
            $em->persist($producto);
            $em->flush();       
            
            $result = true;

            $id_newb = $producto->getId();
        }

        $response = new JsonResponse();
        $response->setData(array('result' => $result, 'id_newb' => $id_newb));
        
        return $response;
    }

    // cargar formulario para editar
    public function productoEditarAction(Request $request)
    {
        $titulo  = 'Editar Producto/Servicio';
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();
        $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id' => $id));      
        
        $data = array();
        $data['id']            = $producto->getId();
        $data['prod_nombre']   = $producto->getNombre();
        $data['prod_codigo']   = $producto->getCodigoProd();
        $data['prod_descp']    = $producto->getDescripcion();
        $data['prod_valor']    = $producto->getValorUnitario();
        $data['tipo']          = $producto->getTipo();        
        $data['observacion']   = $producto->getObservacion();
        $data['imagen']        = $producto->getImagen();
        $data['time']          = $producto->getTiempoApxProduccion();

        // carga de datos con la lista de contactos vinculados a la empresa
        $lcategoria = array();
        if( $cont_empre = $em->getRepository('AdminBundle:ProductoCategoria')->findBy(array( 'fkProducto' => $id )) )
        {
           foreach($cont_empre as $value)
           {
               $datos = new stdClass();                
               $datos->id            = $value->getId();
               $datos->fkproducto            = $value->getFkProducto()->getId();
               $datos->fkcategoria           = $value->getFkCategoria()->getId();              
               $datos->nombre           = $value->getFkCategoria()->getNombre();              
               $lcategoria[]  = $datos;
           }
        }
        return $this->render('AdminBundle:Producto:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'data'            => $data,
            'liscat'         => $lcategoria,
            'submenu'         => 'producto_nuevo',
            'menu_o_con'      => 'producto'
        ));
    }
    
    // elimanr un producto
    public function productoEliminarAction(Request $request)
    {
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();

        if( $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id' => $id,'estado' => 1)) )
        {
            $producto->setEstado(0);
            $em->persist($producto);
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
                'filenewpath'   => __DIR__.'/../../../web/uploads/producto'
            );
            if($obj['filetype'] == 'image/png' || $obj['filetype'] == 'image/jpeg')
            {
                $imagen->move($obj['filenewpath'], $obj['filenewname']);
                $result = $obj['filenewname'];
            }
        }
        return $result;
    }
    private function cargarDropdown()
    {
        $em = $this->getDoctrine()->getManager();
        $where = array('estado' => 1);
        $listadoCategoria = array();
        if($producto = $em->getRepository('AdminBundle:Categorias')->findBy($where, array('id' => 'ASC')) )
        {
            foreach($producto as $value)
            {
                $datos = new stdClass();                
                $datos->id            = $value->getId();
                $datos->nombre   = $value->getNombre();      
                $listadoCategoria[]  = $datos;
            }
        }
        return $listadoCategoria;      
    }
    // ajax buscar categorias 
    public function buscarDataAction(Request $request)
    {
        $data = $request->get('bosq_box');        
        $em = $this->getDoctrine()->getManager();
        
         $query = $em->createQuery(''
                . 'SELECT c.id, c.nombre '
                . 'FROM AdminBundle:Categorias c ' 
                . 'WHERE (c.nombre LIKE :data ) '
                . 'ORDER BY c.nombre ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getResult(); 
        $catLista = '';
        foreach ($results as $result) {
            $catLista .= '<li class="ele" role="presentation"><span role="menuitem" data-id="'.$result['id'].'" data-name="'.$result['nombre'].'">'.$result['nombre'].'</span></li>';
        }
 
        $response = new JsonResponse();
        $response->setData(array('catLista' => $catLista));
        
        return $response;
    }

    // ajax guardar relaciones producto-categoria
    public function ajax_guardar_categoriaAction(Request $request)
    {
        $id = (false);
        $id_cont = $request->get('id_cont');
        $namecat = $request->get('namecat');
        $idcat = $request->get('idcat');

        if( $request->getMethod() == 'POST' )
        {
            $em = $this->getDoctrine()->getManager();

            $Fkcategoria = $em->getRepository('AdminBundle:Categorias')->findOneBy(array('id' => $idcat));            
            $fkproducto  = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id' => $id_cont));

            if( !$cli_procat = $em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array( 'fkProducto' => $id_cont, 'fkCategoria' => $idcat  )) )
            {
                $cli_procat = new ProductoCategoria();
                $cli_procat->setFkCategoria($Fkcategoria);
                $cli_procat->setFkProducto($fkproducto);
                $em->persist($cli_procat);
                $em->flush();
            }
        }
        $response = new JsonResponse();
        $response->setData(array('cli_procat' => $cli_procat));
        
        return $response;
        exit;
    }
    // ajax para quitar categoria viculadas a clientes
    public function ajax_borrar_categoriaAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        
        if ($delete = $em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array('id' => $id)))
        {
            $em->remove($delete);
            $em->flush();
        }
        echo json_encode(array(true));
       // dump($id);
        exit;
    }
}