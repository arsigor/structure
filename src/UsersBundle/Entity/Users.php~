<?php

namespace UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use FOS\UserBundle\Model\User as BaseUser;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="UsersBundle\Entity\Repository\UsersRepository")
 * @ORM\HasLifecycleCallbacks()
 * @ORM\Table(name="users",indexes={
 * @Index(name="firstname_idx", columns={"firstname"}),
 *      @Index(name="firstname_idx", columns={"firstname"}, options={"length": 20}),
 *      @Index(name="lastname_idx", columns={"lastname"}, options={"length": 20}),
 *      @Index(name="patronymic_idx", columns={"patronymic"}, options={"length": 20}),
 *      @Index(name="username", columns={"username"}, options={"length": 20}),
 *      @Index(name="email_idx", columns={"email"}, options={"length": 20}),
 * }))
 */
class Users extends BaseUser
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="firstname", type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 25,
     *     minMessage = "min 2",
     *     maxMessage = "max 25"
     * )
     */
    protected $firstname;

    /**
     * @ORM\Column(name="lastname", type="string")
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min = 2,
     *     max = 25,
     *     minMessage = "min 2",
     *     maxMessage = "max 25"
     * )
     */
    protected $lastname;

    /**
     * @ORM\Column(name="patronymic", type="string", nullable=true)
     */
    protected $patronymic;

    /**
     * @ORM\Column(name="birthday", type="date", nullable=true)
     * @Assert\Date()
     */
    protected $birthday;

    /**
     * @ORM\Column(name="path", type="string", nullable=true)
     */
    protected $path;

    /**
     * @ORM\Column(name="phone", type="string")
     */
    protected $phone;

    /**
     * @ORM\Column(name="created_at", type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(name="updated_at", type="datetime")
     */
    protected $updated_at;

//    /**
//     * @ORM\Column(name="level_id", type="integer", nullable=true)
//     */
//    protected $level_id;
//
//    /**
//     * @ORM\ManyToOne(targetEntity="BlogBundle\Entity\Levels", inversedBy="users")
//     * @ORM\JoinColumn(name="level_id", referencedColumnName="id")
//     */
//    private $level;

    /**
     * @var ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="BlogBundle\Entity\Levels", inversedBy="users")
     * @ORM\JoinTable(name="levels_users",
     *      joinColumns={@ORM\JoinColumn(name="level_id", referencedColumnName="id")},
     *      inverseJoinColumns={@ORM\JoinColumn(name="user_id", referencedColumnName="id")}
     * )
     */
    private $levels;

    /**
     * @ORM\OneToMany(targetEntity="UsersBundle\Entity\UsersLog", mappedBy="users", cascade={"ALL"})
     **/
    private $logs;

    public $role;

    public function getRole()
    {
        return $this->role;
    }

    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

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
    protected $file;

    /**
     * @ORM\PrePersist()
     * @ORM\PreUpdate()
     */
    public function preUpload()
    {
        if (null !== $this->getFile()) {
            if(null !== $this->getPath()){ unlink($this->getUploadRootDir().'/'.$this->getPath());}
            $this->path = uniqid().'.'.$this->getFile()->guessExtension();
            $name = $this->generateRandomFilename();
            $this->path = $name.'.'.$this->getFile()->guessExtension();
            }
    }

    /**
     * Generates a 32 char long random filename
     *
     * @return string
     */
    public function generateRandomFilename()
    {
        $count = 0;
        do {
            $random = random_bytes(16);
            $randomString = bin2hex($random);
            $count++;
           }
        while(file_exists($this->getUploadRootDir().'/'.$randomString.'.'.$this->getFile()->guessExtension()) && $count < 50);
        return $randomString;
    }

    public function getAbsolutePath() { return null === $this->path ? null : $this->getUploadRootDir().'/'.$this->path; }
    public function getWebPath() { return null === $this->path ? null : $this->getUploadDir().'/'.$this->path; }
    protected function getUploadRootDir() { return __DIR__.'/../../../web/'.$this->getUploadDir(); }
    protected function getUploadDir() { return '/data/users/'.$this->getId(); }

    /**
     * Sets file.
     * @param UploadedFile $file
     */
    public function setFile(UploadedFile $file = null)
    {
        $this->file = $file;
    }

    /**
     * Get file.
     * @return UploadedFile
     */
    public function getFile()
    {
        return $this->file;
    }

    /**
     * @ORM\PostPersist()
     * @ORM\PostUpdate()
     */
    public function upload()
    {
        if (null === $this->getFile()) {
            return;
            }
        $this->getFile()->move($this->getUploadRootDir().'/', $this->path);

        $this->file = null;
    }

    /**
     * @ORM\PostRemove()
     */
    public function removeUpload()
    {
        $file = $this->getUploadRootDir().'/'.$this->path;
        if (is_file($file)) {
            unlink($file);
        }
    }

    public function __construct()
    {
        parent::__construct();
        $this->logs = new ArrayCollection();
        $this->levels = new ArrayCollection();
    }


    /**
     * Set firstname.
     *
     * @param string $firstname
     *
     * @return Users
     */
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get firstname.
     *
     * @return string
     */
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * Set lastname.
     *
     * @param string $lastname
     *
     * @return Users
     */
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get lastname.
     *
     * @return string
     */
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * Set patronymic.
     *
     * @param string|null $patronymic
     *
     * @return Users
     */
    public function setPatronymic($patronymic = null)
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * Get patronymic.
     *
     * @return string|null
     */
    public function getPatronymic()
    {
        return $this->patronymic;
    }

    /**
     * Set birthday.
     *
     * @param \DateTime|null $birthday
     *
     * @return Users
     */
    public function setBirthday($birthday = null)
    {
        $this->birthday = $birthday;

        return $this;
    }

    /**
     * Get birthday.
     *
     * @return \DateTime|null
     */
    public function getBirthday()
    {
        return $this->birthday;
    }

    /**
     * Set path.
     *
     * @param string|null $path
     *
     * @return Users
     */
    public function setPath($path = null)
    {
        $this->path = $path;

        return $this;
    }

    /**
     * Get path.
     *
     * @return string|null
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set createdAt.
     *
     * @param \DateTime $createdAt
     *
     * @return Users
     */
    public function setCreatedAt($createdAt)
    {
        $this->created_at = $createdAt;

        return $this;
    }

    /**
     * Get createdAt.
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->created_at;
    }

    /**
     * Set updatedAt.
     *
     * @param \DateTime $updatedAt
     *
     * @return Users
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updated_at = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt.
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    /**
     * Add log.
     *
     * @param \UsersBundle\Entity\UsersLog $log
     *
     * @return Users
     */
    public function addLog(\UsersBundle\Entity\UsersLog $log)
    {
        $this->logs[] = $log;

        return $this;
    }

    /**
     * Remove log.
     *
     * @param \UsersBundle\Entity\UsersLog $log
     *
     * @return boolean TRUE if this collection contained the specified element, FALSE otherwise.
     */
    public function removeLog(\UsersBundle\Entity\UsersLog $log)
    {
        return $this->logs->removeElement($log);
    }

    /**
     * Get logs.
     *
     * @return \Doctrine\Common\Collections\Collection
     */
    public function getLogs()
    {
        return $this->logs;
    }

    /**
     * Set phone.
     *
     * @param string $phone
     *
     * @return Users
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone.
     *
     * @return string
     */
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Add level.
     *
     * @param \BlogBundle\Entity\Levels $level
     *
     * @return Users
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
