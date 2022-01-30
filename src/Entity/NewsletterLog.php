<?php

namespace App\Entity;

use App\Entity\Customer\Customer;
use App\Repository\NewletterLogRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=NewletterLogRepository::class)
 * @ORM\Table(name="sylius_newsletter_log")
 */
class NewsletterLog
{
    use TimestampableEntity;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="guid")
     */
    private string $id;

    /**
     * @var Customer
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Customer\Customer")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private Customer $customer;

    /**
     * @var Newsletter
     *
     * @ORM\OneToOne(targetEntity="App\Entity\Newsletter")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private Newsletter $newsletter;

    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @return Customer
     */
    public function getCustomer(): Customer
    {
        return $this->customer;
    }

    /**
     * @param  Customer  $customer
     * @return NewsletterLog
     */
    public function setCustomer(Customer $customer): NewsletterLog
    {
        $this->customer = $customer;

        return $this;
    }

    /**
     * @return Newsletter
     */
    public function getNewsletter(): Newsletter
    {
        return $this->newsletter;
    }

    /**
     * @param  Newsletter  $newsletter
     * @return NewsletterLog
     */
    public function setNewsletter(Newsletter $newsletter): NewsletterLog
    {
        $this->newsletter = $newsletter;

        return $this;
    }



}
