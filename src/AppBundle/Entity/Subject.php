<?php

namespace AppBundle\Entity;

use Gedmo\Mapping\Annotation as Gedmo;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
/**
 * Subject
 *
 * @ORM\Table(name="subject")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\SubjectRepository")
 * @Vich\Uploadable
 */
class Subject
{
    const STATUS_DRAFT = 1;
    const STATUS_PUBLISHED = 2;
    const STATUS_DEPRECATED = 3;

    const VIEW_MODE_FREE = 1;
    const VIEW_MODE_FEE = 2;
    const VIEW_MODE_PREREQUISITE = 4;


    public function getStatuses()
    {
        return [
            self::STATUS_DRAFT => "Draft",
            self::STATUS_PUBLISHED => "Published",
            self::STATUS_DEPRECATED => "Deprecated",
        ];
    }

    public static function getViewModes()
    {
        return [
            self::VIEW_MODE_FREE => "Free",
            self::VIEW_MODE_FEE => "Fee",
            self::VIEW_MODE_PREREQUISITE => "Prerequisite",
            self::VIEW_MODE_PREREQUISITE | self::VIEW_MODE_FEE => "Fee And Prerequisite",
        ];
    }

    public function getViewModeName()
    {
        if (!isset(self::getViewModes()[$this->viewMode])) {
            throw new \Exception(sprintf('Invalid view mode value %s', $this->viewMode));
        }

        return self::getViewModes()[$this->viewMode];
    }

    public function getStatusName()
    {
        if (!isset(self::getStatuses()[$this->status])) {
            throw new \Exception(sprintf('Invalid status value %s', $this->status));
        }

        return self::getStatuses()[$this->status];
    }


    public static function getViewModesChoices()
    {
        return array_flip(self::getViewModes());
    }

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
     * @ORM\Column(name="title", type="string", length=100)
     */
    private $title;

    /**
     * @var string
     *
     * @Gedmo\Slug(fields={"title"})
     * @ORM\Column(name="slug", type="string", length=100)
     */
    private $slug;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text")
     */
    private $body;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="create")
     * @ORM\Column(name="createdAt", type="datetimetz")
     */
    private $createdAt;

    /**
     * @var \DateTime
     *
     * @Gedmo\Timestampable(on="update")
     * @ORM\Column(name="updatedAt", type="datetimetz")
     */
    private $updatedAt;

    /**
     * @var int
     *
     * @ORM\Column(name="status", type="integer")
     */
    private $status;

    /**
     * @var float
     *
     * @ORM\Column(name="price", type="float", scale=2)
     */
    private $price;

    /**
     * @var int
     *
     * @ORM\Column(name="viewMode", type="integer")
     */
    private $viewMode;

    /**
     * @var string
     *
     * @ORM\Column(name="coverPicture", type="string", length=255, nullable=true)
     */
    private $coverPicture;

    /**
     * @var File
     *
     * @Vich\UploadableField(mapping="subject_image", fileNameProperty="coverPicture", size="50M")
     */
    private $coverPictureFile;


    /**
     * @var string
     *
     * @ORM\Column(name="brief", type="text", nullable=true)
     */
    private $brief;


    /**
     * @var User
     *
     * @ORM\ManyToOne(targetEntity="User", inversedBy="subjects")
     * @ORM\JoinColumn(name="created_by_id", referencedColumnName="id")
     *
     */
    private $createdBy;


    public function __construct()
    {
        $this->status = self::STATUS_DRAFT;
        $this->viewMode = self::VIEW_MODE_FREE;
        $this->price = 0.0;
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
     * Set title
     *
     * @param string $title
     *
     * @return Subject
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get slug
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Set slug
     *
     * @param string $slug
     */
    public function setSlug($slug)
    {
        $this->slug = $slug;
    }


    /**
     * Set body
     *
     * @param string $body
     *
     * @return Subject
     */
    public function setBody($body)
    {
        $this->body = $body;

        return $this;
    }

    /**
     * Get body
     *
     * @return string
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     *
     * @return Subject
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
     * @return Subject
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
     * Set status
     *
     * @param integer $status
     *
     * @return Subject
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * Get status
     *
     * @return int
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set price
     *
     * @param float $price
     *
     * @return Subject
     */
    public function setPrice($price)
    {
        $this->price = $price;

        return $this;
    }

    /**
     * Get price
     *
     * @return float
     */
    public function getPrice()
    {
        return $this->price;
    }

    /**
     * Set viewMode
     *
     * @param integer $viewMode
     *
     * @return Subject
     */
    public function setViewMode($viewMode)
    {
        $this->viewMode = $viewMode;

        return $this;
    }

    /**
     * Get viewMode
     *
     * @return int
     */
    public function getViewMode()
    {
        return $this->viewMode;
    }

    /**
     * Set coverPicture
     *
     * @param string $coverPicture
     *
     * @return Subject
     */
    public function setCoverPicture($coverPicture)
    {
        $this->coverPicture = $coverPicture;

        return $this;
    }

    /**
     * Get coverPicture
     *
     * @return string
     */
    public function getCoverPicture()
    {
        return $this->coverPicture;
    }

    /**
     * Set brief
     *
     * @param string $brief
     *
     * @return Subject
     */
    public function setBrief($brief)
    {
        $this->brief = $brief;

        return $this;
    }

    /**
     * Get brief
     *
     * @return string
     */
    public function getBrief()
    {
        return $this->brief;
    }

    /**
     * @return User
     */
    public function getCreatedBy()
    {
        return $this->createdBy;
    }

    /**
     * @param User $createdBy
     */
    public function setCreatedBy($createdBy)
    {
        $this->createdBy = $createdBy;
    }

    /**
     * @return File
     */
    public function getCoverPictureFile()
    {
        return $this->coverPictureFile;
    }

    /**
     * @param File $coverPictureFile
     */
    public function setCoverPictureFile($coverPictureFile)
    {
        $this->coverPictureFile = $coverPictureFile;

        if ($coverPictureFile) {
            $this->updatedAt = new \DateTimeImmutable();
        }

        return $this;
    }


}

