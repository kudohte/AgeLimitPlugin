<?php


namespace Plugin\AgeLimit\Service\PurchaceFlow\Validator;


use Eccube\Annotation\CartFlow;
use Eccube\Entity\Customer;
use Eccube\Entity\ItemInterface;
use Eccube\Service\PurchaseFlow\ItemValidator;
use Eccube\Service\PurchaseFlow\PurchaseContext;

/**
 * 商品毎に年齢制限チェック
 *
 * @CartFlow()
 *
 * Class AgeLimitValidator
 * @package Plugin\AgeLimit\Service\PurchaceFlow\Validator
 */
class AgeLimitValidator extends ItemValidator
{
    /**
     * @inheritDoc
     */
    protected function validate(ItemInterface $item, PurchaseContext $context)
    {
        if(!$item->isProduct()) {
            return;
        }

        $User = $context->getUser();

        if($User instanceof Customer) {
            // 誕生日が登録されている場合
            if($User->getBirth()) {
                // 年齢を計算
                $age = floor(((new \DateTime())->format("Ymd") - $User->getBirth()->format("Ymd")) / 10000);

                $ageLimit = $item->getProductClass()->getProduct()->getAgeLimit();

                // 年齢制限の値と年齢を比較
                if($ageLimit > $age) {
                    $this->throwInvalidItemException("「%product%」は{$ageLimit}歳以上じゃないと購入できません。", $item->getProductClass());
                }
            }
        }
    }

    protected function handle(ItemInterface $item, PurchaseContext $context)
    {
        $item->setQuantity(0);
    }
}