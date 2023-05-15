<?php

namespace App\Entity;

use App\Repository\UserOperatorRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: UserOperatorRepository::class)]
class UserOperator
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $user_id = null;

    #[ORM\Column]
    private ?int $operator_id = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getOperatorId(): ?int
    {
        return $this->operator_id;
    }

    public function setOperatorId(int $operator_id): self
    {
        $this->operator_id = $operator_id;

        return $this;
    }
}
