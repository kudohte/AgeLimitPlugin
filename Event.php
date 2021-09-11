<?php

namespace Plugin\AgeLimit;

use Eccube\Event\TemplateEvent;
use Eccube\Twig\Template;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class Event implements EventSubscriberInterface
{
    /**
     * @return array
     */
    public static function getSubscribedEvents()
    {
        return [
            '@admin/Customer/edit.twig' => 'customer_edit',
        ];
    }

    /**
     *  @param TemplateEvent $event
     */
    public function customer_edit(TemplateEvent $event)
    {
        $event->addSnippet('@AgeLimit/admin/customer_edit.twig');
    }
}