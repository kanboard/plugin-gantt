<?php

namespace Kanboard\Plugin\Gantt;

use Kanboard\Core\Plugin\Base;
use Kanboard\Core\Security\Role;
use Kanboard\Core\Translator;
use Kanboard\Plugin\Gantt\Formatter\ProjectGanttFormatter;
use Kanboard\Plugin\Gantt\Formatter\TaskGanttFormatter;

class Plugin extends Base
{
    public function initialize()
    {
        $this->route->addRoute('gantt/:project_id', 'TaskGanttController', 'show', 'plugin');
        $this->route->addRoute('gantt/:project_id/sort/:sorting', 'TaskGanttController', 'show', 'plugin');
        
        $this->projectAccessMap->add('ProjectGanttController', 'save', Role::PROJECT_MANAGER);
        $this->projectAccessMap->add('TaskGanttController', 'save', Role::PROJECT_MEMBER);

        $this->template->hook->attach('template:project-header:view-switcher', 'Gantt:project_header/views');
        $this->template->hook->attach('template:project:dropdown', 'Gantt:project/dropdown');
        $this->template->hook->attach('template:project-list:menu:after', 'Gantt:project_list/menu');
        $this->template->hook->attach('template:config:sidebar', 'Gantt:config/sidebar');

        $this->hook->on('template:layout:js', array('template' => 'plugins/Gantt/Assets/chart.js'));
        $this->hook->on('template:layout:js', array('template' => 'plugins/Gantt/Assets/gantt.js'));
        $this->hook->on('template:layout:css', array('template' => 'plugins/Gantt/Assets/gantt.css'));

        $this->container['projectGanttFormatter'] = $this->container->factory(function ($c) {
            return new ProjectGanttFormatter($c);
        });

        $this->container['taskGanttFormatter'] = $this->container->factory(function ($c) {
            return new TaskGanttFormatter($c);
        });
    }

    public function onStartup()
    {
        Translator::load($this->languageModel->getCurrentLanguage(), __DIR__.'/Locale');
    }

    public function getPluginName()
    {
        return 'Gantt';
    }

    public function getPluginDescription()
    {
        return t('Gantt charts for Kanboard');
    }

    public function getPluginAuthor()
    {
        return 'Frédéric Guillot';
    }

    public function getPluginVersion()
    {
        return '1.0.6';
    }

    public function getPluginHomepage()
    {
        return 'https://github.com/kanboard/plugin-gantt';
    }

    public function getCompatibleVersion()
    {
        return '>1.2.3';
    }
}
