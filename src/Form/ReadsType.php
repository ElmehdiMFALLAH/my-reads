<?php

namespace App\Form;

use App\Entity\Book;
use App\Entity\Reads;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class ReadsType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('progress')
            ->add('review')
            ->add('book', EntityType::class, [
                'class' => Book::class,
                'choice_label' => 'title',
                'multiple' => false,
                // 'expanded' => true,
            ])
            ->add('save', SubmitType::class, ['label' => 'Add read'])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Reads::class,
        ]);
    }
}
