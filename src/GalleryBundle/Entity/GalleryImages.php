<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * GalleryBundle\Entity
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks
 * @ORM\Table(name="gallery_images")
 */

class GalleryImages
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="gallery_id", type="integer")
     */
    protected $gallery_id;

    /**
     * @ORM\Column(name="title", type="string")
     */
    protected $title;

    /**
     * @ORM\Column(name="path", type="string")
     */
    protected $path;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\ManyToOne(targetEntity="GalleryBundle\Entity\Gallery", inversedBy="images")
     * @ORM\JoinColumn(name="gallery_id", referencedColumnName="id")
     */
    private $gallery;

    /**
     * @Assert\File(
     *   maxSize="10M",
     *   mimeTypesMessage = "Дозволені файли тільки у форматі: png, jpg, jpeg, gif !!!",
     *   mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif"
     *          }
     *  )
     */
    protected $file;
    /**
     * Sets file.
     */
    public function setFile($file)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get file.
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @var array
     */
    protected $files;

    /**
     * Sets files.
     * @param array $files
     * @return Auto
     */
    public function setFiles($files)
    {
        $this->files = $files;

        return $this;
    }

    /**
     * Get file.
     * @return array
     */
    public function getFiles()
    {
        return $this->files;
    }

    /**
     * Get id
     *
     * @return integer
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set path
     *
     * @param string $path
     *
     * @return Banner
     */
    public function setPath($path)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Banner
     */
    public function setCreation($creation)
    {
        $this->creation = $creation;

        return $this;
    }

    /**
     * Get creation
     *
     * @return \DateTime
     */
    public function getCreation()
    {
        return $this->creation;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return Gallery
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set galleryId
     *
     * @param integer $galleryId
     *
     * @return GalleryImages
     */
    public function setGalleryId($galleryId)
    {
        $this->gallery_id = $galleryId;

        return $this;
    }

    /**
     * Get galleryId
     *
     * @return integer
     */
    public function getGalleryId()
    {
        return $this->gallery_id;
    }

    /**
     * Set gallery
     *
     * @param \GalleryBundle\Entity\Gallery $gallery
     *
     * @return GalleryImages
     */
    public function setGallery(\GalleryBundle\Entity\Gallery $gallery = null)
    {
        $this->gallery = $gallery;

        return $this;
    }

    /**
     * Get gallery
     *
     * @return \GalleryBundle\Entity\Gallery
     */
    public function getGallery()
    {
        return $this->gallery;
    }
}
