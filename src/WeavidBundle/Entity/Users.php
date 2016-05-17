<?php

namespace WeavidBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Users
 *
 * @ORM\Table(name="users", uniqueConstraints={@ORM\UniqueConstraint(name="EMAIL", columns={"email"})})
 * @ORM\Entity
 */
class Users
{
    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=120, nullable=false)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="password", type="string", length=255, nullable=true)
     */
    private $password;

    /**
     * @var string
     *
     * @ORM\Column(name="first_name", type="string", length=255, nullable=true)
     */
    private $firstName;

    /**
     * @var string
     *
     * @ORM\Column(name="last_name", type="string", length=255, nullable=true)
     */
    private $lastName;

    /**
     * @var string
     *
     * @ORM\Column(name="country", type="string", length=255, nullable=true)
     */
    private $country;

    /**
     * @var string
     *
     * @ORM\Column(name="city", type="string", length=255, nullable=false)
     */
    private $city = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="organization", type="string", length=255, nullable=true)
     */
    private $organization;

    /**
     * @var string
     *
     * @ORM\Column(name="degree", type="string", nullable=false)
     */
    private $degree = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="job_status", type="string", nullable=false)
     */
    private $jobStatus = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="job_position", type="string", nullable=false)
     */
    private $jobPosition = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="job_experience", type="string", nullable=false)
     */
    private $jobExperience = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="gender", type="string", nullable=false)
     */
    private $gender = 'NONE';

    /**
     * @var string
     *
     * @ORM\Column(name="login_type", type="string", nullable=false)
     */
    private $loginType = 'REGISTERED';

    /**
     * @var string
     *
     * @ORM\Column(name="role", type="string", nullable=false)
     */
    private $role = 'USER';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime", nullable=true)
     */
    private $createdAt = 'CURRENT_TIMESTAMP';

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated_at", type="datetime", nullable=true)
     */
    private $updatedAt = 'CURRENT_TIMESTAMP';

    /**
     * @var integer
     *
     * @ORM\Column(name="user_id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $userId;



    /**
     * Set email
     *
     * @param string $email
     *
     * @return Users
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set password
     *
     * @param string $password
     *
     * @return Users
     */
    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Get password
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set firstName
     *
     * @param string $firstName
     *
     * @return Users
     */
    public function setFirstName($firstName)
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * Get firstName
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->firstName;
    }

    /**
     * Set lastName
     *
     * @param string $lastName
     *
     * @return Users
     */
    public function setLastName($lastName)
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * Get lastName
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->lastName;
    }

    /**
     * Set country
     *
     * @param string $country
     *
     * @return Users
     */
    public function setCountry($country)
    {
        $this->country = $country;

        return $this;
    }

    /**
     * Get country
     *
     * @return string
     */
    public function getCountry()
    {
        return $this->country;
    }

    /**
     * Set city
     *
     * @param string $city
     *
     * @return Users
     */
    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    /**
     * Get city
     *
     * @return string
     */
    public function getCity()
    {
        return $this->city;
    }

    /**
     * Set organization
     *
     * @param string $organization
     *
     * @return Users
     */
    public function setOrganization($organization)
    {
        $this->organization = $organization;

        return $this;
    }

    /**
     * Get organization
     *
     * @return string
     */
    public function getOrganization()
    {
        return $this->organization;
    }

    /**
     * Set degree
     *
     * @param string $degree
     *
     * @return Users
     */
    public function setDegree($degree)
    {
        $this->degree = $degree;

        return $this;
    }

    /**
     * Get degree
     *
     * @return string
     */
    public function getDegree()
    {
        return $this->degree;
    }

    /**
     * Set jobStatus
     *
     * @param string $jobStatus
     *
     * @return Users
     */
    public function setJobStatus($jobStatus)
    {
        $this->jobStatus = $jobStatus;

        return $this;
    }

    /**
     * Get jobStatus
     *
     * @return string
     */
    public function getJobStatus()
    {
        return $this->jobStatus;
    }

    /**
     * Set jobPosition
     *
     * @param string $jobPosition
     *
     * @return Users
     */
    public function setJobPosition($jobPosition)
    {
        $this->jobPosition = $jobPosition;

        return $this;
    }

    /**
     * Get jobPosition
     *
     * @return string
     */
    public function getJobPosition()
    {
        return $this->jobPosition;
    }

    /**
     * Set jobExperience
     *
     * @param string $jobExperience
     *
     * @return Users
     */
    public function setJobExperience($jobExperience)
    {
        $this->jobExperience = $jobExperience;

        return $this;
    }

    /**
     * Get jobExperience
     *
     * @return string
     */
    public function getJobExperience()
    {
        return $this->jobExperience;
    }

    /**
     * Set gender
     *
     * @param string $gender
     *
     * @return Users
     */
    public function setGender($gender)
    {
        $this->gender = $gender;

        return $this;
    }

    /**
     * Get gender
     *
     * @return string
     */
    public function getGender()
    {
        return $this->gender;
    }

    /**
     * Set loginType
     *
     * @param string $loginType
     *
     * @return Users
     */
    public function setLoginType($loginType)
    {
        $this->loginType = $loginType;

        return $this;
    }

    /**
     * Get loginType
     *
     * @return string
     */
    public function getLoginType()
    {
        return $this->loginType;
    }

    /**
     * Set role
     *
     * @param string $role
     *
     * @return Users
     */
    public function setRole($role)
    {
        $this->role = $role;

        return $this;
    }

    /**
     * Get role
     *
     * @return string
     */
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Users
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
     * @return Users
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
     * Get userId
     *
     * @return integer
     */
    public function getUserId()
    {
        return $this->userId;
    }
}
