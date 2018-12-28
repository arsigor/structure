<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;


/**
 * Gallery
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="gallery")
 */
class Gallery
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translatable;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="show_gallery", type="integer", nullable=true)
     */
    protected $show_gallery;

    /**
     * @var string
     *
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    private $path;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\Column(name="modify", type="datetime", nullable=true)
     */
    protected $modify;

    private $translations;

    /**
     * @ORM\OneToMany(targetEntity="GalleryBundle\Entity\GalleryImages", mappedBy="gallery", cascade={"ALL"}, orphanRemoval=true)
     **/
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    /**
     * @return mixed
     */
    public function __toString()
    {
        $title = [];
        foreach ($this->translations as $translation) {
            $title[] = $translation->getTitle();
        }
        return reset($title);
    }

    public function getTitle()
    {
        if (!$this->getCurrentTranslation()) {
            $title = 'No translations found...';
        } else {
            $title = $this->getCurrentTranslation()->getTitle();
        }
        return $title;
    }

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
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            if (null !== $this->getPath()) {
                unlink($this->getUploadRootDir() . '/' . $this->getPath());
            }
            $this->path = uniqid() . '.' . $this->getFile()->guessExtension();
            $name = $this->generateRandomFilename();
            $this->path = $name . '.' . $this->getFile()->guessExtension();
        }
    }

    /**
     * Generates a 32 char long random filename
     *
     * @return string
     */
    public function generateRandomFilename()
    {
        $count = 0;
        do {
            $random = random_bytes(16);
            $randomString = bin2hex($random);
            $count++;
        } while (file_exists($this->getUploadRootDir() . '/' . $randomString . '.' . $this->getFile()->guessExtension()) && $count < 50);
        return $randomString;
    }

    public function getAbsolutePath()
    {
        return null === $this->path ? null : $this->getUploadRootDir() . '/' . $this->path;
    }

    public function getWebPath()
    {
        return null === $this->path ? null : $this->getUploadDir() . '/' . $this->path;
    }

    protected function getUploadRootDir()
    {
        return __DIR__ . '/../../../web/' . $this->getUploadDir();
    }

    protected function getUploadDir()
    {
        return '/data/images/gallery/';
    }

    /**
     * Sets file.
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
        }
        $this->getFile()->move($this->getUploadRootDir() . '/', $this->path);

        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getUploadRootDir() . '/' . $this->path;
        if (is_file($file)) {
            unlink($file);
        }
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
     * @return Gallery
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
     * @return Gallery
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
     * Set modify
     *
     * @param \DateTime $modify
     *
     * @return Gallery
     */
    public function setModify($modify)
    {
        $this->modify = $modify;

        return $this;
    }

    /**
     * Get modify
     *
     * @return \DateTime
     */
    public function getModify()
    {
        return $this->modify;
    }

    /**
     * Add image
     *
     * @param \GalleryBundle\Entity\GalleryImages $image
     *
     * @return Gallery
     */
    public function addImage(\GalleryBundle\Entity\GalleryImages $image)
    {
        $this->images[] = $image;

        return $this;
    }

    /**
     * Remove image
     *
     * @param \GalleryBundle\Entity\GalleryImages $image
     */
    public function removeImage(\GalleryBundle\Entity\GalleryImages $image)
    {
        $this->images->removeElement($image);
    }

    /**
     * Get images
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getImages()
    {
        return $this->images;
    }


    /**
     * Set showGallery
     *
     * @param integer $showGallery
     *
     * @return Gallery
     */
    public function setShowGallery($showGallery)
    {
        $this->show_gallery = $showGallery;

        return $this;
    }

    /**
     * Get showGallery
     *
     * @return integer
     */
    public function getShowGallery()
    {
        return $this->show_gallery;
    }
}
