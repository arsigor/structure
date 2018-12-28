<?php

namespace UsersBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * UsersBundle\Entity
 *
 * @ORM\Entity(repositoryClass="UsersBundle\Entity\Repository\UsersLogRepository")
 * @ORM\Table(name="users_log")
 */

class UsersLog
{
    /**
     * @ORM\Id
     * @ORM\Column(name="id", type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(name="user_id", type="integer", nullable=true)
     */
    protected $user_id;

    /**
     * @ORM\Column(name="user_ip", type="string")
     */
    protected $user_ip;

    /**
     * @ORM\Column(name="url", type="string", nullable=true)
     */
    protected $url;

    /**
     * @ORM\Column(name="creation", type="datetime")
     */
    protected $creation;

    /**
     * @ORM\ManyToOne(targetEntity="UsersBundle\Entity\Users", inversedBy="logs")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    private $users;

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
     * Set userId
     *
     * @param integer $userId
     *
     * @return UsersLog
     */
    public function setUserId($userId)
    {
        $this->user_id = $userId;

        return $this;
    }

    /**
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set userIp
     *
     * @param string $userIp
     *
     * @return UsersLog
     */
    public function setUserIp($userIp)
    {
        $this->user_ip = $userIp;

        return $this;
    }

    /**
     * Get userIp
     *
     * @return string
     */
    public function getUserIp()
    {
        return $this->user_ip;
    }

    /**
     * Set url
     *
     * @param string $url
     *
     * @return UsersLog
     */
    public function setUrl($url)
    {
        $this->url = $url;

        return $this;
    }

    /**
     * Get url
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * Set creation
     *
     * @param \DateTime $creation
     *
     * @return UsersLog
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
     * Set users
     *
     * @param \UsersBundle\Entity\Users $users
     *
     * @return UsersLog
     */
    public function setUsers(\UsersBundle\Entity\Users $users = null)
    {
        $this->users = $users;

        return $this;
    }

    /**
     * Get users
     *
     * @return \UsersBundle\Entity\Users
     */
    public function getUsers()
    {
        return $this->users;
    }
}
