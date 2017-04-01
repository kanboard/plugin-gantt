<?php if ($this->user->hasAccess('ProjectGanttController', 'show')): ?>
    <li><?= $this->url->icon('sliders', t('Projects Gantt chart'), 'ProjectGanttController', 'show', array('plugin' => 'Gantt')) ?></li>
<?php endif ?>