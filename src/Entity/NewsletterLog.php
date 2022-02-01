<?php

namespace App\Entity;

use App\Entity\Customer\Customer;
use App\Repository\NewsletterLogRepository;
use Doctrine\ORM\Mapping as ORM;
use Gedmo\Timestampable\Traits\TimestampableEntity;

/**
 * @ORM\Entity(repositoryClass=NewsletterLogRepository::class)
 * @ORM\Table(name="sylius_newsletter_log")
 */
class NewsletterLog
{
    use TimestampableEntity;

    const STATUS_INITIALIZED = 0;
    const STATUS_SENT = 1;
    const STATUS_OPENED = 2;
    const STATUS_UNSUBSCRIBED = 3;

    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="UUID")
     * @ORM\Column(type="guid", unique=true)
     *
     */
    private string $id;

    /**
     * @var Customer
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Customer\Customer")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private Customer $customer;

    /**
     * @var Newsletter
     *
     * @ORM\ManyToOne(targetEntity="App\Entity\Newsletter")
     * @ORM\JoinColumn(referencedColumnName="id")
     */
    private Newsletter $newsletter;

    /**
     * @var integer
     *
     * @ORM\Column(name="newsletter_status", type="smallint", options={"default": 0})
     */
    private int $newsletterStatus = 0;

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

    /**
     * @return integer
     */
    public function getNewsletterStatus(): int
    {
        return $this->newsletterStatus;
    }

    /**
     * @param  int  $newsletterStatus
     * @return NewsletterLog
     */
    public function setNewsletterStatus(int $newsletterStatus): NewsletterLog
    {
        $this->newsletterStatus = $newsletterStatus;

        return $this;
    }
}
