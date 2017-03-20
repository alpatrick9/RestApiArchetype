<?php
/**
 * Created by PhpStorm.
 * User: root
 * Date: 3/20/17
 * Time: 1:20 PM
 */

namespace Api\RestBundle\Type;


use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PlaceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('name', TextType::class)
            ->add('address', TextType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => 'Api\RestBundle\Entity\Place',
            'csrf_protection' => false
        ]);
    }

}