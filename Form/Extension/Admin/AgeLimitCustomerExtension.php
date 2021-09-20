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

namespace Plugin\AgeLimit\Form\Extension\Admin;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Eccube\Form\Type\Admin\CustomerType;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Validator\Constraints as Assert;

class AgeLimitCustomerExtension extends AbstractTypeExtension
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $options = $builder->get('birth')->getOptions();

        $options['required'] = true;
        $options['constraints'] = [
            new Assert\NotBlank(),
            new Assert\LessThanOrEqual([
                'value' => date('Y-m-d', strtotime('-1 day')),
                'message' => 'form_error.select_is_future_or_now_date',
            ]),
        ];
        

        $builder->add('birth', BirthdayType::class, $options);
    }

    /**
     * {@inheritdoc}
     *
     * @return string
     */
    public function getExtendedType()
    {
        return CustomerType::class;
    }
}