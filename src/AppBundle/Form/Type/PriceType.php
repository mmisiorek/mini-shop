<?php

namespace AppBundle\Form\Type;

use AppBundle\Form\DataTransformer\PriceDataTransformer;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PriceType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options);

        $builder->addModelTransformer(new PriceDataTransformer());
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        parent::buildView($view, $form, $options);
        $view->vars['postfix'] = $options['currencyCode'];
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefault('scale', 2);
        $resolver->setRequired(['currencyCode']);
    }

    public function getParent()
    {
        return NumberType::class;
    }
}