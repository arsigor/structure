<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Categories
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="blog_categories")
 */
class Categories
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

//    /**
//     * @ORM\Column(name="level_id", type="integer")
//     */
//    protected $level_id;

    /**
     * @ORM\Column(name="pid", type="integer", nullable=true)
     */
    protected $pid;

    /**
     * @ORM\OneToMany(targetEntity="Categories", mappedBy="parent", cascade={"ALL"}, orphanRemoval=true)
     */
    private $childrens;

    /**
     * @ORM\ManyToOne(targetEntity="Categories", inversedBy="childrens")
     * @ORM\JoinColumn(name="pid", referencedColumnName="id")
     */
    private $parent;

    /**
     * @ORM\OneToMany(targetEntity="BlogBundle\Entity\Posts", mappedBy="category", cascade={"ALL"}, orphanRemoval=true)
     **/
    private $posts;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Levels", inversedBy="categories")
     * @ORM\JoinTable(name="levels_categories",
     *      joinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="category_id", referencedColumnName="id")}
     * )
     */
    private $levels;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\Column(name="modify", type="datetime")
     */
    protected $modify;

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

    private $translations;

    public function __construct()
    {
        $this->childrens = new ArrayCollection();
        $this->posts = new ArrayCollection();
        $this->levels = new \Doctrine\Common\Collections\ArrayCollection();
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
     * @return Categories
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
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Categories
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
     * @return Categories
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
     * Add children
     *
     * @param \BlogBundle\Entity\Categories $children
     *
     * @return Categories
     */
    public function addChildren(\BlogBundle\Entity\Categories $children)
    {
        $this->childrens[] = $children;

        return $this;
    }

    /**
     * Remove children
     *
     * @param \BlogBundle\Entity\Categories $children
     */
    public function removeChildren(\BlogBundle\Entity\Categories $children)
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
     * @param \BlogBundle\Entity\Categories $parent
     *
     * @return Categories
     */
    public function setParent(\BlogBundle\Entity\Categories $parent = null)
    {
        $this->parent = $parent;

        return $this;
    }

    /**
     * Get parent
     *
     * @return \BlogBundle\Entity\Categories
     */
    public function getParent()
    {
        return $this->parent;
    }

    /**
     * Add post
     *
     * @param \BlogBundle\Entity\Posts $post
     *
     * @return Categories
     */
    public function addPost(\BlogBundle\Entity\Posts $post)
    {
        $this->posts[] = $post;

        return $this;
    }

    /**
     * Remove post
     *
     * @param \BlogBundle\Entity\Posts $post
     */
    public function removePost(\BlogBundle\Entity\Posts $post)
    {
        $this->posts->removeElement($post);
    }

    /**
     * Get posts
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getPosts()
    {
        return $this->posts;
    }

    /**
     * Add level.
     *
     * @param \BlogBundle\Entity\Levels $level
     *
     * @return Categories
     */
    public function addLevel(\BlogBundle\Entity\Levels $level)
    {
        $this->levels[] = $level;

        return $this;
    }

    /**
     * Remove level.
     *
     * @param \BlogBundle\Entity\Levels $level
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLevel(\BlogBundle\Entity\Levels $level)
    {
        return $this->levels->removeElement($level);
    }

    /**
     * Get levels.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLevels()
    {
        return $this->levels;
    }
}
