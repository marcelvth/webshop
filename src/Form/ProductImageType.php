<?php

namespace App\Form;

use App\Entity\ProductImage;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Vich\UploaderBundle\Form\Type\VichImageType;

class ProductImageType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('imageName')
            ->add('imageFile', VichImageType::class, [
                'required' => false,
                'label_format' => "Image",
                'label' => "Image",
                'download_link' => true,
                'allow_delete' => true,
                'asset_helper' => true,
                'empty_data' => $builder->getForm()->getData('ProductImage')->getImageName(),
                //  'download_uri' => '...',
                'download_label' => 'download_file',
                'attr' => [
                    'height' => 150,
                ],
            ])
            ->add('productId')
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => ProductImage::class,
        ]);
    }
}
