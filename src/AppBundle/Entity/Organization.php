<?php

namespace AppBundle\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Config\Definition\Exception\Exception;
use Symfony\Component\Serializer\Annotation\Groups;

/**
 * Organization
 *
 * @ORM\Table(name="organization")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\OrganizationRepository")
 */
class Organization implements \JsonSerializable
{
    const TYPE_FAMILY = 'family';
    const TYPE_COMPANY = 'company';
    const TYPE_ORGANIZATION = 'organization';

    const TYPES_TITLES = [
        'Family' => self::TYPE_FAMILY,
        'Company' => self::TYPE_COMPANY,
        'Organization' => self::TYPE_ORGANIZATION
    ];

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @Groups({"group1", "group2"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Groups({"group1", "group2"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255)
     * @Groups({"group1", "group2"})
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="type", type="string", length=255)
     * @Groups({"group1", "group2"})
     */
    private $type;

    /**
     * @var boolean
     *
     * @ORM\Column(name="publicAccess", type="boolean")
     * @Groups({"group1", "group2"})
     */
    private $publicAccess;

    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="createdOrganizations")
     * @Groups({"group1", "group2"})
     */
    private $creator;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="createdAt", type="datetime")
     * @Groups({"group1", "group2"})
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updatedAt", type="datetime")
     * @Groups({"group1", "group2"})
     */
    private $updatedAt;

//ORM\ManyToMany(targetEntity="User", inversedBy="organizations")
//ORM\JoinColumn(name="member_id", referencedColumnName="id")
    /**
     * @var User[]|ArrayCollection
     *
     * @ORM\ManyToMany(targetEntity="User", inversedBy="organizations")
     * @Groups({"group1", "group2"})
     */
    private $members;
//, cascade={"remove","persist"}
    /**
     * @var Account[]|ArrayCollection
     *
     * @ORM\OneToMany(targetEntity="Account", mappedBy="organization")
     * @Groups({"group1"})
     */
    private $accounts;

    /**
     * @var bool
     *
     * @ORM\Column(name="enabled", type="boolean")
     * @Groups({"group1", "group2"})
     */
    private $enabled;

    public function __construct()
    {
        $this->members = new ArrayCollection();
        $this->accounts = new ArrayCollection();
    }

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Organization
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set description
     *
     * @param string $description
     *
     * @return Organization
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
     * Set type
     *
     * @param string $type
     *
     * @return Organization
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * @return boolean
     */
    public function getPublicAccess()
    {
        return $this->publicAccess;
    }

    /**
     * @param boolean $publicAccess
     */
    public function setPublicAccess($publicAccess)
    {
        if ($publicAccess == true && strcmp($this->type, self::TYPE_ORGANIZATION) !== 0) {
            throw new Exception('Only organizations can have public access');
        } else {
            $this->publicAccess = $publicAccess;
        }
    }

    /**
     * Set user
     *
     * @param User $creator
     * @return Organization
     */
    public function setCreator(User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }

    /**
     * Get creator
     *
     * @return User
     */
    public function getCreator()
    {
        return $this->creator;
    }

    /**
     * Add member
     *
     * @param User $member
     *
     * @return Organization
     */
    public function addMember(User $member)
    {
        $this->members->add($member);

        return $this;
    }

    /**
     * Remove member
     *
     * @param User $member
     *
     * @return Organization
     */
    public function removeMember(User $member)
    {
        $this->members->removeElement($member);

        return $this;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Organization
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     *
     * @return Organization
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }

    /**
     * Get members
     *
     * @return ArrayCollection
     */
    public function getMembers()
    {
        return $this->members;
    }

//    /**
//     * @param User[] $members
//     */
//    public function setMembers($members)
//    {
//        $this->members = $members;
//    }

    /**
     * Add account
     *
     * @param Account $account
     *
     * @return Organization
     */
    public function addAccount(Account $account)
    {
        $this->accounts->add($account);

        return $this;
    }

    /**
     * Remove account
     *
     * @param Account $account
     */
    public function removeAccount(Account $account)
    {
        $this->accounts->removeElement($account);
    }

    /**
     * Get accounts
     *
     * @return Account[]|ArrayCollection
     */
    public function getAccounts()
    {
        return $this->accounts;
    }

//    /**
//     * @param Account[] $accounts
//     */
//    public function setAccounts($accounts)
//    {
//        $this->accounts = $accounts;
//    }

    /**
     * Get enabled
     *
     * @return bool
     */
    public function getEnabled()
    {
        return $this->enabled;
    }

    /**
     * Set enabled
     *
     * @param boolean $enabled
     *
     * @return Organization
     */
    public function setEnabled($enabled)
    {
        $this->enabled = $enabled;

        return $this;
    }

    function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'description' => $this->getDescription(),
            'type' => $this->getType(),
            'publicAccess' => $this->getPublicAccess(),
            'creator' => $this->getCreator(),
            'members' => $this->getMembers(),
//            'members' => array(
//                function (User $member) {
//                    return $member->getId();
//                },
//                $this->getMembers()
//            ),
            'accounts' => $this->getAccounts(),
            'enabled' => $this->getEnabled(),
            'createdAt' => $this->getCreatedAt(),
            'updatedAt' => $this->getUpdatedAt()
        ];
    }

    function __toString()
    {
        return $this->getName();
    }
}

