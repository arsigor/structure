<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Gedmo\Mapping\Annotation as Gedmo;

/**
 * LevelsTranslation
 *
 * @ORM\Entity
 * @ORM\Table(name="blog_categories_levels_translation")
 */
class LevelsTranslation implements \A2lix\I18nDoctrineBundle\Doctrine\Interfaces\OneLocaleInterface
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

    public function __toString()
    {
        return (string)$this->title;
    }

    /**
     * Set translatableId.
     *
     * @param int $translatableId
     *
     * @return LevelsTranslation
     */
    public function setTranslatableId($translatableId)
    {
        $this->translatable_id = $translatableId;

        return $this;
    }

    /**
     * Get translatableId.
     *
     * @return int
     */
    public function getTranslatableId()
    {
        return $this->translatable_id;
    }

    /**
     * Set title.
     *
     * @param string $title
     *
     * @return LevelsTranslation
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }
}
