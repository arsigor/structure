<?php

namespace PageBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Pages
 *
 * @ORM\Entity
 * @ORM\Table(name="pages")
 */
class Pages
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
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

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
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Pages
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

}
