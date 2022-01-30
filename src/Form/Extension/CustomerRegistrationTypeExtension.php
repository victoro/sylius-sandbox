<?php

namespace App\Form\Extension;

use App\Form\NewsletterType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerRegistrationType;

class CustomerRegistrationTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('subscribedToNewsletter')
            ->add('newsletters', NewsletterType::class, [
                'required' => false,
                'label' => 'sylius.form.customer.newsletters'
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerRegistrationType::class];
    }
}
