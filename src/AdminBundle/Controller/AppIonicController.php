<?php

namespace AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\JsonResponse;
use AdminBundle\Entity\Contacto;
use AdminBundle\Entity\Empresa;
use AdminBundle\Entity\Producto;
use AdminBundle\Entity\ContacEmpre;
use AdminBundle\Entity\Pedidos;
use AdminBundle\Entity\Etapas;
use AdminBundle\Entity\Personal;
use AdminBundle\Entity\PedidoDetalle;
use AdminBundle\Entity\DetallepedidoOpcionesproducto;


use \stdClass;

class AppIonicController extends Controller
{

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////     Buscar JSON   /////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////


    // ajax buscar contacto devuelve json
    public function contactoBuscarJsonAction($searchTerm , Request $request)
    {
        $data  = $searchTerm; //$request->get('busq_cont');
        
        $em    = $this->getDoctrine()->getManager();
 
        $query = $em->createQuery(''
                . 'SELECT '
                . ' c.id, c.run, c.primerNombre primer_nombre, c.segundoNombre segundo_nombre, '
                . ' c.apellidoPaterno apellido_paterno, c.apellidoMaterno apellido_materno, '
                . ' c.correo, c.telefono, c.observacion, c.imagen, c.fechaIngreso fecha_ingreso, '
                . ' c.estado, d.id cargo_id '
                . 'FROM AdminBundle:Contacto c ' 
                . 'JOIN c.cargo d ' 
                . 'WHERE ((c.primerNombre LIKE :data '
                . 'OR c.segundoNombre LIKE :data '
                . 'OR c.apellidoPaterno LIKE :data '
                . 'OR c.apellidoMaterno LIKE :data) '
                . 'AND c.estado = 1 )'
                . 'ORDER BY c.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getArrayResult();
        
        $response = new JsonResponse($results);
        
        return $response;
    }

    // ajax buscar Empresa devuelve json
    public function empresaBuscarJsonAction($searchTerm , Request $request)
    {
        $data  = $searchTerm; //$request->get('busq_cont');
        
        $em    = $this->getDoctrine()->getManager();
 
        $query = $em
        	//->createQuery('SELECT e FROM AdminBundle:Empresa e WHERE (( e.nombre LIKE :data OR e.razonsocial LIKE :data) AND e.estado = 1 ) ORDER BY e.id ASC')
        	->createQuery('SELECT '
                . ' e.id, e.nombre, e.razonsocial, e.rut, e.comuna,  e.provincia, e.region, '
                . ' e.dirVillaPbla dir_villa_pbla, e.dirCalle dir_calle, e.dirNumero dir_numero,' 
                . ' e.dirNumeroDepartamento dir_numero_departamento, e.dirNumeroPiso dir_numero_piso, '
                . ' e.telefono, e.celular, e.correo, e.web, e.coordenadas, e.imagen, '
                . ' e.fechaIngreso fecha_ingreso, e.estado, f.id estado_empresa_id ' 
                . 'FROM AdminBundle:Empresa e ' 
                . 'JOIN e.estadoEmpresa f '
                . 'WHERE ((e.nombre LIKE :data '
                . 'OR e.razonsocial LIKE :data ) '
                . 'AND e.estado = 1 )'
                . 'ORDER BY e.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getArrayResult();
        
        $response = new JsonResponse($results);
        
        return $response;
    }

    // ajax buscar Producto devuelve json
    public function productoBuscarJsonAction($searchTerm , Request $request)
    {
        $data  = $searchTerm; //$request->get('busq_cont');
        
        $em    = $this->getDoctrine()->getManager();
 
        $query = $em->createQuery(''
                . 'SELECT '
                . ' p.id, p.nombre, p.descripcion, p.codigoProd codigo_prod,'
                . ' p.fechaIngreso fecha_ingreso, p.valorUnitario valor_unitario, p.imagen,  '
                . ' p.observacion, p.estado, p.tipo, p.tiempoApxProduccion tiempo_apx_produccion '
                . 'FROM AdminBundle:Producto p ' 
                . 'WHERE p.nombre LIKE :data '
                . 'OR p.descripcion LIKE :data '
                . 'OR p.codigoProd LIKE :data '
                . 'AND p.estado = 1 '
                . 'ORDER BY p.id ASC'
                )
                ->setParameter('data', '%' . $data . '%');
        
        $results = $query->getArrayResult();
         
        $response = new JsonResponse( $results );
        return $response;
    }

////////////////////////////////////////////////////////////////////////////////////////////////////////////////
////////////////////////     Guardar JSON /////////////////////////////////////////////////////////////////////
////////////////////////////////////////////////////////////////////////////////////////////////////////////////

    // guardar datos nueva Empresa
    public function empresaGuardarJsonAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
        	$content = json_decode( $request->getContent(), true );
        	
            // captura de datos desde el formulario
            $id                 = ($content['id']) ? $content['id']: 0;
            $nombre             = ucfirst($content['nombre']);
            $rsocial            = ucfirst($content['razonsocial']);
            $rut                = $content['rut'];
            $comuna             = $content['comuna'];
            $provincia          = $content['provincia'];
            $region             = $content['region'];
            $dir_villa_pobl     = ucfirst($content['dir_villa_pbla']);
            $dir_calle          = ucfirst($content['dir_calle']);
            $dir_numero         = $content['dir_numero'];
            $dir_numero_depto   = $content['dir_numero_departamento'];
            $dir_numero_piso    = $content['dir_numero_piso'];
            $celular            = $content['celular'];
            $mail               = $content['correo'];
            $telefono           = $content['telefono'];
            $web                = $content['web'];
            $obs                = ucfirst($content['observacion']);
            $coordenadas        = $content['coordenadas'];
            $imagen             = $content['imagen'];
            //$imagen             = ($request->files->get('imagen', false))? $request->files->get('imagen'): null;

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
            /*if ($imagen)
            {
                $dir_image = $this->subirImagen($imagen);
                $empresa->setImagen($dir_image);
            } 
            */           

            $em->persist($empresa);
            $em->flush();
            $result = true;

        }
    
        return new JsonResponse($result);
    }

