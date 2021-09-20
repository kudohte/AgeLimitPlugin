<?php
 
namespace Plugin\AgeLimit\Form\Extension;
 
use Symfony\Component\Form\AbstractTypeExtension;
use Eccube\Form\Type\Front\EntryType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\Extension\Core\Type\BirthdayType;
use Symfony\Component\Validator\Constraints as Assert;
 
/**
 * 会員登録の生年月日を必須にする
 */
class AgeLimitEntryExtension extends AbstractTypeExtension {
 
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        if($options['skip_add_form']) {
            return;
        }
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
 
    public function getExtendedType()
    {
        return EntryType::class;
    }
 
}