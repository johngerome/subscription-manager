<?php namespace JohnGerome\Sm ;

use System\Classes\PluginBase;
use BackendMenu;
use Backend;

class Plugin extends PluginBase {


    public function pluginDetails() {
      return [
          'name'        => 'johngerome.sm::lang.plugin.name',
          'description' => 'johngerome.sm::lang.plugin.name',
          'author'      => 'John Gerome Baldonado',
          'icon'        => 'icon-rss-square'
      ];
    }

    public function registerComponents() {
      return [
        '\JohnGerome\Sm\Components\Subscriber' => 'formSubscriber'
      ];
    }

    public function registerNavigation() {
        return [
          'sm' => [
            'label'        => 'johngerome.sm::lang.plugin.name',
            'icon'         => 'icon-rss-square',
            'url'          => Backend::url('johngerome/sm/projects'),
            'permission'   => ['johngerome.sm.*'],
            'order' => 500,
            'sideMenu' => [
                'projects' => [
                    'label'       => 'johngerome.sm::lang.projects.menu_label',
                    'icon'        => 'icon-folder',
                    'url'         => Backend::url('johngerome/sm/projects'),
                    'permissions' => ['johngerome.sm.projects'],
                    'description' => 'johngerome.sm::lang.projects.menu_description'
                ],
                'contacts' => [
                    'label'       => 'johngerome.sm::lang.contacts.menu_label',
                    'icon'        => 'icon-users',
                    'url'         => Backend::url('johngerome/sm/contacts'),
                    'permissions' => ['johngerome.sm.contacts'],
                    'description' => 'johngerome.sm::lang.contacts.menu_description'
                ],
              ]
            ],

          ];
    }

    public function registerPermissions() {
        return [
          'johngerome.sm.projects'  => ['label' => 'johngerome.sm::lang.projects.menu_description', 'tab' => 'johngerome.sm::lang.plugin.name'],
          'johngerome.sm.contacts'  => ['label' => 'johngerome.sm::lang.contacts.menu_description', 'tab' => 'johngerome.sm::lang.plugin.name'],
        ];
    }
}
