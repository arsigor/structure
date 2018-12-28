<?php

namespace PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PagesTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="pages_translation")
 */
class PagesTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
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
     * @ORM\Column(name="description", type="text")
     */
    private $description;

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
     * @return PagesTranslation
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
     * Set description
     *
     * @param string $description
     *
     * @return PagesTranslation
     */
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    /**
     * Get description
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set slug
     *
     * @param string $slug
     *
     * @return PagesTranslation
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

    /**
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return PagesTranslation
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
     * @return PagesTranslation
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
     * @return PagesTranslation
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
}
