<?php

namespace MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * Posts
 *
 * @ORM\Entity
 * @ORM\Table(name="menu_items")
 */
class Items
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
     * @ORM\Column(name="menu", type="integer")
     */
    protected $menu;

    /**
     * @ORM\Column(name="pid", type="integer", nullable=true)
     */
    protected $pid;

    /**
     * @ORM\Column(name="number", type="integer")
     */
    protected $number;

    /**
     * @ORM\OneToOne(targetEntity="Routes", inversedBy="item")
     * @ORM\JoinColumn(name="route", referencedColumnName="id")
     */
    protected $route;


    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\OneToMany(targetEntity="Items", mappedBy="parent")
     */
    private $childrens;

    /**
     * @ORM\ManyToOne(targetEntity="Items", inversedBy="childrens")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id")
     */
    private $parent;

    private $translations;

    public function __construct()
    {
        $this->childrens = new ArrayCollection();
    }

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
     * Set pid
     *
     * @param integer $pid
     *
     * @return Items
     */
    public function setPid($pid)
    {
        $this->pid = $pid;

        return $this;
    }

    /**
     * Get pid
     *
     * @return integer
     */
    public function getPid()
    {
        return $this->pid;
    }

    /**
     * Set number
     *
     * @param integer $number
     *
     * @return Items
     */
    public function setNumber($number)
    {
        $this->number = $number;

        return $this;
    }

    /**
     * Get number
     *
     * @return integer
     */
    public function getNumber()
    {
        return $this->number;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Items
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
     * Set route
     *
     * @param \MenuBundle\Entity\Routes $route
     *
     * @return Items
     */
    public function setRoute(\MenuBundle\Entity\Routes $route = null)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return \MenuBundle\Entity\Routes
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Add children
     *
     * @param \MenuBundle\Entity\Items $children
     *
     * @return Items
     */
    public function addChildren(\MenuBundle\Entity\Items $children)
    {
        $this->childrens[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \MenuBundle\Entity\Items $children
     */
    public function removeChildren(\MenuBundle\Entity\Items $children)
    {
        $this->childrens->removeElement($children);
    }

    /**
     * Get childrens
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getChildrens()
    {
        return $this->childrens;
    }

    /**
     * Set parent
     *
     * @param \MenuBundle\Entity\Items $parent
     *
     * @return Items
     */
    public function setParent(\MenuBundle\Entity\Items $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \MenuBundle\Entity\Items
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Set menu
     *
     * @param integer $menu
     *
     * @return Items
     */
    public function setMenu($menu)
    {
        $this->menu = $menu;

        return $this;
    }

    /**
     * Get menu
     *
     * @return integer
     */
    public function getMenu()
    {
        return $this->menu;
    }
}
