<?php

/*
 * This file is part of EC-CUBE
 *
 * Copyright(c) EC-CUBE CO.,LTD. All Rights Reserved.
 *
 * http://www.ec-cube.co.jp/
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Plugin\AgeLimit\Form\Extension;

use Eccube\Entity\Product;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Eccube\Form\Type\Admin\ProductType;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormEvent;

class AgeLimitProductExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $age_limit = 1;

        $Product = $builder->getData();
        if ($Product->getId()) {
            $age_limit = $Product->getAgeLimit();
        }

        $builder
            ->add('age_limit', IntegerType::class, [
                'mapped' => true,
                'attr' => [
                    'min' => 1,
                    'value' => $age_limit,
                ],
                'eccube_form_options' => [
                    'auto_render' => true,
                    'form_theme' => '@AgeLimit/admin/age_limit_product_edit.twig',
                ],
            ]);

        $builder->addEventListener(FormEvents::POST_SUBMIT, function (FormEvent $event) {
            /** @var Product $Product */
            $Product = $event->getData();
            if ($Product->getAgeLimit() == null) {
                $Product->setAgeLimit(1);
            }
        });
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getExtendedType()
    {
        return ProductType::class;
    }
}