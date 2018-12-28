<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * GalleryVideos
 *
 * @ORM\Entity
 * @ORM\Table(name="gallery_videos")
 */
class GalleryVideos
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
     * @ORM\Column(name="uri", type="string", nullable=true)
     */
    protected $uri;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\Column(name="modify", type="datetime")
     */
    protected $modify;

    private $translations;

    /**
     * @return mixed
     */
    public function __toString()
    {
        $title = [];
        foreach ($this->translations as $translation)
        {
            $title[] = $translation->getTitle();
        }

        return reset($title);
    }

    public function getTitle()
    {
        if(!$this->getCurrentTranslation()){
            $title = 'No translations found...';
        } else {
            $title = $this->getCurrentTranslation()->getTitle();
        }
        return $title;
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
     * Set uri
     *
     * @param string $uri
     *
     * @return GalleryVideos
     */
    public function setUri($uri)
    {
        $this->uri = $uri;

        return $this;
    }

    /**
     * Get uri
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return GalleryVideos
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
     * @return GalleryVideos
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
}
