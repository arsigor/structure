<?php

namespace BlogBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 *Blog
 *
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="blog_posts")
 * @ORM\Entity(repositoryClass="BlogBundle\Entity\Repository\PostsRepository")
 */
class Posts
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
     * @var string
     *
     * @ORM\Column(name="path1", type="string", nullable=true)
     */
    private $path1;

    /**
     * @ORM\Column(name="category_id", type="integer", nullable=true)
     */
    protected $category_id;

    /**
     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Categories", inversedBy="posts")
     * @ORM\JoinColumn(name="category_id", referencedColumnName="id")
     */
    private $category;

    /**
     * @ORM\Column(name="begin_date", type="datetime")
     */
    protected $begin_date;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\Column(name="modify", type="datetime")
     */
    protected $modify;

    /**
     * @Assert\File(
     *   maxSize="10M",
     *   mimeTypesMessage = "Дозволені файли тільки у форматі: png, jpg, jpeg, gif !!!",
     *   mimeTypes = {
     *          "image/png",
     *          "image/jpeg",
     *          "image/jpg",
     *          "image/gif"
     *          }
     *  )
     */
    protected $file1;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if ($this->getFile1() != NULL) {
            if($this->getPath1() != NULL){ if(is_file($this->getUploadRootDir().'/'.$this->getPath1())){unlink($this->getUploadRootDir().'/'.$this->getPath1());} }
            $this->path1 = uniqid().'.'.$this->getFile1()->guessExtension();
            $name1 = $this->generateRandomFilename1();
            $this->path1 = $name1.'.'.$this->getFile1()->guessExtension();
        }
    }

    /**
     * Generates a 32 char long random filename
     *
     * @return string
     */
    public function generateRandomFilename1()
    {
        $count = 0;
        do {
            $random = random_bytes(16);
            $randomString = bin2hex($random);
            $count++;
        }
        while(file_exists($this->getUploadRootDir().'/'.$randomString.'.'.$this->getFile1()->guessExtension()) && $count < 50);
        return $randomString;
    }

    public function getAbsolutePath() { return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path; }
    public function getWebPath() { return null === $this->path ? null : $this->getUploadDir().'/'.$this->path; }
    protected function getUploadRootDir() { return __DIR__.'/../../../web/'.$this->getUploadDir(); }
    protected function getUploadDir() { return '/data/news/'.$this->id; }

    /**
     * Sets file1.
     * @param UploadedFile $file1
     */
    public function setFile1(UploadedFile $file1 = null)
    {
        $this->file1 = $file1;
    }

    /**
     * Get file1.
     * @return UploadedFile
     */
    public function getFile1()
    {
        return $this->file1;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if ($this->getFile1() != NULL) {
            $this->getFile1()->move($this->getUploadRootDir().'/', $this->path1);
        }
        $this->file1 = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file1 = $this->getUploadRootDir().'/'.$this->path1;
        if (is_file($file1)) {
            unlink($file1);
        }
    }

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
     * Set path1
     *
     * @param string $path1
     *
     * @return Posts
     */
    public function setPath1($path1)
    {
        $this->path1 = $path1;

        return $this;
    }

    /**
     * Get path1
     *
     * @return string
     */
    public function getPath1()
    {
        return $this->path1;
    }

    /**
     * Set beginDate
     *
     * @param \DateTime $beginDate
     *
     * @return Posts
     */
    public function setBeginDate($beginDate)
    {
        $this->begin_date = $beginDate;

        return $this;
    }

    /**
     * Get beginDate
     *
     * @return \DateTime
     */
    public function getBeginDate()
    {
        return $this->begin_date;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return Posts
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
     * Set categoryId
     *
     * @param integer $categoryId
     *
     * @return Posts
     */
    public function setCategoryId($categoryId)
    {
        $this->category_id = $categoryId;

        return $this;
    }

    /**
     * Get categoryId
     *
     * @return integer
     */
    public function getCategoryId()
    {
        return $this->category_id;
    }

    /**
     * Set category
     *
     * @param \BlogBundle\Entity\Categories $category
     *
     * @return Posts
     */
    public function setCategory(\BlogBundle\Entity\Categories $category = null)
    {
        $this->category = $category;

        return $this;
    }

    /**
     * Get category
     *
     * @return \BlogBundle\Entity\Categories
     */
    public function getCategory()
    {
        return $this->category;
    }

    /**
     * Set modify.
     *
     * @param \DateTime $modify
     *
     * @return Posts
     */
    public function setModify($modify)
    {
        $this->modify = $modify;

        return $this;
    }

    /**
     * Get modify.
     *
     * @return \DateTime
     */
    public function getModify()
    {
        return $this->modify;
    }
}
