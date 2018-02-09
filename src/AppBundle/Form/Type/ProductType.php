<?php

namespace AppBundle\Form\Type;

use AppBundle\Entity\Product;
use AppBundle\Location\LocationContextInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProductType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        parent::buildForm($builder, $options); // TODO: Change the autogenerated stub

        /* @var $locationContext \AppBundle\Location\LocationContextInterface */
        $locationContext = $options['locationContext'];

        $builder->add('name', TextType::class)
                ->add('description', TextareaType::class)
                ->add('price', PriceType::class, [
                    'currencyCode' => $locationContext->getCurrentCurrencySymbol()
                ])
                ->add('submit', SubmitType::class, [
                    'attr' => ['class' => 'btn btn-primary float-right']
                ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function(FormEvent $event) use($locationContext) {
            /* @var $product Product */
            $product = $event->getData();
            $product->setPriceCurrency($locationContext->getCurrentCurrencySymbol());
        });
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        parent::configureOptions($resolver); // TODO: Change the autogenerated stub

        $resolver->setRequired(['locationContext']);
        $resolver->addAllowedTypes('locationContext', LocationContextInterface::class);
    }
}