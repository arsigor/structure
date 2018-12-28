<?php

namespace MenuBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Posts
 *
 * @ORM\Entity
 * @ORM\Table(name="menu_routes")
 */
class Routes
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @ORM\Column(name="module", type="string")
     */
    protected $module;

    /**
     * @ORM\Column(name="route", type="string", nullable=true)
     */
    protected $route;

    /**
     * @ORM\Column(name="param_id", type="string", nullable=true)
     */
    protected $param_id;

    /**
     * @ORM\Column(name="param_slug", type="text", nullable=true)
     */
    protected $param_slug;

    /**
     * @ORM\Column(name="attributes_tag", type="string", nullable=true)
     */
    protected $attributes_tag;

    /**
     * @ORM\Column(name="uri", type="string", nullable=true)
     */
    protected $uri;

    /**
     * @ORM\OneToOne(targetEntity="Items", mappedBy="route", cascade={"all"})
     */
    protected $item;

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
     * Set module
     *
     * @param string $module
     *
     * @return Routes
     */
    public function setModule($module)
    {
        $this->module = $module;

        return $this;
    }

    /**
     * Get module
     *
     * @return string
     */
    public function getModule()
    {
        return $this->module;
    }

    /**
     * Set route
     *
     * @param string $route
     *
     * @return Routes
     */
    public function setRoute($route)
    {
        $this->route = $route;

        return $this;
    }

    /**
     * Get route
     *
     * @return string
     */
    public function getRoute()
    {
        return $this->route;
    }

    /**
     * Set paramId
     *
     * @param string $paramId
     *
     * @return Routes
     */
    public function setParamId($paramId)
    {
        $this->param_id = $paramId;

        return $this;
    }

    /**
     * Get paramId
     *
     * @return string
     */
    public function getParamId()
    {
        return $this->param_id;
    }

    /**
     * Set paramSlug
     *
     * @param string $paramSlug
     *
     * @return Routes
     */
    public function setParamSlug($paramSlug)
    {
        $this->param_slug = $paramSlug;

        return $this;
    }

    /**
     * Get paramSlug
     *
     * @return string
     */
    public function getParamSlug()
    {
        return $this->param_slug;
    }

    /**
     * Set item
     *
     * @param \MenuBundle\Entity\Items $item
     *
     * @return Routes
     */
    public function setItem(\MenuBundle\Entity\Items $item = null)
    {
        $this->item = $item;

        return $this;
    }

    /**
     * Get item
     *
     * @return \MenuBundle\Entity\Items
     */
    public function getItem()
    {
        return $this->item;
    }

    /**
     * Set attributesTag
     *
     * @param string $attributesTag
     *
     * @return Routes
     */
    public function setAttributesTag($attributesTag)
    {
        $this->attributes_tag = $attributesTag;

        return $this;
    }

    /**
     * Get attributesTag
     *
     * @return string
     */
    public function getAttributesTag()
    {
        return $this->attributes_tag;
    }

    /**
     * Set uri
     *
     * @param string $uri
     *
     * @return Routes
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
}
