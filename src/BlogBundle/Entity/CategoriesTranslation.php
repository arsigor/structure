<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * CategoriesTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="blog_categories_translation")
 */
class CategoriesTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
{
    use \A2lix\I18nDoctrineBundle\Doctrine\ORM\Util\Translation;

    /**
     * @var string
     *
     * @ORM\Column(name="translatable_id", type="integer")
     */
    private $translatable_id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string")
     */
    private $title;

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
     * Set translatableId
     *
     * @param integer $translatableId
     *
     * @return CategoriesTranslation
     */
    public function setTranslatableId($translatableId)
    {
        $this->translatable_id = $translatableId;

        return $this;
    }

    /**
     * Get translatableId
     *
     * @return integer
     */
    public function getTranslatableId()
    {
        return $this->translatable_id;
    }

    /**
     * Set title
     *
     * @param string $title
     *
     * @return CategoriesTranslation
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
     * Set slug
     *
     * @param string $slug
     *
     * @return CategoriesTranslation
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
