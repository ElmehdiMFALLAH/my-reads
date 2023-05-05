<?php

namespace App\Entity;

use App\Repository\BookRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BookRepository::class)]
class Book
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 100)]
    private ?string $title = null;

    #[ORM\Column]
    private ?int $pages = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Author $author = null;

    #[ORM\ManyToOne(inversedBy: 'books')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Editor $editor = null;

    #[ORM\OneToMany(mappedBy: 'book', targetEntity: Reads::class, orphanRemoval: true)]
    private Collection $book_reads;

    public function __construct()
    {
        $this->book_reads = new ArrayCollection();
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

    public function getPages(): ?int
    {
        return $this->pages;
    }

    public function setPages(int $pages): self
    {
        $this->pages = $pages;

        return $this;
    }

    public function getEditor(): ?Editor
    {
        return $this->editor;
    }

    public function setEditor(?Editor $editor): self
    {
        $this->editor = $editor;

        return $this;
    }

    public function getAuthor(): ?Author
    {
        return $this->author;
    }

    public function setAuthor(?Author $author): self
    {
        $this->author = $author;

        return $this;
    }

    /**
     * @return Collection<int, Reads>
     */
    public function getBookReads(): Collection
    {
        return $this->book_reads;
    }

    public function addBookRead(Reads $bookRead): self
    {
        if (!$this->book_reads->contains($bookRead)) {
            $this->book_reads->add($bookRead);
            $bookRead->setBook($this);
        }

        return $this;
    }

    public function removeBookRead(Reads $bookRead): self
    {
        if ($this->book_reads->removeElement($bookRead)) {
            // set the owning side to null (unless already changed)
            if ($bookRead->getBook() === $this) {
                $bookRead->setBook(null);
            }
        }

        return $this;
    }
}