    // guarda nuevo Contacto Json
    public function contactoGuardarJsonAction(Request $request)
    {
        $result = false;

        if( $request->getMethod() == 'POST' )
        {
        	$content = json_decode( $request->getContent(), true );
            // captura de datos desde el formulario
            $id                 = ($content['id']) ? $content['id']: 0;
            $primer_nombre      = ucfirst($content['primer_nombre']);
            $segundo_nombre     = ucfirst($content['segundo_nombre']);
            $apellido_paterno   = ucfirst($content['apellido_paterno']);
            $apellido_materno   = ucfirst($content['apellido_materno']);
            $email              = $content['correo'];
            $telefono           = $content['telefono'];
            $cargo              = ucfirst($content['cargo']);
            $observacion        = ucfirst($content['observacion']);
            $imagen             = $content['imagen'];
            //$cargoId            = $content['cargo_id'];

            //$imagen             = ($request->files->get('contacto_img', false))? $request->files->get('contacto_img'): null;

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
            $contacto->setCargo($em->getRepository('AdminBundle:Cargo')->findOneBy(array('id'=>$cargo)));
            $contacto->setObservacion($observacion);
            //$contacto->setCargoId($cargoId);
         
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

        $response = new JsonResponse($result);
        return $response;
    }

    private $pedidoArr;
    // guardar Pedido Datos
    public function pedidoGuardarJsonAction(Request $request)
    {
      $this->pedidoArr = [];
      $result = false;

        if ($request->getMethod() == 'POST') 
        {
        	$content = json_decode( $request->getContent(), true );
          //printf('<pre>'); var_dump($content);  printf('</pre>');
          $this->pedidoArr = $content;

        	$pedido_id = $this->handlePedidoArray();
        	$this->handlePedidoDetalleArray($pedido_id);
        	//$this->handleDetallePedidoOpcionesProductoArray();

          $result = true;
        }

        $response = new JsonResponse($result);
        
        return $response;
    }

    private function handlePedidoArray()
    {
    	$tempPedido = $this->pedidoArr['pedidos']; // printf('<pre>'); var_dump($tempPedido);  printf('</pre>');

			$em = $this->getDoctrine()->getManager();
			$pedidoRow = $em->getRepository('AdminBundle:Pedidos');

      //if( (!$pedidoRow->findOneBy(array( 'id' => $tempPedido['id'] )) ) && ($tempPedido['id'] !=0) )

        $pedidoRow = new Pedidos();

        $pedidoRow->setCodigoPedido($tempPedido['codigo_pedido']);
        $pedidoRow->setFechaIngreso(new \DateTime(date("d-m-Y H:i:s")));                
				$pedidoRow->setFechaModificacion(new \DateTime(date("d-m-Y H:i:s")));

      	$pedidoRow->setDescuentos($tempPedido['descuentos']);
				$pedidoRow->setValorNeto($tempPedido['valor_neto']);
				$pedidoRow->setTotal($tempPedido['total']);
				$pedidoRow->setObservacion($tempPedido['observacion']);
				
				
				//$etapaRow = new Etapas(); // Why??? work in php7.1...
        $etapaRow = $em->getRepository('AdminBundle:Etapas')->find( $tempPedido['fk_etapa'] );
				$pedidoRow->setFkEtapa( $etapaRow );

				//$personalRow = new Personal();
        $personalRow = $em->getRepository('AdminBundle:Personal')->find( $tempPedido['personal_id'] );
				$pedidoRow->setPersonal($personalRow);
				
				//$contacEmpreRow = new ContacEmpre();
        $contacEmpreRow = $em->getRepository('AdminBundle:ContacEmpre')
        										 ->findOneBy(array('id' => $tempPedido['contac_empre_id'] ));

				$pedidoRow->setContacEmpre($contacEmpreRow);
				
      $em->persist($pedidoRow);
      $em->flush();
      
      $id_new = $pedidoRow->getId(); 	//printf('<pre>'); var_dump($id_new);  printf('</pre>');
      return $id_new;
    }

    private function handlePedidoDetalleArray($pedidoId)
    {
      $tempPedidoDetalleArr = $this->pedidoArr['pedido_detalle']; // printf('<pre>'); var_dump($tempPedidoDetalle);  printf('</pre>');


      //if( (!$pedidoDetalleRow->findOneBy(array( 'id' => $tempPedidoDetalle['id'] )) ) && ($tempPedidoDetalle['id'] !=0) )
      foreach ($tempPedidoDetalleArr as $tempPedidoDetalleRow) 
      {
    
      $em = $this->getDoctrine()->getManager();
      $pedidoDetalleRow = $em->getRepository('AdminBundle:PedidoDetalle');
      
        //var_dump($tempPedidoDetalleRow);

        $pedidoDetalleRow = new PedidoDetalle();

        $pedidoDetalleRow->setValorProducto($tempPedidoDetalleRow['valor_producto']);
        $pedidoDetalleRow->setValorModificado($tempPedidoDetalleRow['valor_modificado']);
        $pedidoDetalleRow->setCantidad($tempPedidoDetalleRow['cantidad']);
        $pedidoDetalleRow->setTotal($tempPedidoDetalleRow['total']);
        $pedidoDetalleRow->setObservacion($tempPedidoDetalleRow['observacion']);
        
        
        //$etapaRow = new Etapas(); // Why??? work in php7.1...
        $PedidoEntity = $em->getRepository('AdminBundle:Pedidos')->find( $pedidoId );
        $pedidoDetalleRow->setFkPedido($PedidoEntity);

        //$personalRow = new Personal();
        $ProductoEntity = $em->getRepository('AdminBundle:Producto')->find( $tempPedidoDetalleRow['fk_producto'] );
        $pedidoDetalleRow->setFkProducto($ProductoEntity);
                
        $em->persist($pedidoDetalleRow);
      $em->flush();
      
      $pedidoDetalleId_new = (int) $pedidoDetalleRow->getId();  
      //printf('<pre>'); var_dump($pedidoDetalleId_new);  printf('</pre>');
        foreach($tempPedidoDetalleRow['detallePedido_opcionesProducto'] as $tempPedidoOpciones )
        {
          $this->handleDetallePedidoOpcionesProductoArray( $pedidoDetalleId_new , $tempPedidoOpciones);
        }

      }
  
      //return $id_new;
    }

    private function handleDetallePedidoOpcionesProductoArray($tempPedidoDetalleId , $tempPedidoOpciones)
    {
      $em = $this->getDoctrine()->getManager();
      $detallePedidoOpcionesRow = $em->getRepository('AdminBundle:DetallepedidoOpcionesproducto');

    	$detallePedidoOpcionesRow = new DetallepedidoOpcionesproducto();

      $detallePedidoOpcionesRow->setCantidad($tempPedidoOpciones['cantidad']);
      $detallePedidoOpcionesRow->setValor($tempPedidoOpciones['valor']);
      $detallePedidoOpcionesRow->setLargo($tempPedidoOpciones['largo']);
      $detallePedidoOpcionesRow->setAncho($tempPedidoOpciones['ancho']);
      $detallePedidoOpcionesRow->setPeso($tempPedidoOpciones['peso']);

        
      $OpcionesProductoEntity = $em->getRepository('AdminBundle:OpcionesProducto')->find( $tempPedidoOpciones['opciones_producto_id'] );
      $detallePedidoOpcionesRow->setOpcionesProducto($OpcionesProductoEntity);

      $PedidoDetalleEntity = $em->getRepository('AdminBundle:PedidoDetalle')->find( $tempPedidoDetalleId );
      $detallePedidoOpcionesRow->setPedidoDetalle($PedidoDetalleEntity);
      

      $em->persist($detallePedidoOpcionesRow);
      $em->flush();

    }
    
    ////// look in .... for getting intermediate table ....
    ////// public function ajax_guardar_empresaAction(Request $request)
}

?>