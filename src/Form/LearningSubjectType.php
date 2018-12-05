<?php

namespace App\Form;

use App\Entity\LearningSubject;
use App\Entity\Tag;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class LearningSubjectType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title', TextType::class)
            ->add('description', TextType::class)
            ->add('priority', ChoiceType::class, [
                'choices' => $this->reverse(),
            ])
            ->add('tag', EntityType::class, [
                'class' => Tag::class,
                'choice_label' => function (Tag $t) {
                    return $t->getName();
                }
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => LearningSubject::class,
        ]);
    }

    public function reverse ()
    {
        $t = [];

        foreach (LearningSubject::PRIORITY as $k => $v) {
            $t[$v] = $k;
        }

        return $t;
    }
}
