<?php

namespace AppBundle\Form;

use AppBundle\Entity\Subject;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Ivory\CKEditorBundle\Form\Type\CKEditorType;

class SubjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('title')
            ->add('coverPictureFile', FileType::class, [
                'required' => false
                ])
            ->add('brief', CKEditorType::class, [ 'config_name' => 'basic' ])
           // ->add('body', CKEditorType::class, [ 'config_name' => 'my_config'])
           ->add('body', CKEditorType::class )
            ->add('price', IntegerType::class)
            ->add('viewMode', ChoiceType::class, [
                'choices' => Subject::getViewModesChoices()
            ])
        ;
    }
    
    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Subject'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_subject';
    }


}
