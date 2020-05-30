<?php

namespace App\Controller\Api;
use App\Repository\EventosRepository;
//Hecho a mano
use App\Helpers\HelperConvertingData;
use App\Helpers\HelperUploadFiles;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Httpkernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Eventos;
use App\Form\EventType;


/**
 * Class EventosController
 * @package App\Controller
 * 
 * @Route(path="/api/events/security/")
 */

class EventosController extends AbstractController
{
    private $EventosRepository;
    private $HelperConvertingData;
    private $HelperHelperUploadFiles;
    

    public function __construct(EventosRepository $EventosRepository )
    {
        $this->EventosRepository =  $EventosRepository;
  
    }
    /**
     * @Route("add", name="add_evento_se", methods={"POST"})
     */

    public function add(Request $request): JsonResponse
    {
        $data= json_decode($request->getContent(), true);

        $dateTime = new \DateTime();

        $nombre = $data['nombre'];
        $archivos = $data['archivos'];
        $descripcion= $data['descripcion'];
        $fecha_creacion= $dateTime;  //$data['fecha_creacion'];
        $fecha_modificacion= $dateTime;//$data['fecha_modificacion'];
        $fecha_inicio= HelperConvertingData::dateConvert($data['fecha_inicio']);
        //$fecha_fin= $dateTime;//$data['fecha_fin'];
        $fecha_fin= HelperConvertingData::dateConvert($data['fecha_fin']);
        if(empty($nombre)|| empty($descripcion || empty($fecha_inicio) ||empty($fecha_fin) || empty($archivos))){
            //throw new NotFoundHttpException('Faltan algunos parametros');
            //return new Response($serializer->serialize(['errors' => $errors], "json"), Response::HTTP_BAD_REQUEST);
            return new JsonResponse(['error'=>'Faltan algunos parametros'], Response::HTTP_CREATED);
        }

        $ext= $archivos['ext'];
        $fileName =$archivos['fileName'];
        $base64= $archivos['base64'];
        $archivos = HelperUploadFiles::uploadImg($ext, $fileName, $base64 );
        //$s=$this->uploadImage2($ext, $fileName, $base64);
        $result= $this->EventosRepository->saveEvento($nombre, $archivos, $descripcion,  $fecha_creacion, $fecha_modificacion, $fecha_inicio, $fecha_fin);
        return new JsonResponse(['status'=>'evento Creado', 'id'=>$result], Response::HTTP_CREATED);
    }
     /**
     * @Route("add/uploadImg", name="add_evento_img", methods={"POST"})
     */
    public function uploadImage(Request $request): JsonResponse
    {
        /*
        $data= json_decode($request->getContent(), true);
        //$archivos = $request->files->get('archivos', null);
        //$id = $request->get('id', null);
        $stringfile= $data['archivos'];

        $archivos=null;

         //$archivos = base64_decode($stringfile);
        
        $ext='.png';
        $fileName='file_name2'.$ext;
        $base64 = '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';
        $file=fopen('path_to_upload_dir'.$fileName, 'wb');
        fwrite($file, base64_decode($base64));
        fclose($file);
        //$img_file = '%kernel.project_dir%/public/uploads/brochures/dfslk.png';
        //imagepng($im, $img_file, 0);
        return new JsonResponse(['status'=>'Imagen subida correctamente!', 'archivo'=>'holalindo'], Response::HTTP_OK);
        if($archivos == null){
            return new JsonResponse(['error'=>'Error al subir imagen'], Response::HTTP_BAD_REQUEST);
        }

        //$evento = $this->EventosRepository->findOneBy(['id'=>$id]);

        if($archivos){
            $file_name = md5(uniqid()).'.'.$archivos->guessExtension();
           
            try {
                    $archivos->move(
                        $this->getParameter('brochures_directory'),
                        $file_name
                    );
            } catch (FileException $e) {
                return new JsonResponse(['error'=>'Error al subir imagen'], Response::HTTP_BAD_REQUEST);
            }
            //$evento->setArchivos($file_name);   
        }
        //$evento->setFechaModificacion($dateTime);
        //$updateEvento = $this->EventosRepository->updateImgEvento($evento);
       */
      return new JsonResponse(['status'=>'Imagen subida correctamente!', 'archivo'=>'esta desavilitado revisa el api'], Response::HTTP_OK);
    }
     /**
     * @Route("add/uploadImg2", name="add_evento_img2", methods={"POST"})
     */
    public function uploadImage2( $ext, $fileName,$base64 )
    {
        //$data= json_decode($request->getContent(), true);
        
        //$data= json_decode($request->getContent(), true);
        
        //$stringfile= $data['archivos'];
        $ext='.'.$ext;
        $fileName = $fileName;
        //$base64 = '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';
        $ruta = 'uploads/eventsImg/';
        
        $file=fopen($ruta.$fileName, 'wb');
        fwrite($file, base64_decode($base64));
        fclose($file);
        return  $fileName;
        //return new JsonResponse(['status'=>'Imagen subida correctamente!', 'ok'], Response::HTTP_OK);

        //
    /*
        $ext= $data['ext'];
        $fileName =$data['filname'];
        $base64= $data['base64'];
        $resultado = HelperUploadFiles::uploadImg($ext, $fileName, $base64 );
        return new JsonResponse(['status'=>'Imagen subida correctamente!', 'archivo'=>$resultado], Response::HTTP_OK);*/
    }
    

