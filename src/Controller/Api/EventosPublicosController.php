<?php

namespace App\Controller\Api;

use App\Repository\EventosRepository;
use App\Helpers\HelperConvertingData;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Httpkernel\Exception\NotFoundHttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventosController
 * @package App\Controller
 * 
 * @Route(path="/api/events/")
 */

class EventosPublicosController extends AbstractController
{
    private $EventosRepository;
    private $HelperConvertingData;

    public function __construct(EventosRepository $EventosRepository )
    {
        $this->EventosRepository =  $EventosRepository;
  
    }

    /**
     * @Route("getall", name="get_events", methods={"GET"})
     */
    public function getAllEvents():JsonResponse
    {
        $events = $this->EventosRepository->findAll();
        $data= [];
        foreach($events as $eve){
            $data[] = [
                'id' => $eve->getId(),
                'nombre'=> $eve->getNombre(),
                'archivos'=>$eve->getArchivos(),
                'descripcion'=>$eve->getDescripcion(),
                'fecha_creacion'=>$eve->getFechaCreacion(),
                'fecha_modificacion'=>$eve->getFechaModificacion(),
                'fecha_inicio'=>$eve->getFechaInicio(),
                'fecha_fin'=>$eve->getFechaFin(),
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        //$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }
    /**
     * @Route("findbyid/{id}", name="eventos_by_id", methods={"GET"})
     */
    public function getEventoById($id): JsonResponse
    {
        if(empty($id)){
            //throw new NotFoundHttpException('Faltan algunos parametros');
            //return new Response($serializer->serialize(['errors' => $errors], "json"), Response::HTTP_BAD_REQUEST);
            return new JsonResponse(['error'=>'el parametro id esta vacio'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $event = $this->EventosRepository->findOneBy(['id'=> $id]);
        $data= [
            'id' => $event->getId(),
            'nombre'=> $event->getNombre(),
            'archivos'=>$event->getArchivos(),   
            'descripcion'=>$event->getDescripcion(),
            'fecha_creacion'=> HelperConvertingData::dateConvertSet($event->getFechaCreacion()),
            'fecha_modificacion'=>HelperConvertingData::dateConvertSet($event->getFechaModificacion()),
            'fecha_inicio'=>HelperConvertingData::dateConvertSet($event->getFechaInicio()),
            'fecha_fin'=>HelperConvertingData::dateConvertSet($event->getFechaFin()),        
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
}
