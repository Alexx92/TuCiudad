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

        $em = $this->getDoctrine()->getManager();        
        $listaCategorias = $em->getRepository('AdminBundle:Categorias')->findAll();
        $fecha = new \DateTime(date("d-m-Y H:i:s"));
        
        return $this->render('AdminBundle:Producto:nuevo.html.twig',array(
            'titulo'          =>  $titulo,
            'liscat'          =>  null,
            'listaCategorias' =>  $listaCategorias,            
            'fecha'           => $fecha,
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
    // guarda nuevo producto a cotizar con categoria A COTIZAR
    public function productoGuardarACotizarAction(Request $request)
    {
        $result = false;
        $isEdit = true;
        if( $request->getMethod() == 'POST' )
        {
            // captura de datos desde el formulario
            $id               = ($request->get('id_prod_cot', false)) ? $request->get('id_prod_cot'): 0;
            $prod_nombre      = ucfirst($request->get('prod_nombre'));
            $observacion      = ucfirst($request->get('prod_obs'));
            $em = $this->getDoctrine()->getManager();
            if( !$producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array( 'id' => $id )) )
            {
                $producto = new Producto();
                $producto->setEstado(1);
                $producto->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
                $isEdit = false;
            }
            $producto->setNombre($prod_nombre);
            $producto->setObservacion($observacion);
            // $producto->setTipo($valorCheck);           
            $em->persist($producto);
            $em->flush();       
            
            $categoria_producto = new ProductoCategoria();
            $categoria_producto->setFkCategoria($em->getRepository('AdminBundle:Categorias')->findOneBy(array('id'=>1)));
            $categoria_producto->setFkProducto($producto);
            $em->persist($categoria_producto);
            $em->flush();
            $result = true;
            $id_newb = $producto->getId();
        }

        $response = new JsonResponse();
        $response->setData(array('isEdit'=>$isEdit,'result' => $result, 'id_newb' => $id_newb,'id'=>$id));
        
        return $response;
    }
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
            // $prod_descp       = ucfirst($request->get('prod_descp'));
            $prod_valor       = $request->get('prod_valor');
            /*valor de id de select categoria*/
             $valselect        = $request->get('selectCat');
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
            // $producto->setDescripcion($prod_descp);
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
            
            if (!$categoria_producto = $em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array('fkProducto'=>$producto->getId(),'fkCategoria'=>$valselect))) {
                $categoria_producto = new ProductoCategoria();
                $categoria_producto->setFkCategoria($em->getRepository('AdminBundle:Categorias')->findOneBy(array('id'=>$valselect)));
                $categoria_producto->setFkProducto($producto);
                $em->persist($categoria_producto);
                $em->flush();  
                
            }



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
        // $data['prod_descp']    = $producto->getDescripcion();
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
               $datos->id                    = $value->getId();
               $datos->fkproducto            = $value->getFkProducto()->getId();
               $datos->fkcategoria           = $value->getFkCategoria()->getId();              
               $datos->nombre           = $value->getFkCategoria()->getNombre();              
               $lcategoria[]  = $datos;
           }
        }
       // $listaCategorias = $em->getRepository('AdminBundle:Categorias')->findAll();
        return $this->render('AdminBundle:Producto:nuevo.html.twig',array(
            'titulo'          => $titulo,
            'data'            => $data,
            'liscat'          => $lcategoria,
           // 'listaCategorias' =>  $listaCategorias,            
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
        $response->setData(array('cli_procat' => $cli_procat->getId()));        
        return $response;
        //exit;
    }
    // ajax para quitar categoria viculadas a clientes
    public function ajax_borrar_categoriaAction(Request $request)
    {
        $id = $request->get('id');
        $em = $this->getDoctrine()->getManager();
        $isvalid = false;
        if ($delete = $em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array('id'=> $id)) )
        {
            $dql= " SELECT  op.id
                    FROM AdminBundle:ProductoCategoria op
                    where op.fkProducto=:id_producto and op.id!=:id_op";   
            $results= $em->createQuery($dql)
                    ->setParameter('id_producto', $delete->getFkProducto()->getId())
                    ->setParameter('id_op', $id)
                    ->getResult();
            if ($results) {
                $em->remove($delete);
                $em->flush();
                $isvalid = true;
            }            
        }
        $response = new JsonResponse();
        $response->setData(array('isvalid' => $isvalid));
        return $response;
    }
    //cargar todas las opciones por la categoria del producto
    public function cargarTodasOpcionesAction(Request $request)
    {
        $prod_id = $request->get('prod_id');
     
        $em = $this->getDoctrine()->getManager();
        $dql= " SELECT  op.id, op.nombre, op.valor,IDENTITY(op.unidadMedidaDimension, 'id') AS unidadMedidaDimension, IDENTITY(op.unidadMedidaPeso,'id') AS unidadMedidaPeso
                FROM AdminBundle:ProductoCategoria pc  INNER JOIN AdminBundle:OpcionesProducto op WITH pc.fkCategoria = op.categorias
                where pc.fkProducto=:id_producto";   
        $results= $em->createQuery($dql)
                    ->setParameter('id_producto', $prod_id)
                    ->getResult();

        $lista_opciones = '';
        foreach ($results as $result) {
            $nombreUnidad ="";
            if (isset($result['unidadMedidaDimension']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaDimension')->findOneBy(array('id'=>$result['unidadMedidaDimension']))) {
               $nombreUnidad= ' x ['.$opcion->getSigla().']';
            } else {
                if (isset($result['unidadMedidaPeso']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaPeso')->findOneBy(array('id'=>$result['unidadMedidaPeso']))) {
                     $nombreUnidad= 'x ['.$opcion->getSigla().']';
                }
            }
            $lista_opciones .= '<li value="'.$result['id'].'">'.$result['nombre'].', $ '.$result['valor'].' '.$nombreUnidad.'</li>';
        }       
        $allCategoriasProducto = $em->getRepository('AdminBundle:ProductoCategoria')->findBy(array('fkProducto'=>$prod_id));
        $listaAllCategoriasProducto='';
        foreach ($allCategoriasProducto as $value) {
            $listaAllCategoriasProducto.='<div class="valign-wrapper"  id ="'.$value->getId().'"><i onClick="functionDelete('.$value->getId().' )"class="material-icons del_btn_i pointer">remove_circle_outline</i>'.$value->getFkCategoria()->getNombre().'</div>';            
        }
        $response = new JsonResponse();
        $response->setData(array('lista_opciones'=>$lista_opciones,'listaAllCategoriasProducto'=>$listaAllCategoriasProducto));
        return $response;
    }
    //carga todas las categorias por id_producto
    public function cargaCategoriasProductoIdAction(Request $request)
    {
        $id_producto  = $request->get('prod_id');
        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
       // $detalle = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id'=>$id_producto));
        $lista_categorias="";        
        if ($categorias = $em->getRepository('AdminBundle:ProductoCategoria')->findBy(array('fkProducto'=>$id_producto))){
            foreach ($categorias as $result) {
                if($lista_categorias==''){
                       $lista_categorias .= '<option value="">Seleccione</option>';
                    }
                $lista_categorias .= '<option value="'.$result->getFkCategoria()->getId().'">'.$result->getFkCategoria()->getNombre(). '</option>';
            }
        }
        $response = new JsonResponse();
        $response->setData(array('lista_categorias'=>$lista_categorias));
        return $response;
    }
        //carga todas las categorias por id_detallePedido
    public function cargaCategoriasProductoIdDetalleAction(Request $request)
    {
        $id_detalle  = $request->get('id_detalle');

        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));

        $lista_categorias="";
        if ($categorias = $em->getRepository('AdminBundle:ProductoCategoria')->findBy(array('fkProducto'=>$detalle->getFkProducto()->getId()))){
            foreach ($categorias as $result) {
                if($lista_categorias==''){
                       $lista_categorias .= '<option value="">Seleccione</option>';
                }
                $lista_categorias .= '<option value="'.$result->getFkCategoria()->getId().'">'.$result->getFkCategoria()->getNombre(). '</option>';
            }
        }
        $response = new JsonResponse();
        $response->setData(array('lista_categorias'=>$lista_categorias));
        return $response;
    }
        //carga todas las categorias por id_detallePedido
    public function cargarProductoPorIdAction(Request $request)
    {
        $id_prod  = $request->get('id_prod');

        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id'=>$id_prod));
      
        $response = new JsonResponse();
        $response->setData(array('nombre'=>$producto->getNombre(),'observacion'=>$producto->getObservacion()));
        return $response;
    }
}