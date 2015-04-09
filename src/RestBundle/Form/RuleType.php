<?php
/**
 * This file is part of the transcriptor project.
 */

namespace RestBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * RuleType form
 * @package RestBundle\Form
 * @author  Petr Pokorný <petr@petrpokorny.cz>
 */
class RuleType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('sourceLanguage')
            ->add('targetLanguage')
            ->add('pattern')
            ->add('replacement')
        ;
    }
    
    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'RestBundle\Entity\Rule',
            'csrf_protection' => false
        ));
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'restbundle_rule';
    }
}
