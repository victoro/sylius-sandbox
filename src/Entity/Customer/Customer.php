<?php

declare(strict_types=1);

namespace App\Entity\Customer;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Sylius\Component\Core\Model\Customer as BaseCustomer;
use App\Entity\Newsletter as Newsletter;

/**
 * @ORM\Entity
 * @ORM\Table(name="sylius_customer")
 */
class Customer extends BaseCustomer
{
    /**
     * @var Collection|Newsletter[]
     *
     * @ORM\ManyToMany(targetEntity="App\Entity\Newsletter", cascade={"all"}, inversedBy="customers")
     * @ORM\JoinTable(name="sylius_customer_newsletter",
     *     joinColumns={
     *          @ORM\JoinColumn(name="customer_id", referencedColumnName="id")
     *     },
     *     inverseJoinColumns={
     *          @ORM\JoinColumn(name="newsletter_id", referencedColumnName="id")
     *      }
     *)
     *
     */
    private $newsletters;

    public function __construct()
    {
        parent::__construct();
        $this->newsletters = new ArrayCollection();
    }

    /**
     * @return Collection|Newsletter[]
     */
    public function getNewsletters(): Collection
    {
        return $this->newsletters;
    }

    /**
     * @param  Collection|Newsletter[]  $newsletters
     * @return Customer
     */
    public function setNewsletters(Collection $newsletters): Customer
    {
        $this->newsletters = $newsletters;

        return $this;
    }


}
