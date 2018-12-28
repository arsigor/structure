<?php

namespace GalleryBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * GalleryTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="gallery_translation")
 */
class GalleryTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_title", type="string", nullable=true)
     */
    private $seo_title;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keyword", type="string", nullable=true)
     */
    private $seo_keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", nullable=true)
     */
    private $seo_description;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=255, unique=true)
     */
    private $slug;

    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return TagsTranslation
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
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return BannersTranslation
     */
    public function setSeoTitle($seoTitle)
    {
        $this->seo_title = $seoTitle;

        return $this;
    }

    /**
     * Get seoTitle
     *
     * @return string
     */
    public function getSeoTitle()
    {
        return $this->seo_title;
    }

    /**
     * Set seoKeyword
     *
     * @param string $seoKeyword
     *
     * @return BannersTranslation
     */
    public function setSeoKeyword($seoKeyword)
    {
        $this->seo_keyword = $seoKeyword;

        return $this;
    }

    /**
     * Get seoKeyword
     *
     * @return string
     */
    public function getSeoKeyword()
    {
        return $this->seo_keyword;
    }

    /**
     * Set seoDescription
     *
     * @param string $seoDescription
     *
     * @return BannersTranslation
     */
    public function setSeoDescription($seoDescription)
    {
        $this->seo_description = $seoDescription;

        return $this;
    }

    /**
     * Get seoDescription
     *
     * @return string
     */
    public function getSeoDescription()
    {
        return $this->seo_description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return GalleryTranslation
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;

        return $this;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }
}
