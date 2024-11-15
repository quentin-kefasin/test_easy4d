<?php

namespace App\Form;

use App\Entity\Brand;
use App\Entity\CategoryTyre;
use App\Entity\Family;
use App\Entity\Product;
use App\Entity\Segment;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('easyCode')
            ->add('eanCode')
            ->add('designation')
            ->add('width')
            ->add('height')
            ->add('diameter')
            ->add('construction')
            ->add('speedIndex')
            ->add('loadIndex')
            ->add('categoryTyre', EntityType::class, [
                'class' => CategoryTyre::class,
                'choice_label' => 'name',
            ])
            ->add('brand', EntityType::class, [
                'class' => Brand::class,
                'choice_label' => 'name',
            ])
            ->add('family', EntityType::class, [
                'class' => Family::class,
                'choice_label' => 'name',
            ])
            ->add('segment', EntityType::class, [
                'class' => Segment::class,
                'choice_label' => 'name',
            ])

        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Product::class,
        ]);
    }
}