    /**
     * @Route("getall", name="get_events_se", methods={"GET"})
     */
    public function getAllEvents():JsonResponse
    {
        $events = $this->EventosRepository->findAll();
        $data= [];
        foreach($events as $eve){
            $data[] = [
                'id' => $eve->getId(),
                'nombre'=> $eve->getNombre(),
                'archivos'=>HelperUploadFiles::HelperConvertingStringFile($eve->getArchivos()),
                'descripcion'=>$eve->getDescripcion(),
                //'descripcion'=>
                'fecha_creacion'=> HelperConvertingData::dateConvertSet($eve->getFechaCreacion()),
                'fecha_modificacion'=>HelperConvertingData::dateConvertSet($eve->getFechaModificacion()),
                'fecha_inicio'=>HelperConvertingData::dateConvertSet($eve->getFechaInicio()),
                'fecha_fin'=>HelperConvertingData::dateConvertSet($eve->getFechaFin()),
            ];
        }
        $response = new JsonResponse($data, Response::HTTP_OK);
        //$response->headers->set('Access-Control-Allow-Origin', '*');
        return $response;
    }

    
   
    /**
     * @Route("update/{id}", name="evento_update_se", methods={"PUT"})
     */
    public function update($id, Request $request): JsonResponse
    {

        $dateTime = new \DateTime();

        $evento = $this->EventosRepository->findOneBy(['id'=>$id]);
        $data = json_decode($request->getContent(), true);

        $archivos = $data['archivos'];

        $ext= $archivos['ext'];
        $fileName =$archivos['fileName'];
        $base64= $archivos['base64'];
        $archivos = HelperUploadFiles::uploadImg($ext, $fileName, $base64 );

        empty($data['nombre'])? true: $evento->setNombre($data['nombre']);
        empty($data['archivos'])? true: $evento->setArchivos($archivos);
        //empty($data['archivos'])? true: $evento->setArchivos($data['Archivo']);
        empty($data['descripcion'])? true: $evento->setDescripcion($data['descripcion']);
        $evento->setFechaModificacion($dateTime);
        empty($data['fecha_inicio'])? true: $evento->setFechaInicio(HelperConvertingData::dateConvert($data['fecha_inicio']));
        empty($data['fecha_fin'])? true: $evento->setFechaFin(HelperConvertingData::dateConvert($data['fecha_fin']));

        $updateEvento = $this->EventosRepository->updateEvento($evento);

        return new JsonResponse(['status'=>'Evento Update!'], Response::HTTP_OK);
        
    }
    
    /**
     * @Route("delete/{id}", name="delete_evento_se", methods={"DELETE"})
     */
    public function delete($id): JsonResponse
    {
        $evento = $this->EventosRepository->findOneBy(['id'=>$id]);
        if($evento==null){
            return new JsonResponse(['status'=>'evento no encontrado'], Response::HTTP_NOT_FOUND); 
        }else{
            $this->EventosRepository->removeEvent($evento);
            return new JsonResponse(['status'=>'evento eliminado'], Response::HTTP_OK); 
        }
    }
    /**
     * @Route("findbyid/{id}", name="evento_by_id_se", methods={"GET"})
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
            'archivos'=>HelperUploadFiles::HelperConvertingStringFile($event->getArchivos()),   
            'descripcion'=>$event->getDescripcion(),
            'fecha_creacion'=> HelperConvertingData::dateConvertSet($event->getFechaCreacion()),
            'fecha_modificacion'=>HelperConvertingData::dateConvertSet($event->getFechaModificacion()),
            'fecha_inicio'=>HelperConvertingData::dateConvertSet($event->getFechaInicio()),
            'fecha_fin'=>HelperConvertingData::dateConvertSet($event->getFechaFin()),        
        ];
        return new JsonResponse($data, Response::HTTP_OK);
    }
    /**
     * @Route("findbydate", name="eventos_by_date_se", methods={"POST"})
     */
    public function getEventoByDate(Request $request):JsonResponse
    {
        $data= json_decode($request->getContent(), true);

        $fecha= $data['fecha'];
        if(empty($fecha)){
            //throw new NotFoundHttpException('Faltan algunos parametros');
            //return new Response($serializer->serialize(['errors' => $errors], "json"), Response::HTTP_BAD_REQUEST);
            return new JsonResponse(['error'=>'el parametro fecha esta vacio'], Response::HTTP_OK);
        }
        $data= $this->EventosRepository->searchByDate($fecha);
        return new JsonResponse($data, Response::HTTP_OK);

        
    }
}
