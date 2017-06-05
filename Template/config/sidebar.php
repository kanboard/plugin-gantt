<li <?= $this->app->checkMenuSelection('ConfigController', 'show', 'Gantt') ?>>
    <?= $this->url->link(t('Gantt settings'), 'ConfigController', 'show', array('plugin' => 'Gantt')) ?>
</li>
