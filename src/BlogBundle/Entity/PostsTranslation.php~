<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * PostsTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="blog_posts_translation")
 */
class PostsTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="brief", type="text", nullable=true)
     */
    private $brief;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="text", nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_title", type="string", length=255, nullable=true)
     */
    private $seo_title;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_keyword", type="string", length=255, nullable=true)
     */
    private $seo_keyword;

    /**
     * @var string
     *
     * @ORM\Column(name="seo_description", type="string", length=255, nullable=true)
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
     * @return PostsTranslation
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
     * Set brief
     *
     * @param string $brief
     *
     * @return PostsTranslation
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return PostsTranslation
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
     * Set seoTitle
     *
     * @param string $seoTitle
     *
     * @return PostsTranslation
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
     * @return PostsTranslation
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
     * @return PostsTranslation
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
     * @return PostsTranslation
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
