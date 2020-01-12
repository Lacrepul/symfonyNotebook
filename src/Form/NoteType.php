<?php

namespace App\Form;

use App\Entity\Note;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class NoteType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('noteName', null, [
                'constraints' => [
                    new NotBlank([
                        'message' => 'Please enter a note'
                    ]),
                    new Length([
                        'max' => 255,
                        'maxMessage' => 'Your note\'s name can only be {{ limit }} characters long'
                    ])
                ],
                'label' => 'Note\'s name'
            ])
            ->add('body', TextareaType::class, [
                'attr' => [
                    'rows' => 8
                ],
                'label' => 'Note\'s body'
            ])
            ->add('submit', SubmitType::class,[//как изменить класс например?
                'label' => 'Create a note'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Note::class,
        ]);
    }
}
