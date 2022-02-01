<?php

namespace App\Menu;

use Sylius\Bundle\UiBundle\Menu\Event\MenuBuilderEvent;

class AdminMenuListener
{
    public function addAdminMenuItems(MenuBuilderEvent $event): void
    {
        $menu = $event->getMenu();

        $submenu = $menu->addChild('new', [
            'route' => 'sylius_admin_newsletter_index',
        ])
            ->setLabel('sylius.menu.admin.main.configuration.newsletters')
            ->setLabelAttribute('icon', 'star');

        $submenu->addChild('Newsletter Types', [
            'route' => 'sylius_admin_newsletter_index',
        ])
            ->setLabel('sylius.menu.admin.main.configuration.newsletter_types')
            ->setLabelAttribute('icon', 'star');

        $submenu->addChild('Customer Newsletter', [
            'route' => 'sylius_admin_customer_newsletter_index',
        ])
            ->setLabel('sylius.menu.admin.main.configuration.customer_newsletter')
            ->setLabelAttribute('icon', 'star');
    }
}
