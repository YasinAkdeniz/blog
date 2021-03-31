<?php

namespace App\Entity;

use App\Repository\GeneralSettingRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GeneralSettingRepository::class)
 */
class GeneralSetting
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
    private $varKey;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $varValue;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getVarKey(): ?string
    {
        return $this->varKey;
    }

    public function setVarKey(string $varKey): self
    {
        $this->varKey = $varKey;

        return $this;
    }

    public function getVarValue(): ?string
    {
        return $this->varValue;
    }

    public function setVarValue(?string $varValue): self
    {
        $this->varValue = $varValue;

        return $this;
    }
}
