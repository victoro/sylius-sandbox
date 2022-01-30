<?php
declare(strict_types=1);

namespace App\Entity;

use App\Repository\NewsletterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\Customer\Customer;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=NewsletterRepository::class)
 * @ORM\Table(name="sylius_newsletter")
 */
class Newsletter
{

    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer", name="id")
     */
    private int $id;

    /**
     * @ORM\Column(type="string", length=127, nullable=false, unique=true)
     */
    private string $type;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    private string $subject;

    /**
     * @ORM\Column(type="text", nullable=false)
     */
    private string $content;

    /**
     * @ORM\Column(name="is_active", type="boolean", nullable=true, options={"default": true})
     */
    private bool $isActive;

    /**
     * @var ArrayCollection|Customer[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Customer\Customer", mappedBy="newsletters")
     */
    private $customers;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param  string  $type
     * @return Newsletter
     */
    public function setType(string $type): Newsletter
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return string
     */
    public function getSubject(): string
    {
        return $this->subject;
    }

    /**
     * @param  string  $subject
     * @return Newsletter
     */
    public function setSubject(string $subject): Newsletter
    {
        $this->subject = $subject;

        return $this;
    }

    /**
     * @return string
     */
    public function getContent(): string
    {
        return $this->content;
    }

    /**
     * @param  string  $content
     * @return Newsletter
     */
    public function setContent(string $content): Newsletter
    {
        $this->content = $content;

        return $this;
    }

    /**
     * @return Customer[]|Collection
     */
    public function getCustomers()
    {
        return $this->customers;
    }


}
