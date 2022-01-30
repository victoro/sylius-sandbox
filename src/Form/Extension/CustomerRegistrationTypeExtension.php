<?php

namespace App\Form\Extension;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Sylius\Bundle\CoreBundle\Form\Type\Customer\CustomerRegistrationType;

class CustomerRegistrationTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->remove('subscribedToNewsletter')
            ->add('newsletters', EntityType::class, [
                'class' => Newsletter::class,
                'choice_label' => 'type',
                'multiple' => true,
                'expanded' => true
            ])
        ;
    }

    public static function getExtendedTypes(): iterable
    {
        return [CustomerRegistrationType::class];
    }
}
