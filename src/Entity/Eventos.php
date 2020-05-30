<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\EventosRepository")
 */
class Eventos
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Nombre;

    /**
     * @ORM\Column(type="string", length=10000)
     */
    private $archivos;

    /**
     * @ORM\Column(type="string", length=80000, nullable=false)
     */
    private $descripcion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $FechaCreacion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $FechaModificacion;

    /**
     * @ORM\Column(type="datetime")
     */
    private $FechaInicio;

    /**
     * @ORM\Column(type="datetime")
     */
    private $FechaFin;
  

    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNombre(): ?string
    {
        return $this->Nombre;
    }

    public function setNombre(string $Nombre): self
    {
        $this->Nombre = $Nombre;

        return $this;
    }

    public function getArchivos(): ?string
    {
        return $this->archivos;
    }

    public function setArchivos(string $archivos): self
    {
        $this->archivos = $archivos;

        return $this;
    }

    public function getDescripcion(): ?string
    {
        return $this->descripcion;
    }

    public function setDescripcion(string $descripcion): self
    {
        $this->descripcion = $descripcion;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->FechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $FechaCreacion): self
    {
        $this->FechaCreacion = $FechaCreacion;

        return $this;
    }

    public function getFechaModificacion(): ?\DateTimeInterface
    {
        return $this->FechaModificacion;
    }

    public function setFechaModificacion(\DateTimeInterface $FechaModificacion): self
    {
        $this->FechaModificacion = $FechaModificacion;

        return $this;
    }

    public function getFechaInicio(): ?\DateTimeInterface
    {
        return $this->FechaInicio;
    }

    public function setFechaInicio(\DateTimeInterface $FechaInicio): self
    {
        $this->FechaInicio = $FechaInicio;

        return $this;
    }

    public function getFechaFin(): ?\DateTimeInterface
    {
        return $this->FechaFin;
    }

    public function setFechaFin(\DateTimeInterface $FechaFin): self
    {
        $this->FechaFin = $FechaFin;

        return $this;
    }
    
}
