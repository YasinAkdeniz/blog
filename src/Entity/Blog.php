<?php

namespace App\Entity;

use App\Repository\BlogRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity(repositoryClass=BlogRepository::class)
 * @ORM\HasLifecycleCallbacks()
 */
class Blog
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $image;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $body;

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updateAt;

    /**
     * @ORM\ManyToOne(targetEntity=User::class)
     * @ORM\JoinColumn(nullable=false, onDelete="CASCADE")
     */
    private $user;

    /**
     * @ORM\ManyToMany(targetEntity=BlogCategory::class, mappedBy="blogs", cascade={"persist"})
     */
    private $blogCategories;

    /**
     * @ORM\ManyToMany(targetEntity=BlogTag::class, mappedBy="blogs")
     */
    private $blogTags;

    public function __construct()
    {
        $this->blogCategories = new ArrayCollection();
        $this->blogTags = new ArrayCollection();
    }
    

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getBody(): ?string
    {
        return $this->body;
    }

    public function setBody(string $body): self
    {
        $this->body = $body;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->updateAt;
    }

    public function setUpdateAt(\DateTimeInterface $updateAt): self
    {
        $this->updateAt = $updateAt;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     */
    public function prePersist()
    {
        $this->setCreatedAt(new \DateTime());
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * @ORM\PreUpdate()
     */
    public function preUpdate()
    {
        $this->setUpdateAt(new \DateTime());
    }

    /**
     * @param ArrayCollection $blogCategories
     */
    public function setBlogCategories(ArrayCollection $blogCategories): void
    {
        $this->blogCategories = $blogCategories;
    }
    /**
     * @return Collection|BlogCategory[]
     */
    public function getBlogCategories(): Collection
    {
        return $this->blogCategories;
    }

    public function addBlogCategory(BlogCategory $blogCategory): self
    {
        if (!$this->blogCategories->contains($blogCategory)) {
            $this->blogCategories[] = $blogCategory;
            $blogCategory->addBlog($this);
        }

        return $this;
    }

    public function removeBlogCategory(BlogCategory $blogCategory): self
    {
        if ($this->blogCategories->removeElement($blogCategory)) {
            $blogCategory->removeBlog($this);
        }

        return $this;
    }

    /**
     * @return Collection|BlogTag[]
     */
    public function getBlogTags(): Collection
    {
        return $this->blogTags;
    }

    public function addBlogTag(BlogTag $blogTag): self
    {
        if (!$this->blogTags->contains($blogTag)) {
            $this->blogTags[] = $blogTag;
            $blogTag->addBlog($this);
        }

        return $this;
    }

    public function removeBlogTag(BlogTag $blogTag): self
    {
        if ($this->blogTags->removeElement($blogTag)) {
            $blogTag->removeBlog($this);
        }

        return $this;
    }
}
