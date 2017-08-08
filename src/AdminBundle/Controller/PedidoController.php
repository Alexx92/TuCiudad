<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Empresa;
use AdminBundle\Entity\Pedidos;
use AdminBundle\Entity\ContacEmpre;
use AdminBundle\Entity\Personal;
use AdminBundle\Entity\PedidoDetalle;
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

        return $this->render('AdminBundle:Pedidos:nuevo.html.twig', array(
            'titulo'      => $titulo,
            'nombreContacto' => null,
            'lista_contactos' =>null,
            'lista_opciones' =>null,
            'submenu'     => 'pedido_nueva',
            'menu_o_con'  => 'pedido'
        ));
    }

    //carga taba
    public function pedidoCargartablaAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();

       // $where = array('estado' => 1);

        $lista_pedidos = array();
        
        if ($pedido = $em->getRepository('AdminBundle:Pedidos')->findAll( )) {
            foreach ($pedido as $value) {
                $datos = new stdClass();
                
                $datos->id                  = $value->getId();
                $datos->codigo_pedido       = $value->getCodigoPedido();
               // $datos->personal_nombre     = $value->getPersonal()->getPrimerNombre();
                $empresa = $em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array ($value->getContacEmpre()));
                $datos->empresa_nombre      = $empresa->getNombre();
                $datos->observacion         = $value->getObservacion();
                $datos->valorNeto           = $value->getValorNeto();
                
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
            $id_pedido                  = ($request->get('ped_id', false)) ? $request->get('ped_id'): 0;
            $id_empresa                 = $request->get('empre_id');
            $id_producto                = $request->get('prod_id');
            /*Creacion de pedido*/
            $user = $this->getUser();//se obtiene el usuario del sistema
            $user_n = $user->getUserName();// obtencion de username del usuario actual
            $user_email = $user->getEmail();//obtencion del email del usuario actual

            $em = $this->getDoctrine()->getManager();
            /*Si el correo y el usuario existen como vendedor realiza el pedido */
            if ($personal = $em->getRepository('AdminBundle:Vendedor')->findOneBy(array('username'=>$user_n, 'correo'=>$user_email))) {
                /*Extraccion de objeto empresa  para creacion de pedido */
                $empresa = $em->getRepository('AdminBundle:Empresa')->findOneBy(array( 'id' => $id_empresa ));
                /*Inicio creacion pedido*/
                    /*Verifica que el pedido ya alla sido creado y que solo sea una agregacion de producto*/
                if (!$new_pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido ))) {
                    $new_pedido = new Pedidos();
                    $new_pedido->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));
                    $new_pedido->setFkVendedor($personal);//relaciona el usuario vendedor con el pedido
                    $new_pedido->setFkEmpresa($empresa);//realciona la empresa con el pedido
                    //$new_pedido->setEtapa(1);
                    $em->persist($new_pedido);
                    $em->flush();
                    $id_pedido = $new_pedido->getId();
                   // dump( $id_pedido," segundo"  );
                }
                /*Fin */
                /*Inicio creacion de detalle de pedido*/
                    /*Extrae el mismo objeto pedido que se creo*/
                    $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido));
                    /*Extraccion de objeto producto  para creacion de detalle pedido */
                    $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array( 'id' => $id_producto ));
                    /*Creacion de detalle pedido */
                    $pedido_detalle = new PedidoDetalle();
                    $pedido_detalle->setFkProducto($producto);
                    $pedido_detalle->setFkPedido($pedido);
                    $pedido_detalle->setValorProducto($producto->getValorUnitario());
                    $pedido_detalle->setCantidad(1);
                    $pedido_detalle->setTotal($producto->getValorUnitario());
                    $em->persist($pedido_detalle);
                    $em->flush();
                /*Fin*/
                /*Inicio actualizacion de total de el pedido*/
                    $new_pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido ));
                    $valorTotal =  $new_pedido->getTotal();//obtiene el valor total antes de cambiarlo
                    $valorNuevo =  $pedido_detalle->getTotal();//obtiene el valor nuevo a sumar

                    $new_pedido->setTotal($valorTotal + $valorNuevo);//actualiza el valor total del pedido sumandole el valor del detalle nuevo
                    $em->persist($new_pedido);
                    $em->flush();
                /*Fin*/
                $result = true;
            }
        }

        $response = new JsonResponse();
        $response->setData(array('result' => $result, 'id_pedido' => $id_pedido));
        
        return $response;
    }

    // cargar formulario para editar
    public function pedidoEditarAction(Request $request)
    {

        $titulo  = 'Ver pedio';

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
        if ($cont_empre = $em->getRepository('AdminBundle:ContacEmpre')->findBy(array( 'fkEmpresa' => $id ))) {
            foreach ($cont_empre as $value) {
                $datos = new stdClass();
                
                $datos->id_contacto            = $value->getId();
                $datos->pri_nombre_fkcont      = $value->getFkContacto()->getPrimerNombre();
                $datos->seg_nombre_fkcont      = $value->getFkContacto()->getSegundoNombre();
                $datos->apellido_pate_fkcont   = $value->getFkContacto()->getApellidoPaterno();
                $datos->apellido_mate_fkcont   = $value->getFkContacto()->getApellidoMaterno();
                
                $lista_contempre[]  = $datos;
            }
        }
        
        return $this->render('AdminBundle:Pedidos:nuevo.html.twig', array(
            'titulo'          => $titulo,
            'data'            => $data,
            'lista_contempre' => $lista_contempre,
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
                $lista_contactos .= '<option value="'.$result->getFkContacto()->getId().'">'."Rut ".':'.$result->getFkContacto()->getRun(). ',  '.$result->getFkContacto()->getPrimerNombre().' '.$result->getFkContacto()->getApellidoPaterno().'</option>';
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
        /*Segunda consulta para obtener el listado perteneciente al detalle del producto */
          $dql2= " SELECT  op.id, op.valor, op.cantidad, IDENTITY(op.pedidoDetalle, 'id') AS pedidoDetalle, IDENTITY(op.opcionesProducto,'id') AS opcionesProducto,pc.nombre , IDENTITY(pc.unidadMedidaDimension, 'id') AS unidadMedidaDimension, IDENTITY(pc.unidadMedidaPeso,'id') AS unidadMedidaPeso
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
                    } else {
                        if (isset($result['unidadMedidaPeso']) && $opcion = $em->getRepository('AdminBundle:UnidadMedidaPeso')->findOneBy(array('id'=>$result['unidadMedidaPeso']))) {
                            $nombreUnidad= 'x ['.$opcion->getSigla().']';
                        }
                    }
                    $listaOpcionesGuardadas .= '<div class="valign-wrapper"><i class="material-icons del_btn_i pointer">remove_circle_outline</i>   '.$result['nombre'].'  $ '.$result['valor'].' '.$nombreUnidad.'<input type="number" id="'.$result['id'].'" style="width:70px;text-align:center;margin-left:10px;" min="1" value="'.$result['cantidad'].'" class="gui-input input-sm" onchange="actualizaCantidadOpcion(this.value,this.id)"></div>';
                }
        $response = new JsonResponse();
        $response->setData(array('lista_opciones' => $lista_opciones,'lista_opciones_guardadas' => $listaOpcionesGuardadas));
        return $response;
    }
    /*Encargado de Buscar nombre de producto*/
    public function buscardatosproductosAction(Request $request)
    {
        $id_prod = $request->get('id_producto');
        $id_empresa   = $request->get('id_empresa');
        $id_contacto   = $request->get('id_contacto');
        $id_pedido  = ($request->get('id_pedido', false)) ? $request->get('id_pedido'): 0;
        /*Creacion de pedido*/
        $user = $this->getUser();//se obtiene el usuario del sistema
        $user_n = $user->getUserName();// obtencion de username del usuario actual
        $user_email = $user->getEmail();//obtencion del email del usuario actual

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
                    $new_pedido->setContacEmpre($em->getRepository('AdminBundle:ContacEmpre')->findOneBy(array('fkContacto'=>$id_contacto, 'fkEmpresa'=>$id_empresa)));//realciona la empresa con el pedido
                    //$new_pedido->setEtapa(1);
                    $em->persist($new_pedido);
                    $em->flush();
                    $id_pedido = $new_pedido->getId();
                }
            /*Fin */
            /*Inicio creacion de detalle de pedido*/
                /*Extrae el mismo objeto pedido que se creo*/
                $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido));
                /*Extraccion de objeto producto  para creacion de detalle pedido */
                $producto = $em->getRepository('AdminBundle:Producto')->findOneBy(array( 'id' => $id_prod ));
                /*Creacion de detalle pedido */
                $pedido_detalle = new PedidoDetalle();
                $pedido_detalle->setFkProducto($producto);
                $pedido_detalle->setFkPedido($pedido);
                $pedido_detalle->setValorProducto($producto->getValorUnitario());
                $pedido_detalle->setCantidad(1);
                $pedido_detalle->setTotal($producto->getValorUnitario());
                $pedido_detalle->setValorModificado($producto->getValorUnitario());
                $em->persist($pedido_detalle);
                $em->flush();
            /*Fin*/
            /*Inicio actualizacion de total de el pedido*/
                $new_pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array( 'id' => $id_pedido ));
                $valorTotal =  $new_pedido->getTotal();//obtiene el valor total antes de cambiarlo
                $valorNuevo =  $pedido_detalle->getTotal();//obtiene el valor nuevo a sumar
                $new_pedido->setTotal($valorTotal + $valorNuevo);//actualiza el valor total del pedido sumandole el valor del detalle nuevo
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
        
            if ($resultQuery = $q->getResult()) {
                foreach ($resultQuery as $value) {
                    $id_detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('fkProducto'=> $value->getId(), 'fkPedido'=> $new_pedido->getId()))->getId();
                    $producto .= '<tr>';
                    $producto .= '<td class="td-width-40">'.$value->getCodigoProd().'</td>';
                    $producto .= '<td title="NOmbre">'.$value->getNombre().'</td>';
                    $producto .= '<td title="Descripcion">'.$value->getDescripcion().'</td>';
                    $producto .= '<td class="text-right td-width-30"title="Valor Unitario Base">'.$value->getValorUnitario().'</td>';
                    $producto .= '<td class="text-right td-width-30" title="Cantidad"><input style="width: 50px;" name="newCantidad" id="'.$id_detalle.'" type="number" class="text-right" value="'.$pedido_detalle->getCantidad().'" onchange="myFunction(this.value, this.id)"></td>';
                    $producto .= '<td class="text-right td-width-50" title="Valor Cotizacion"><input style="width: 100px;" name="totalac" id="'.$id_detalle.'" type="number" class="text-right" value="'.$pedido_detalle->getTotal().'" onchange="myFunctionValCotizacion(this.value, this.id)"></td>';
                    $producto .= '<td class="text-right td-width-100" title="Total por producto" id="total'.$id_detalle.'">'.$pedido_detalle->getTotal().'</td>';
                    $producto .= '<td class="text-right td-width-50" ><a id="'.$id_detalle.'" onclick="modal(this.id)"><i class="material-icons">mode_edit</i></a></td>';
                    $producto .= '</tr>';
                }
                $result = true;
            }
        }//final if que evalua el Personal 
        $response = new JsonResponse();
        $response->setData(array('producto' => $producto,'id_pedido' => $id_pedido));
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
        $cantidad = $request->get('cantidad');
        $id_detalle_opc = $request->get('id_detalle_opc');
        $em = $this->getDoctrine()->getManager();        
        $detalle_opciones = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto')->findOneBy(array('id'=>$id_detalle_opc));
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$detalle_opciones->getPedidoDetalle()));
        $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));

        /*Inicio calculo valor a sumar en detalle_pedido y pedidos*/
            $valOPAntiguo = $detalle_opciones->getCantidad()*$detalle_opciones->getValor();
            $valOPNuevo = $cantidad*$detalle_opciones->getValor();
            $valorASumar = $valOPNuevo-$valOPAntiguo;
        /*Fin*/   

        $valor = $detalle->getTotal()+($valorASumar*$detalle->getCantidad());

        $detalle->setTotal($valor);
        $pedido->setTotal($valor);
        $detalle_opciones->setCantidad($cantidad);

        $em->persist($detalle);
        $em->persist($pedido);
        $em->persist($detalle_opciones);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array('result' => $detalle->getTotal()));
        return $response;
    // exit;
    }
    //Funcion que actualizala cantidad de productos de pedido
    public function actualizaCantidadProductosAction(Request $request)
    {
        $cantidad = $request->get('cantidad');
        $id_detalle = $request->get('id_detalle');
        $em = $this->getDoctrine()->getManager();
        $detalle = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));      
        $valorOpcionesProducto = ($detalle->getTotal()-($detalle->getCantidad()*$detalle->getValorModificado()))/$detalle->getCantidad();
        $totalNuevo = $cantidad*($detalle->getValorModificado()+$valorOpcionesProducto);
        /* Inicio calculo de la diferencia para actualizar el valor del pedido*/
            $totalAntiguo = $detalle->getTotal();                        
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
            $pedido->setTotal($pedido->getTotal()+($totalNuevo-$totalAntiguo));
        /*Fin*/
        $detalle->setCantidad($cantidad);
        $detalle->setTotal($totalNuevo);      
        $em->persist($detalle);
        $em->persist($pedido);
        $em->flush();
        $response = new JsonResponse();
        $response->setData(array('result' => $detalle->getTotal()));
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
            $pedido->setTotal($pedido->getTotal()+($totalNuevo-$totalAntiguo));
        /*Fin*/
        $detalle->setValorModificado($valorNuevo);        
        $detalle->setTotal($totalNuevo);
        $em->persist($detalle);
        $em->flush();       
        $response = new JsonResponse();
        $response->setData(array('result' => $detalle->getTotal()));
        return $response;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function guardarOpcionDetalleProductoAction(Request $request)
    {

        $id_opcion = $request->get('id_opcion');
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
            $detalle->setTotal($detalle->getTotal()+$opcion->getValor());
            $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
            $pedido->setTotal($pedido->getTotal()+$opcion->getValor());
            $em->persist($detalle);
            $em->persist($detalleP_opcionesP);
            $em->flush();
        $response = new JsonResponse();
        $response->setData(array('total_pedido'=>$detalle->getTotal(),'id_op_det'=>$detalleP_opcionesP->getId()));
        return $response;
    }
    /*Funcion que guarda la opcion del producto (producto_detalle)*/
    public function agregarOpcionDimensionAction(Request $request)
    {
        $id_opcion = $request->get('id_opcion');
        $id_detalle = $request->get('id_detalle');
        $id_largo = $request->get('largo');
        $id_ancho = $request->get('ancho');

        $em = $this->getDoctrine()->getManager();
        $detalle_pedido = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array('id'=>$id_detalle));
        $opcion = $em->getRepository('AdminBundle:OpcionesProducto')->findOneBy(array('id'=>$id_opcion));        
       
        // $detalleP_opcionesP = new DetallePedidoOpcionesProducto();
        // $detalleP_opcionesP->setPedidoDetalle($detalle);
        // $detalleP_opcionesP->setOpcionesProducto($opcion);
        // $detalleP_opcionesP->setCantidad(1);
        // $detalleP_opcionesP->setValor($opcion->getValor());


        //     $detalle->setTotal($detalle->getTotal()+$opcion->getValor());
        //     $pedido = $em->getRepository('AdminBundle:Pedidos')->findOneBy(array('id'=>$detalle->getFkPedido()));
        //     $pedido->setTotal($pedido->getTotal()+$opcion->getValor());
        //     $em->persist($detalle);
        //     $em->persist($detalleP_opcionesP);
        //     $em->flush();
        $response = new JsonResponse();
        $response->setData(array('total_pedido'=>$detalle->getTotal(),'id_op_det'=>$detalleP_opcionesP->getId()));
        return $response;
    }

    // ajax guardar relaciones pedido-producto
    // public function guardarProductoAction(Request $request)
    // {
    //     $id = (false);
    //     $id_producto = $request->get('id_producto');
    //     $id_empre = $request->get('id_empre');

    //     if( $request->getMethod() == 'POST' )
    //     {
    //         $em = $this->getDoctrine()->getManager();

    //         $Fkcategoria = $em->getRepository('AdminBundle:Empresa')->findOneBy(array('id' => $id_empre));
    //         $fkproducto  = $em->getRepository('AdminBundle:Producto')->findOneBy(array('id' => $id_producto));

    //         if( !$cli_procat = $em->getRepository('AdminBundle:PedidoDetalle')->findOneBy(array( 'fkProducto' => $id_producto, 'fkPedidos' => $idcat  )) )
    //         {
    //             $cli_procat = new ProductoCategoria();
    //             $cli_procat->setFkCategoria($Fkcategoria);
    //             $cli_procat->setFkProducto($fkproducto);
    //             $em->persist($cli_procat);
    //             $em->flush();
    //         }
    //     }
    //     $response = new JsonResponse();
    //     $response->setData(array('cli_procat' => $cli_procat));
        
    //     return $response;
    //     exit;
    // }
}
