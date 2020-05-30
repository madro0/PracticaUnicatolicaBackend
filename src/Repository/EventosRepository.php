<?php

namespace App\Repository;

use App\Entity\Eventos;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Common\Persistence\ManagerRegistry;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;
use App\Helpers\HelperUploadFiles;

/**
 * @method Eventos|null find($id, $lockMode = null, $lockVersion = null)
 * @method Eventos|null findOneBy(array $criteria, array $orderBy = null)
 * @method Eventos[]    findAll()
 * @method Eventos[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class EventosRepository extends ServiceEntityRepository
{
    private $targetDirectory;
    private $slugger;
    
    public function __construct(ManagerRegistry $registry, EntityManagerInterface $manager)
    {
        parent::__construct($registry, Eventos::class);
        $this->manager= $manager;
        //$this->targetDirectory= $targetDirectory;
        //$this->slugger = $slugger;
    }

    //este es una funcion para guardar evento.
    public function saveEvento($nombre, $archivos, $descripcion,  $fecha_creacion, $fecha_modificacion, $fecha_inicio, $fecha_fin): int
    {

        //$ext= $archivos['ext'];
        //$fileName =$archivos['fileName'];
        //$base64= $archivos['base64'];


        $NewEventos = new Eventos();

        $NewEventos
            ->setNombre($nombre)
           
            ->setDescripcion($descripcion)
            ->setFechaCreacion($fecha_creacion)
            ->setFechaModificacion($fecha_modificacion)
            ->setFechaInicio($fecha_inicio)
            ->setFechaFin($fecha_fin)
            ->setArchivos ($archivos);
            
            $this->manager->persist($NewEventos);
            $this->manager->flush();

            return $NewEventos->getId();

    }
    //esta funcion es para actualizar un evento
    public function updateEvento(Eventos $eventos): Eventos
    {
        $this->manager->persist($eventos);
        $this->manager->flush();
        return $eventos;
    }
    public function updateImgEvento(Eventos $eventos): Eventos
    {
        $this->manager->persist($eventos);
        $this->manager->flush();
        return $eventos;
    }

   
    //esta funcion es para buscar un eventos por fecha
    public function searchByDate($fecha): array
    {
        $conn = $this->getEntityManager()->getConnection();
        
        $sql ='
                SELECT * FROM eventos e 
                WHERE CAST(e.fecha_inicio AS DATE) <= :fecha 
                AND CAST(e.fecha_fin AS DATE) >= :fecha
            ';

        $stmt = $conn->prepare($sql);
        $stmt->execute(['fecha'=> $fecha]);
        return $stmt->fetchAll();
    }
    public function searchById($id): array
    {
        $event = $this->manager->findOneBy(['id'=> $id]);
            $data = [
                'description'=>$event->getDescription(),
            ];
        return $data;
    }

    //esta funcion es para eliminar un evento
    public function removeEvent(Eventos $eventos)
    {
        $this->manager->remove($eventos);
        $this->manager->flush();
    }

    // /**
    //  * @return Eventos[] Returns an array of Eventos objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('e.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Eventos
    {
        return $this->createQueryBuilder('e')
            ->andWhere('e.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
