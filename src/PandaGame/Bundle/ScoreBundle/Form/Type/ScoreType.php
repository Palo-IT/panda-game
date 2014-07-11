<?php

namespace PandaGame\Bundle\ScoreBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

class ScoreType extends AbstractType
{
    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->addResultField($builder, $options);

    }

    /**
     * @param FormBuilderInterface $builder
     * @param array                $options
     *
     * @return $this
     */
    private function addResultField(FormBuilderInterface $builder, array $options)
    {
        $builder->add(
            'result',
            'integer'
        );

        return $this;
    }

    /**
     * @param OptionsResolverInterface $resolver
     */
    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(
            array(
                'data_class'      => 'PandaGame\Bundle\ScoreBundle\Entity\Score',
                'csrf_protection' => false
            )
        );
    }

    /**
     * @return string
     */
    public function getName()
    {
        return '';
    }
} 