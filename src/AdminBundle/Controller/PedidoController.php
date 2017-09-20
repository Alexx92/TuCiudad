<?php

namespace AdminBundle\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Empresa;
use AdminBundle\Entity\Pedidos;
use AdminBundle\Entity\ContacEmpre;
use AdminBundle\Entity\Personal;
use AdminBundle\Entity\PedidoDetalle;
use AdminBundle\Entity\EtapaProceso;
use AdminBundle\Entity\Etapa;
use AdminBundle\Entity\Producto;
use AdminBundle\Entity\DetallepedidoOpcionesproducto;
use AdminBundle\Entity\OpcionesProducto;
use AdminBundle\Entity\User;

use \stdClass;

class PedidoController extends Controller
{
    public function pedidoIndexAction()
    {
         return $this->render('AdminBundle:Pedidos:index.html.twig', array(
            'submenu'         => 'pedido',
            'menu_o_con'      => 'pedido'
         ));
    }   
    public function pedidoNuevoAction()
    {               
        // Titulo que se mostrara en la barra de navegacion
        $titulo = 'Nuevo Pedido';
        $fecha = new \DateTime(date("d-m-Y H:i:s"));
        
        return $this->render('AdminBundle:Pedidos:nuevo.html.twig', array(
            'titulo'                    => $titulo,
            'nombreContacto'            => null,
            'fecha'                     => $fecha,
            'lista_etapa_negociacion'   => null,
            'lista_contactos'           => null,
            'lista_opciones'            => null,
            'submenu'                   => 'pedido_nueva',
            'menu_o_con'                => 'pedido'
        ));
    }
    //Crear numero de cotizacion
    private function crearNumeroCotizacion($id_pedido)
    {
        $codigo = substr("0000000", 0,- strlen($id_pedido));
        $codigo.=$id_pedido;        
        return $codigo;
    }
    //carga taba
    public function pedidoCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $this->getUser();
        $user_email = $user->getEmail();           
        $id_personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('correo'=>$user_email))->getId();

        if ($this->isGranted('ROLE_TRABAJADOR')) {            
            $dql= " SELECT  op.id                    
                FROM AdminBundle:Pedidos op           
                INNER JOIN AdminBundle:PedidoDetalle pc
                WITH op.id = pc.fkPedido
                WHERE  op.etapa !=: id_etapa and pc.personal = :id_personal" ;

            $query= $em->createQuery($dql)
                        ->setParameter('id_etapa', 1 )
                        ->setParameter('id_personal', $id_personal );
            $results = $query->getResult();
        }
        if ($this->isGranted('ROLE_VENTA_A')) {
            $dql= " SELECT  op.id
                    FROM AdminBundle:Pedidos op
                    WHERE op.personal = :id_personal" ;

            $query= $em->createQuery($dql)
                        ->setParameter('id_personal', $id_personal );
            $results = $query->getResult();
        }
        if ($this->isGranted('ROLE_ADMIN_D')) {
            $results = $em->getRepository('AdminBundle:Pedidos')->findAll();
        }
        // $where = array('estado' => 1);
        $lista_pedidos = array();
        if (sizeof($results) > 0) {            
            foreach ($results as $result) {
                $value = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$result));
                $datos = new stdClass();                
                $datos->id                  = $value->getId();
                $datos->codigo_cotizacion   = $value->getCodigoCotizacion();                
                $datos->codigo_pedido       = $value->getCodigoPedido();
                $datos->fechaIngreso        = $value->getFechaIngreso();
                $datos->personal_nombre     = $value->getPersonal()->getPrimerNombre();
                $estado = $em->getRepository('AdminBundle:Etapa')->findOneBy(array('id'=>$value->getEtapa()));
                $datos->estado              = $estado->getNombre();
                $empresa = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array('id'=>$value->getContacEmpre()->getId()));
                $datos->empresa_nombre      = $empresa->getFkEmpresa()->getNombre();
               
                $lista_pedidos[]  = $datos;
            }
         
        }
        return $this->render('AdminBundle:Layouts:tabla_pedido_index.html.twig', array(
            'lista_pedidos' => $lista_pedidos
        ));
    }
    // guardar datos
    public function pedidoGuardarAction(Request $request)
    {
        $result = false;
        if ($request->getMethod() == 'POST') {
            $id_pedido      = ($request->get('ped_id', false)) ? $request->get('ped_id'): 0;
            $ped_obs        = $request->get('ped_obs');
            $ped_new_e_n    = $request->get('newEstadoNegociacion');
            /*Creacion de pedido*/
            $user = $this->getUser();//se obtiene el usuario del sistema
            $user_n = $user->getUserName();// obtencion de username del usuario actual
            $user_email = $user->getEmail();//obtencion del email del usuario actual
            $em = $this->getDoctrine()->getManager();
            /*Si el correo y el usuario existen como vendedor realiza el pedido */
            if ($personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('username'=>$user_n, 'correo'=>$user_email))) {
                $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido));
                $fechaActual = new \DateTime(date("d-m-Y H:i:s"));
                if ($pedido->getFechaIngreso() != $fechaActual)  {//verifica el cambio en fecha de modificacion
                    $pedido->setFechaModificacion($fechaActual);
                }
                if($pedido->getEtapa()->getId() == 6){//verifica el primer cambio en la etapa general del pedido 
                    $pedido->setEtapa($em->getRepository('AdminBundle:Etapa')->findOneBy(array('id'=>1)));
                    $pedido->setEtapaProceso($em->getRepository('AdminBundle:EtapaProceso')->findOneBy(array('id'=>1)));
                }else{
                    $pedido->setEtapaProceso($em->getRepository('AdminBundle:EtapaProceso')->findOneBy(array('id'=>$ped_new_e_n)));
                }
                $pedido->setObservacion($ped_obs);
                $em->persist($pedido);
                $em->flush();
                $result = true;
            }
        }
       echo json_encode(array('result' => $result));
       exit;
    }
    // cargar formulario para editarwhw
    public function pedidoEditarAction(Request $request)
    {
        $titulo  = 'Ver/Editar pedido';
        $id = $request->get('id', false);
        $em = $this->getDoctrine()->getManager();
        /*lleno el data de pedido*/
        $ObjPedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$id));
        $pedido = array();
        $pedido['id']                   = $ObjPedido->getId();
        $pedido['n_cot']                = $ObjPedido->getCodigoCotizacion();
        $pedido['cod_ped']              = $ObjPedido->getCodigoPedido();
        $pedido['fechaIngreso']         = $ObjPedido->getFechaIngreso();
        $pedido['fechaModificacion']    = $ObjPedido->getFechaModificacion();
        $pedido['descuento']            = ($ObjPedido->getDescuentos() > 0)? $ObjPedido->getDescuentos() : 0;
        $pedido['total']                = $ObjPedido->getTotal();
        $pedido['ivaActual']            = "19";
        // $pedido['ivaActual']            = $ObjPedido->getIvaActual();
        $pedido['valorNeto']            = $ObjPedido->getValorNeto();
        $pedido['obs']                  = $ObjPedido->getObservacion();
        $pedido['etapa']               = $em->getRepository('AdminBundle:Etapa')->findOneBy(array('id'=>$ObjPedido->getEtapa()));
        $pedido['estadoProceso']        = $em->getRepository('AdminBundle:EtapaProceso')->findOneBy(array('id'=>$ObjPedido->getEtapaProceso()));
        $pedido['montoDescuento']       = ($ObjPedido->getDescuentos() > 0 && $ObjPedido->getDescuentos() != "") ? ($ObjPedido->getDescuentos()/100)*$ObjPedido->getTotal() : 0;
        $pedido['totalImp']             = (1+(19/100))*$ObjPedido->getValorNeto();
     
        
        $contactoEmpre = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array( 'id' => $ObjPedido->getContacEmpre()))->getFkContacto();
        $lisContactEmpre = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkEmpresa' => $ObjPedido->getContacEmpre()->getFkEmpresa()));
        
        $pedido['id_contacto']   = $contactoEmpre->getId();

        /*lleno el data de empresa*/
        $empresa = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array('id' => $ObjPedido->getContacEmpre()))->getFkEmpresa();        
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

      
        if ($this->isGranted('ROLE_ADMIN_A')) {
            if ($ObjPedido->getEtapaProceso()->getId() != 6) {
                $dql= " SELECT  op.id, op.sigla, op. nombre
                        FROM AdminBundle:EtapaProceso op
                        WHERE  op.id != 6" ;
                $query= $em->createQuery($dql);
                $results = $query->getResult();
            }else{
                $results = $em->getRepository('AdminBundle:EtapaProceso')->findAll();
            }
        }else{
            if ($ObjPedido->getEtapaProceso()->getId()!= 6) {
                if ($ObjPedido->getEtapaProceso()->getId() == 2) {
                    $dql= " SELECT  op.id, op.sigla, op. nombre
                        FROM AdminBundle:EtapaProceso op
                        WHERE op.id != 6 and op.id != 4 and op.id !=1";
                    $query= $em->createQuery($dql);
                    $results = $query->getResult();
                }else{
                    $dql= " SELECT  op.id, op.sigla, op. nombre
                            FROM AdminBundle:EtapaProceso op
                            WHERE  op.id != 6 and op.id != 4" ;
                    $query= $em->createQuery($dql);
                    $results = $query->getResult();
                }
            }else{
                $dql= " SELECT  op.id, op.sigla, op. nombre
                    FROM AdminBundle:EtapaProceso op
                    WHERE op.id != 4" ;
                $query= $em->createQuery($dql);
                $results = $query->getResult();               
            }
        }
                
        return $this->render('AdminBundle:Pedidos:nuevo.html.twig', array(
            'titulo'          => $titulo,
            'data'            => $data,
            'pedido'          => $pedido,
            'lista_contactos' => $lisContactEmpre,
            'lista_etapa_negociacion' => $results,
            'submenu'         => 'pedido_nueva',
            'menu_o_con'      => 'pedido'
        ));
    }
    // ajax buscar empresas
    public function buscarEmpresaAction(Request $request)
    {
        $data = $request->get('bsq_empre_pedido');
        
        $em = $this->getDoctrine()->getManager();
 
        $query = $em->createQuery(''
                . 'SELECT c.id, c.nombre, c.razonsocial '
                . 'FROM AdminBundle:Empresa c '
                . 'WHERE c.nombre LIKE :data '
                . 'OR c.razonsocial LIKE :data '
                . 'AND c.estado = 1'
                . 'ORDER BY c.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getResult();
        
        $contactoLista = '';
        foreach ($results as $result) {
            $bold_prinombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['nombre']);
            $bold_segnombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['razonsocial']);
            $contactoLista .= '<li class="ele" role="presentation"><span role="menuitem" data-id="'.$result['id'].'">'.$bold_prinombre.' , '.$bold_segnombre.'</span></li>';
        } 
        $response = new JsonResponse();
        $response->setData(array('contactoLista' => $contactoLista));        
        return $response;
    }
    // ajax buscar contacto
    public function buscarContactoAction(Request $request)
    {
        $op = false;
        $data = $request->get('empresa');
        $em = $this->getDoctrine()->getManager();
        $lista_contactos = '';
        if ($contacto_empresa = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkEmpresa' => $data))){  
            $op = true;
            foreach ($contacto_empresa as $result) {
                if($lista_contactos==''){
                    $lista_contactos .= '<option value="">Seleccione</option>';
                }
                $retVal = ($result->getFkContacto()->getRun()!="") ? "Run ".':'.$result->getFkContacto()->getRun() : '' ;
                $lista_contactos .= '<option value="'.$result->getFkContacto()->getId().'">'.$retVal.$result->getFkContacto()->getPrimerNombre().' '.$result->getFkContacto()->getApellidoPaterno().' '.$result->getFkContacto()->getApellidoMaterno().'</option>';
            }
        }
        $response = new JsonResponse();
        $response->setData(array('op'=>$op, 'contLista' => $lista_contactos));
        return $response;
       
    }
    /*Encargado de Buscar productos para asociar a empresa*/
    public function buscarProductosAction(Request $request)
    {
        $data = $request->get('bsq_producto');
        $id_pedido = $request->get('id_pedido');//id pedido para filtrar las respuestas 
        $em = $this->getDoctrine()->getManager(); 
        $query = $em->createQuery(''
                . 'SELECT c.id, c.nombre, c.codigoProd '
                . 'FROM AdminBundle:Producto c '
                . 'WHERE c.nombre LIKE :data '
                . 'OR c.codigoProd LIKE :data '
                . 'AND c.estado = 1'
                . 'ORDER BY c.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        $results = $query->getResult();
        $productoLista = '';
        foreach ($results as $result) {
            $bold_prinombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['nombre']);
            $bold_segnombre = preg_replace('/('.$data.')/i', '<strong>$1</strong>', $result['codigoProd']);
            $productoLista .= '<li class="ele test" role="presentation"><span role="menuitem" data-id="'.$result['id'].'"><strong>Codigo:  </strong>'.$bold_segnombre.' , <strong>Nombre:   </strong> '.$bold_prinombre.'</span></li>';
        }
        $response = new JsonResponse();
        $response->setData(array('productoLista' => $productoLista));
        return $response;
    }
    /*Encargado de cargar listado de opciones por producto-categoria*/
    public function cargarListadoOpcionesAction(Request $request)
    {
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        $detalleProducto = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));

        $dql= " SELECT  op.id, op.nombre, op.valor,IDENTITY(op.unidadMedidaDimension, 'id') AS unidadMedidaDimension, IDENTITY(op.unidadMedidaPeso,'id') AS unidadMedidaPeso
                FROM AdminBundle:ProductoCategoria pc  INNER JOIN AdminBundle:OpcionesProducto op WITH pc.fkCategoria = op.categorias
                where pc.fkProducto=:id_producto";   
        $results= $em->createQuery($dql)
                    ->setParameter('id_producto', $detalleProducto->getFkProducto()->getId())
                    ->getResult(); 
        $lista_opciones = '';
        foreach ($results as $result) {
            if (!$em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('pedidoDetalle'=>$id_detalle,'opcionesProducto'=>$result['id']))) {
                if($lista_opciones==''){
                    $lista_opciones .= '<option value="">Seleccione</option>';
                }
                $nombreUnidad ="";           
                if (isset($result['unidadMedidaDimension']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaDimension')->findOneBy(array('id'=>$result['unidadMedidaDimension']))) {
                   $nombreUnidad= ' x ['.$opcion->getSigla().']';
                } else {
                    if (isset($result['unidadMedidaPeso']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaPeso')->findOneBy(array('id'=>$result['unidadMedidaPeso']))) {
                         $nombreUnidad= 'x ['.$opcion->getSigla().']';
                    }
                }            
                $lista_opciones .= '<option value="'.$result['id'].'">'.$result['nombre'].', $ '.$result['valor'].' '.$nombreUnidad.'</option>';
            }           
        }      
        $response = new JsonResponse();
        $response->setData(array('lista_opciones' => $lista_opciones,/*'lista_opciones_guardadas' => $listaOpcionesGuardadas,'valorModificado'=>$valorModificado->getValorModificado(),'cantidad'=>$valorModificado->getCantidad()*/));
        return $response;
    }
    /*Encargado de cargar algunas opciones y valores al la modal*/
    public function cargarOpcionesValoresAction(Request $request)
    {
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        /*Segunda consulta para obtener el listado perteneciente al detalle del producto */
        $dql2= " SELECT  op.id, op.valor, op.cantidad, op.largo, op.ancho, op.peso, IDENTITY(op.pedidoDetalle, 'id') AS pedidoDetalle, IDENTITY(op.opcionesProducto,'id') AS opcionesProducto,pc.id AS idOpcion, pc.nombre , IDENTITY(pc.unidadMedidaDimension, 'id') AS unidadMedidaDimension, IDENTITY(pc.unidadMedidaPeso,'id') AS unidadMedidaPeso
                FROM AdminBundle:DetallepedidoOpcionesproducto op  INNER JOIN AdminBundle:OpcionesProducto pc WITH op.opcionesProducto = pc.id
                WHERE op.pedidoDetalle=:data";

         $results2= $em->createQuery($dql2)
                    ->setParameter('data', $id_detalle)
                    ->getResult();
             $listaOpcionesGuardadas = '';
            foreach ($results2 as $result) {
                    $nombreUnidad ="";
                if (isset($result['unidadMedidaDimension']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaDimension')->findOneBy(array('id'=>$result['unidadMedidaDimension']))) {
                    $nombreUnidad= ' x ['.$opcion->getSigla().']';
                    $listaOpcionesGuardadas .= '<div class="valign-wrapper" id ="'.$result['idOpcion'].'"><i onClick="functionDelete('.$result['idOpcion'].')" class="material-icons del_btn_i pointer">remove_circle_outline</i>   '.$result['nombre'].'  $ '.$result['valor'].' '.$nombreUnidad.', Total medida: '.$result['largo']*$result['ancho'].' ['.$opcion->getSigla().'] = $ '.$result['valor']*($result['largo']*$result['ancho']).'</div>';
                } else {
                    if (isset($result['unidadMedidaPeso']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaPeso')->findOneBy(array('id'=>$result['unidadMedidaPeso']))) {
                        $nombreUnidad= 'x ['.$opcion->getSigla().']';
                    }else{
                        $listaOpcionesGuardadas .= '<div class="valign-wrapper"  id ="'.$result['idOpcion'].'"><i onClick="functionDelete('.$result['idOpcion'].')" class="material-icons del_btn_i pointer">remove_circle_outline</i>   '.$result['nombre'].'  $ '.$result['valor'].',  Unidades : <input type="number" id="'.$result['id'].'" style="width:70px;text-align:center;margin-left:10px;" min="1" value="'.$result['cantidad'].'" class="gui-input input-sm" onchange="actualizaCantidadOpcion(this.value,this.id)"></div>';
                    }
                }
            }
        $valorModificado = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));
        $total = $this->calculaTotalOpciones($id_detalle);
        $response = new JsonResponse();
        $response->setData(array('totalOpciones' => $total,'lista_opciones_guardadas' => $listaOpcionesGuardadas,'valorModificado'=>$valorModificado->getValorModificado(),'cantidad'=>$valorModificado->getCantidad()));
        return $response;
    }   
    /*Encargado de Buscar datos del producto y guardar el detallepedido junto con el pedido*/
    public function buscardatosproductosAction(Request $request)
    {
        $id_prod     = $request->get('id_producto');
        $id_empresa  = $request->get('id_empresa');
        $id_contacto = $request->get('id_contacto');
        $id_pedido   = ($request->get('id_pedido', false)) ? $request->get('id_pedido'): 0;
        /*Creacion de pedido*/
        $user = $this->getUser();
        $user_n = $user->getUserName();
        $user_email = $user->getEmail();
        $em = $this->getDoctrine()->getManager();
        /*Si el correo y el usuario existen como personal-vendedor realiza el pedido */
        if ($personal = $em->getRepository('AdminBundle:Personal')->findOneBy(array('username'=>$user_n, 'correo'=>$user_email))) {
            /*Extraccion de objeto empresa  para creacion de pedido */
            $empresa = $em->getRepository('AdminBundle:Empresa')->findOneBy(array( 'id' => $id_empresa ));
            /*Inicio creacion pedido*/
                /*Verifica que el pedido ya alla sido creado y que solo sea una agregacion de producto*/
                if (!$new_pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido ))) {
                    $new_pedido = new Pedidos();
                    $new_pedido->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
                 
                    $new_pedido->setPersonal($personal);//relaciona el usuario vendedor con el pedido
                    $new_pedido->setContacEmpre($em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array('fkContacto'=>$id_contacto, 'fkEmpresa'=>$id_empresa)));
                    $new_pedido->setEtapa($em->getRepository('AdminBundle:Etapa')->findOneBy(array('id'=>6)));
                    $new_pedido->setEtapaProceso($em->getRepository('AdminBundle:EtapaProceso')->findOneBy(array('id'=>6))); 
                    $new_pedido->setIvaActual("19");
                    $em->persist($new_pedido);
                    $em->flush();
                    $id_pedido = $new_pedido->getId();
                    $new_pedido->setCodigoCotizacion($this->crearNumeroCotizacion($id_pedido));
                    
                    $em->persist($new_pedido);
                    $em->flush();                     
                }
            /*Fin*/
            /*Inicio creacion de detalle de pedido*/
                $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido));
                $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array( 'id' => $id_prod ));
                $pedido_detalle = new PedidoDetalle();
                $pedido_detalle->setFkProducto($producto);
                $pedido_detalle->setFkPedido($pedido);
                $pedido_detalle->setValorProducto($producto->getValorUnitario());
                $pedido_detalle->setCantidad(1);
                $idEtapaPrincipal = ($em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array('fkProducto'=>$id_prod,'fkCategoria'=>1)))? 2 : 3;                
                $pedido_detalle->setEtapaPedidoDetalle($em->getRepository('AdminBundle:EtapaPedidoDetalle')->findOneBy(array('id'=>$idEtapaPrincipal)));
                $pedido_detalle->setTotal($producto->getValorUnitario());
                $pedido_detalle->setValorModificado($producto->getValorUnitario());
                $em->persist($pedido_detalle);
                $em->flush();
            /*Fin*/
            /*Inicio actualizacion de total de el pedido*/
                $new_pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido ));
                $valorTotal = $new_pedido->getTotal();//obtiene el valor total antes de cambiarlo
                $valorNuevo = $pedido_detalle->getTotal();//obtiene el valor nuevo a sumar
                $new_pedido->setTotal($valorTotal + $valorNuevo);//actualiza el valor total del pedido sumandole el valor del detalle nuevo
                // $new_pedido->setValorNeto((1-($new_pedido->getDescuentos()/100))*$new_pedido->getTotal());
                $montoDescuento = ($new_pedido->getDescuentos() > 0)  ? ($new_pedido->getDescuentos()/100)*($valorTotal + $valorNuevo) : 0 ;            
                $new_pedido->setValorNeto(($valorTotal + $valorNuevo)-$montoDescuento);
                $em->persist($new_pedido);
                $em->flush();
            /*Fin actualizacion total de Pedido*/
              // variables
            $em         = $this->getDoctrine()->getManager();
            $qb         = $em->createQueryBuilder();
            $result     = false;
            $producto   = '';

            $q = $qb->select(array('c'))
            ->from('AdminBundle:Producto', 'c')
            ->where('c.id = '.$id_prod)
            ->getQuery();
            $id_detalle = $pedido_detalle->getId();
            //$acotizar  = ($em->getRepository('AdminBundle:ProductoCategoria')->findOneBy(array('fkProducto'=>$id_prod,'fkCategoria'=>1)))? "readonly" : "";
            $acotizar  = ($idEtapaPrincipal==2)? "readonly" : "";
            if ($resultQuery = $q->getResult()) {
                foreach ($resultQuery as $value) {
                    //$id_detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('fkProducto'=> $value->getId(), 'fkPedido'=> $new_pedido->getId()))->getId();
                    $producto .= '<tr id=tr'.$id_detalle.'>';
                    $producto .= '<td class="td-width-40">'.$value->getCodigoProd().'</td>';
                    $producto .= '<td title="Nombre">'.$value->getNombre().'</td>';
                    $producto .= '<td title="Valor Base">'.$value->getValorUnitario().'</td>';
                    $producto .= '<td td-width-30" title="Cantidad"><input style="width: 50px;" name="newCantidad" id="nc'.$id_detalle.'" type="number" min="1" class="text-right val_num" value="'.$pedido_detalle->getCantidad().'" onchange="myFunction(this.value, this.id)" '.$acotizar.'></td>';
                    $producto .= '<td td-width-50" title="Valor Cotizacion"><input style="width: 100px;" name="totalac" id="vm'.$id_detalle.'" type="number" min="1" class="text-right val_num" value="'.$pedido_detalle->getTotal().'" onchange="myFunctionValCotizacion(this.value, this.id)" '.$acotizar.' '.((!$this->isGranted('ROLE_ADMIN_C'))? 'disabled' : '').'></td>';
                    $producto .= '<td class="text-right td-width-100" title="Total por producto" id="total'.$id_detalle.'">'.$pedido_detalle->getTotal().'</td>';
                    $producto .= '<td class="text-right td-width-100" title="Estado" id="total'.$id_detalle.'">'.$pedido_detalle->getEtapaPedidoDetalle()->getNombre().'</td>';
                    if ($acotizar=="") {
                        $producto .= '<td class="text-right td-width-50" ><a id="'.$id_detalle.'" onclick="modal(this.id)"><i class="material-icons">mode_edit</i></a><a id="'.$id_detalle.'" onclick="eliminarProductoDetalle(this.id)"><i class="material-icons">delete_forever</i></a></td>';
                    }else{
                        $producto .= '<td class="text-right td-width-50" ><a id="'.$id_detalle.'" onclick="modalVerEditarProductoCotizar('.$id_prod.')"><i class="material-icons">mode_edit</i></a><a id="'.$id_detalle.'" onclick="eliminarProductoDetalle(this.id)"><i class="material-icons">delete_forever</i></a></td>';
                    }
                    $producto .= '</tr>';
                }
                $result = true;
            }
            /* Calculo de valor imponible*/
            $totalCI = (($new_pedido->getIvaActual()/100)+1)*$new_pedido->getValorNeto();         
        }//final if que evalua el Personal 
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorNetoCD'=>$new_pedido->getValorNeto(), 'totalCI'=>$totalCI,'producto' => $producto,'id_pedido' => $id_pedido,'codigoCotizacion'=>$pedido->getCodigoCotizacion(),'valorTotal'=>$new_pedido->getTotal()));
        return $response;
    }
    public function cargarFormCotizacionAction(Request $request)
    {
        $id = $request->get('id_empresa');
        $em = $this->getDoctrine()->getManager();
        $array = array();
       // $where = array('estado' => 1);
        if ($query = $em->getRepository('AdminBundle:Empresa')->findBy(array('id' => $id ))) {
            foreach ($query as $value) {
                $datos = new stdClass();
                $datos->id_empresa  = $value->getId();
                $datos->n_empresa   = $value->getNombre();
                $datos->razonsocial = $value->getRazonsocial();
                $datos->rut         = $value->getRut();
                $datos->comuna      = $value->getComuna();
                $datos->provincia   = $value->getProvincia();
                $datos->region      = $value->getRegion();
                $datos->villa       = $value->getDirVillaPbla();
                $datos->calle       = $value->getDirCalle();
                $datos->numero_casa = $value->getDirNumero();
                $datos->numero_dpto = $value->getDirNumeroDepartamento();
                $datos->numero_piso = $value->getDirNumeroPiso();
                $datos->telefono    = $value->getTelefono();
                $datos->celular     = $value->getCelular();
                $datos->correo      = $value->getCorreo();
                $array[]  = $datos;
            }
        }

        $response = new JsonResponse();
        $response->setData(array('empre' => $array));
        return $response;
    }
    //Funcion que actualiza la cantidad de una opcion especifica por producto
    public function guardarCantidadOpcionesProductoAction(Request $request)
    {
        $cantidad       = $request->get('cantidad');//cantidad nueva
        $id_detalle_opc = $request->get('id_detalle_opc');//detalle-pedido
        $id_detalle = $request->get('id_detalle');//detalle-pedido
        $em = $this->getDoctrine()->getManager();
        $detalle_opciones = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('id'=>$id_detalle_opc));//obj Opciones-detalle-pedido
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$detalle_opciones->getPedidoDetalle()));//detalle-pedido
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));//pedido
        /*Inicio calculo valor a sumar en detalle_pedido y pedidos*/
            $valOPAntiguo = $detalle_opciones->getCantidad()*$detalle_opciones->getValor();//obtengo el valor antiguo de la opcion**********
            $valOPNuevo   = $cantidad*$detalle_opciones->getValor();//valor de la opcion por la cantidad  nueva de la opcion
            $valorASumar  = $valOPNuevo-$valOPAntiguo;//saco la diferencia entre las opciones para saber cuanto es lo que tengo que sumar
        /*Fin*/
        $valor = $detalle->getTotal()+($valorASumar*$detalle->getCantidad());//se calcula el valor a sumar y se actualiza el total del detallePedido
        $ValorTotal = ($pedido->getTotal()-$detalle->getTotal())+$valor;
        $pedido->setTotal($ValorTotal);
        $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)*$ValorTotal: 0 ;            
        $pedido->setValorNeto($ValorTotal-$montoDescuento);
        $detalle->setTotal($valor);       
        $detalle_opciones->setCantidad($cantidad);
        $em->persist($detalle);
        $em->persist($pedido);
        $em->persist($detalle_opciones);
        $em->flush();
        $total = $this->calculaTotalOpciones($id_detalle);

        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();     
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorNetoCD'=>$pedido->getValorNeto(),'totalCI'=>$totalCI,'valorTotal'=>$pedido->getTotal(),'result' => $detalle->getTotal(),'totalOpciones'=>$total));
        return $response;
    }
    //Funcion que actualizala cantidad de productos de pedido
    public function actualizaCantidadProductosAction(Request $request)
    {
        $cantidad   = $request->get('cantidad');//cantidad de opcion
        $id_detalle = $request->get('id_detalle');//detalle pedido
        $em = $this->getDoctrine()->getManager();
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));//obj pedido-detalle      
        $valorOpcionesProducto = ($detalle->getTotal()-($detalle->getCantidad()*$detalle->getValorModificado()))/$detalle->getCantidad();
        $totalNuevo = $cantidad*($detalle->getValorModificado()+$valorOpcionesProducto);
        /* Inicio calculo de la diferencia para actualizar el valor del pedido*/
            $totalAntiguo = $detalle->getTotal();
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
            $ValorTotal = $pedido->getTotal()+($totalNuevo-$totalAntiguo);
            $pedido->setTotal($ValorTotal);
            $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)* $ValorTotal : 0;        
            $pedido->setValorNeto($ValorTotal-$montoDescuento);         
        /*Fin*/
        $detalle->setCantidad($cantidad);
        $detalle->setTotal($totalNuevo);
        $em->persist($detalle);
        $em->persist($pedido);
        $em->flush();
               
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();
            
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorTotal'=>$pedido->getTotal(),'valorNetoCD'=>$pedido->getValorNeto(), 'totalCI'=>$totalCI,'result' => $detalle->getTotal()));
        return $response;
    }
    public function actualizaPrecioCotizacionProductoAction(Request $request)
    {
        $valorNuevo = $request->get('valorCotizacion');
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));        
        $valorOpcionesProducto = ($detalle->getTotal()-($detalle->getCantidad()*$detalle->getValorModificado()))/$detalle->getCantidad();
        $totalNuevo = $detalle->getCantidad()*($valorOpcionesProducto+$valorNuevo);
        /* Inicio Calculo de la diferencia para actualizar el valor del pedido */
            $totalAntiguo = $detalle->getTotal();                        
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
            $ValorPedido = $pedido->getTotal()+($totalNuevo-$totalAntiguo);
            $pedido->setTotal($ValorPedido);            
            $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)*$ValorPedido : 0;    
            $pedido->setValorNeto($ValorPedido-$montoDescuento);            
        /*Fin*/
        $detalle->setValorModificado($valorNuevo);        
        $detalle->setTotal($totalNuevo);
        $em->persist($detalle);
        $em->persist($pedido);
        $em->flush();

        /* Calculo de valor imponible*/
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();
    
       $response = new JsonResponse();
       $response->setData(array('montoDescuento'=>$montoDescuento,'valorNetoCD'=>$pedido->getValorNeto(),'valorTotal'=>$pedido->getTotal(),'totalCI'=>$totalCI,'result' => $detalle->getTotal()));
       return $response;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function guardarOpcionDetalleProductoAction(Request $request)
    {
        $id_opcion  = $request->get('id_opcion');
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));
        $opcion = $em->getRepository('AdminBundle:OpcionesProducto')->findOneBy(array('id'=>$id_opcion));
        if (!$detalleP_opcionesP = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('pedidoDetalle'=>$id_detalle,'opcionesProducto'=>$id_opcion))) {
            $detalleP_opcionesP = new DetallePedidoOpcionesProducto();
            $detalleP_opcionesP->setPedidoDetalle($detalle);
            $detalleP_opcionesP->setOpcionesProducto($opcion);
            $detalleP_opcionesP->setCantidad(1);
            $detalleP_opcionesP->setValor($opcion->getValor());
        }
        $detalle->setTotal($detalle->getTotal()+($opcion->getValor()*$detalle->getCantidad()));
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
        $ValorTotal = $pedido->getTotal()+($opcion->getValor()*$detalle->getCantidad());
        $pedido->setTotal($ValorTotal);
        $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)*$ValorTotal : 0 ;            
        $pedido->setValorNeto($ValorTotal-$montoDescuento);     
        $em->persist($detalle);
        $em->persist($pedido);
        $em->persist($detalleP_opcionesP);
        $em->flush();
        /* Calculo de valor imponible*/
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();
        $total= $this->calculaTotalOpciones($id_detalle);
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorTotal'=>$pedido->getTotal(),'valorNetoCD'=>$pedido->getValorNeto(), 'totalCI'=>$totalCI,'total_pedido'=>$detalle->getTotal(),'id_op_det'=>$detalleP_opcionesP->getId(), 'totalOpciones'=>$total));
        return $response;
    }
    //funcion que calcula el tota de opciones por id_detalle
    private function calculaTotalOpciones($id_detalle){
        $em = $this->getDoctrine()->getManager();
        $opciones = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findBy(array('pedidoDetalle'=>$id_detalle));
        $total = 0;
        foreach ($opciones as $value) {
            if ($value->getLargo()!="") {
                $dimension = round(($value->getLargo() * $value->getAncho()) * 100) / 100;
                $total+= ceil($value->getValor() * $dimension);
            }else{
                $total+=$value->getValor()*$value->getCantidad();
            }
        }
        return $total;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function eliminaOpcionDetalleProductoAction(Request $request)
    {
        $id_opcion = $request->get('id_opcion');
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        if ($delete = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('pedidoDetalle' => $id_detalle,'opcionesProducto'=>$id_opcion)))
        {
            if ($delete->getLargo()!="") {
                $largo = $delete->getLargo();
                $ancho = $delete->getAncho();
                $dimension = round(($largo * $ancho) * 100) / 100;
                $valorEliminar = ceil($delete->getValor() * $dimension);                
            }else{
                $valorEliminar = $delete->getCantidad()*$delete->getValor();// lo que cuesta esta opcion ---> cantidad*valor
            }
            $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));//objeto detalle asiciado para descontar valor de la opcion a eliminar
            $detalle->setTotal($detalle->getTotal()-($detalle->getCantidad()*$valorEliminar));//total -= cantidadUnidadesProducto * valorOpcionXunidad            
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
            $ValorTotal = $pedido->getTotal()-($detalle->getCantidad()*$valorEliminar);
            $pedido->setTotal($ValorTotal);
            $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)*$ValorTotal : 0 ;            
            $pedido->setValorNeto($ValorTotal-$montoDescuento);
            $em->remove($delete);
            $em->persist($detalle);
            $em->persist($pedido);
            $em->flush();
        }
        /* Calculo de valor imponible*/
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();
      
        $total = $this->calculaTotalOpciones($id_detalle);
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorTotal'=>$pedido->getTotal(),'valorNetoCD'=>$pedido->getValorNeto(), 'totalCI'=>$totalCI,'total_pedido'=>$detalle->getTotal(),'totalOpciones'=>$total));
        return $response;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function eliminaDetallePedidoAction(Request $request)
    {
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        $pedidoDetalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));//objeto productoDetalle
        $detalleP_OpcionesP = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findBy(array('pedidoDetalle'=>$id_detalle));//todas las opciones por el producto
        foreach ($detalleP_OpcionesP as $value) {//itera por todas las opciones del producto a eliminar
            $em->remove($value);
        }
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$pedidoDetalle->getFkPedido()));
        $ValorTotal = $pedido->getTotal()-$pedidoDetalle->getTotal();
        $pedido->setTotal($ValorTotal);

        $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)* $ValorTotal : 0 ;            
        $pedido->setValorNeto($ValorTotal-$montoDescuento);

        $em->remove($pedidoDetalle);
        $em->persist($pedido);
        $em->flush();

        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();       
        
        $response = new JsonResponse();
        $response->setData(array('valorNetoCD'=>$pedido->getValorNeto(),'valorTotal'=>$pedido->getTotal(),'montoDescuento'=>$montoDescuento,'totalCI'=>$totalCI));
        return $response;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function agregarOpcionDimensionAction(Request $request)
    {
        $res = false;
        /* INICIO captacion variables  por POST*/
            $id_opcion  = $request->get('id_opcion');
            $id_detalle = $request->get('id_detalle');
            $largo      = $request->get('largo');
            $ancho      = $request->get('ancho');
            $costo      = $request->get('costo');
        /*FIN*/
        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $detalle_pedido  = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));//Objeto pedido_detalle asociado en modal
        $opcion = $em->getRepository('AdminBundle:OpcionesProducto')->findOneBy(array('id'=>$id_opcion));//Objeto opcion seleccionado en SELECT modal
        /*Si encuentra unn objeto que tenga los mismos datos no crea uno nuevo*/
        if (!$detalleP_opcionesP = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('opcionesProducto'=>$id_opcion,'pedidoDetalle'=>$id_detalle,'largo'=>$largo,'ancho'=>$ancho))) {
            $detalleP_opcionesP = new DetallePedidoOpcionesProducto();
            $res = true;
        }
       /*INICIO de creacion de DetallePedidoOpcionesProducto y set de valores */          
            $detalleP_opcionesP->setPedidoDetalle($detalle_pedido);
            $detalleP_opcionesP->setOpcionesProducto($opcion);
            $detalleP_opcionesP->setCantidad(1);
            $detalleP_opcionesP->setValor($opcion->getValor());
            $detalleP_opcionesP->setLargo($largo);
            $detalleP_opcionesP->setAncho($ancho);
        /*FIN*/
        /*INICIO de set para cantidades totales*/
            $detalle_pedido->setTotal($detalle_pedido->getTotal()+($detalle_pedido->getCantidad()*$costo));//totalDetalle +=  cantidadDetalleproducto * valorDeOpcion
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle_pedido->getFkPedido()));//Objeto pedido asociado a detalle_pedido
            $ValorTotal = $pedido->getTotal()+($detalle_pedido->getCantidad()*$costo);
            $pedido->setTotal($ValorTotal);//totalPedido +=  cantidadDetalleproducto * valorDeOpcion
            $montoDescuento = ($pedido->getDescuentos() > 0)  ? ($pedido->getDescuentos()/100)* $ValorTotal : 0 ;            
            $pedido->setValorNeto($ValorTotal-$montoDescuento);
        /*FIN*/
        /*INICIO Guardado en BDD*/
            $em->persist($detalle_pedido);
            $em->persist($detalleP_opcionesP);
            $em->persist($pedido);
            $em->flush();
        /*FIN*/
          /* Calculo de valor imponible*/
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();       
        $total = $this->calculaTotalOpciones($id_detalle);
        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorTotal'=>$pedido->getTotal(),'valorNetoCD'=>$pedido->getValorNeto(), 'totalCI'=>$totalCI,'res'=>$res,'total_pedido'=>$detalle_pedido->getTotal(),'id_op_det'=>$detalleP_opcionesP->getId(),'totalOpciones'=>$total));
        return $response;
    }
    /*Funcion que carga las unidades de las opciones(producto_detalle)*/
    public function cargaOpcionesUnidadesOpcionProductoAction(Request $request)
    {
        $valor  = $request->get('valorChek');
        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $lista_contactos="";
        if ($valor==1) {
            if ($unidades = $em->getRepository('AdminBundle:UnidadMedidaDimension')->findAll()){  
                foreach ($unidades as $result) {
                    if($lista_contactos==''){
                        $lista_contactos .= '<option value="">Seleccione</option>';
                    }
                    $lista_contactos .= '<option value="'.$result->getId().'">'.$result->getNombre(). ' ['.$result->getSigla().']</option>';
                }
            }        
        }else{
             if ($unidades = $em->getRepository('AdminBundle:UnidadMedidaPeso')->findAll()){  
                foreach ($unidades as $result) {
                    if($lista_contactos==''){
                        $lista_contactos .= '<option value="">Seleccione</option>';
                    }
                    $lista_contactos .= '<option value="'.$result->getId().'">'.$result->getNombre(). '  ['.$result->getSigla().']</option>';
                }
            }  
        }       
        $response = new JsonResponse();
        $response->setData(array('lista_opciones'=>$lista_contactos));
        return $response;
    }
    //guarda las opciones de la ventana modal de pedido detalle, solamente queda guardar la observacion el resto es ajax
    public function guardaPedidoDetalleAction(Request $request)
    {
        $result = false;
        $id_detalle    = $request->get('id_detalle');
        $observaciones = $request->get('observaciones');

        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));
        $detalle->setObservacion($observaciones);

        $em->persist($detalle);
        $em->flush();
        $result = true;
        echo json_encode(array('result' => $result));
        exit;

        // $response = new JsonResponse();
        // $response->setData(array());
        // return $response;
    }
    //guarda las opciones de la ventana modal de pedido detalle, solamente queda guardar la observacion el resto es ajax
    public function validaEstadoIngresoAction(Request $request)
    {
        $id_pedido    = $request->get('ped_id');
        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$id_pedido));
        $pedido->setEtapa($em->getRepository('AdminBundle:Etapa')->findOneBy(array('id'=>1)));
        $pedido->setEtapaProceso($em->getRepository('AdminBundle:EtapaProceso')->findOneBy(array('id'=>1)));

        $em->persist($detalle);
        $em->flush();
        $result = true;
        echo json_encode(array('result' => $result));
        exit;

        
    }
    public function cargarTablaAction(Request $request)
    {
        $id_pedido    = $request->get('ped_id');
        $em = $this->getDoctrine()->getManager();//declaracion de doctrine
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$id_pedido));

        $AllDetalles = $em->getRepository('AdminBundle:PedidoDetalle')->findBy(array('fkPedido'=>$id_pedido));
        $producto   = '';
        foreach ($AllDetalles as $value) {
            $acotizar = ($value->getEtapaPedidoDetalle()->getId()==2) ? "readonly" : "" ;
         //   $acotizar  = ($idEtapaPrincipal==2)? "readonly" : "";
            
            $producto .= '<tr id=tr'.$value->getId().'>';
            $producto .= '<td class="td-width-40">'.$value->getFkProducto()->getCodigoProd().'</td>';
            $producto .= '<td title="Nombre">'.$value->getFkProducto()->getNombre().'</td>';
            $producto .= '<td title="Valor Base">'.$value->getFkProducto()->getValorUnitario().'</td>';
            $producto .= '<td class="text-right td-width-30" title="Cantidad"><input style="width: 50px;" name="newCantidad" id="nc'.$value->getId().'" type="number" min="1" class="text-right input-group val_num" value="'.$value->getCantidad().'" onchange="myFunction(this.value, this.id)" '.$acotizar.' '.((!$this->isGranted('ROLE_ADMIN_C'))? 'disabled' : '').' ></td>';
            $producto .= '<td class="text-right td-width-50" title="Valor Cotizacion"><input style="width: 100px;" name="totalac" id="vm'.$value->getId().'" type="number" min="1" class="text-right input-group val_num" value="'.$value->getValorModificado().'" onchange="myFunctionValCotizacion(this.value, this.id)" '.$acotizar.' '.((!$this->isGranted('ROLE_ADMIN_C'))? 'disabled' : '').'></td>';
            $producto .= '<td class="text-right td-width-100" title="Total por producto" id="total'.$value->getId().'">'.$value->getTotal().'</td>';
            $producto .= '<td class="text-right td-width-100" title="Estado" id="total'.$value->getId().'">'.$value->getEtapaPedidoDetalle()->getNombre().'</td>';
            if ($this->isGranted('ROLE_ADMIN_C')) {
                if ($acotizar == "") {
                    $producto .= '<td class="text-right td-width-50" ><a id="'.$value->getId().'" onclick="modal(this.id)"><i class="material-icons">mode_edit</i></a> '.(($this->isGranted('ROLE_ADMIN_B'))? '<a id="'.$value->getId().'" onclick="eliminarProductoDetalle(this.id)"><i class="material-icons">delete_forever</i></a>' : '' ).' </td>';
                }else{
                    $producto .= '<td class="text-right td-width-50" ><a id="'.$value->getId().'" onclick="modalVerEditarProductoCotizar('.$value->getFkProducto().')"><i class="material-icons">mode_edit</i></a> '.(($this->isGranted('ROLE_ADMIN_B'))? '<a id="'.$value->getId().'" onclick="eliminarProductoDetalle(this.id)"><i class="material-icons">delete_forever</i></a>' : '' ).' </td>';
                }
            }
            $producto .= '</tr>';
        }

        $response = new JsonResponse();
        $response->setData(array('producto'=>$producto));
        return $response;
    }
    public function actualizaCantidadDescuentoPedidoAction(Request $request ){
        $porcentaje = $request->get('porcentaje');
        $id_pedido = $request->get('id_pedido');
        $em = $this->getDoctrine()->getManager();
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$id_pedido));
        
        $pedido->setValorNeto((1-($porcentaje/100))*$pedido->getTotal());
        $montoDescuento = ($porcentaje/100)*$pedido->getTotal();
        $pedido->setDescuentos($porcentaje);
        $em->persist($pedido);
        $em->flush();
        $totalCI = (($pedido->getIvaActual()/100)+1)*$pedido->getValorNeto();
        

        $response = new JsonResponse();
        $response->setData(array('montoDescuento'=>$montoDescuento,'valorNetoCD'=>$pedido->getValorNeto(),'totalCI'=>$totalCI));
        return $response;        
    }
    /*
    * Metodo que devuelve true si el $role pasado como atributo esta contenido en los 
    * roles de usuario registrado no hace referencia a las herencias de security
    */
    private function hasRole($role){
        $user = $this->getUser();
        $user_email = $user->getEmail();
        $user_rol =  $user->getRoles();
        $em = $this->getDoctrine()->getManager();
        //$rol = $em->getRepository('AdminBundle:Usuario')->findOneBy(array('email'=>$user_email))->getRoles();
        foreach ($user_rol as $value) {
            if ($value == $role) {
               return true;
            }  
        }        
        return false;
    }
}
