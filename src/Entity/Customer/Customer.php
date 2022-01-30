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
     * @var ArrayCollection|Newsletter[]
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

    /**
     * @return ArrayCollection|Newsletter[]
     */
    public function getNewsletters(): ArrayCollection
    {
        return $this->newsletters;
    }

    /**
     * @param  ArrayCollection|Newsletter[]  $newsletters
     * @return Customer
     */
    public function setNewsletters(ArrayCollection $newsletters): Customer
    {
        $this->newsletters = $newsletters;

        return $this;
    }


}
