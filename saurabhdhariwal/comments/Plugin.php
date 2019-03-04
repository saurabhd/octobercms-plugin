<?php 

namespace SaurabhDhariwal\Comments;

use System\Classes\PluginBase;

/**
 * Class Plugin
 * @package SaurabhDhariwal\Comments
 */
class Plugin extends PluginBase
{
    public function pluginDetails() {
        return [
            'name' => 'Comments',
            'description' => 'Provides some really cool comments features.',
            'author' => 'Saurabh Dhariwal',
            'icon' => 'icon-comments-o',
            'homepage' => 'https://github.com/saurabhd/octobercms-plugin'
        ];
    }

    /**
     * @return array
     */
    public function registerComponents()
    {
        return [
            'SaurabhDhariwal\Comments\Components\Comments' => 'commentsPost',
        ];
    }

    /**
     * @return array
     */
    public function registerSettings()
    {
        return [
            'config' => [
                'label'       => 'Comments',
                'icon'        => 'icon-comments-o',
                'description' => 'Manage Settings.',
                'class'       => 'SaurabhDhariwal\Comments\Models\Settings',
                'order'       => 60
            ]
        ];
    }
}
