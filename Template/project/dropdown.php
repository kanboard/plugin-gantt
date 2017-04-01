<?php if ($this->user->hasProjectAccess('TaskGanttController', 'show', $project['id'])): ?>
    <li>
        <?= $this->url->icon('sliders', t('Gantt'), 'TaskGanttController', 'show', array('project_id' => $project['id'], 'plugin' => 'Gantt')) ?>
    </li>
<?php endif ?>