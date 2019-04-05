<?php namespace SaurabhDhariwal\Revisionhistory;

use Backend;
use System\Classes\PluginBase;

/**
 * revisionhistory Plugin Information File
 */
class Plugin extends PluginBase
{
    /**
     * Returns information about this plugin.
     *
     * @return array
     */
    public function pluginDetails()
    {
        return [
            'name'        => 'revisionhistory',
            'description' => 'No description provided yet...',
            'author'      => 'Saurabh Dhariwal',
            'icon'        => 'icon-leaf'
        ];
    }

    /**
     * Register method, called when the plugin is first registered.
     *
     * @return void
     */
    public function register()
    {

    }

    /**
     * Boot method, called right before the request route.
     *
     * @return array
     */
    public function boot()
    {

    }

    /**
     * Registers any front-end components implemented in this plugin.
     *
     * @return array
     */
    public function registerComponents()
    {

        return [
            'Saurabhdhariwal\Revisionhistory\Components\MyComponent' => 'myComponent',
        ];
    }
}
