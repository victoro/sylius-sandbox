<?php

namespace App\Form;

use App\Entity\Newsletter;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsletterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('type', TextType::class, [
                'required' => true,
                'label' => 'sylius.form.newsletter.type'
            ])
            ->add('subject', TextType::class, [
                'required' => true,
                'label' => 'sylius.form.newsletter.subject'
            ])
            ->add('content', TextType::class, [
                'required' => true,
                'label' => 'sylius.form.newsletter.content'
            ])
            ->add('isActive', CheckboxType::class, [
                'required' => false,
                'label' => 'sylius.form.newsletter.is_active',
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Newsletter::class,
        ]);
    }

    public function getParent(): string
    {
        return CheckboxType::class;
    }

    public function getBlockPrefix(): string
    {
        return 'sylius_newsletter';
    }
}
