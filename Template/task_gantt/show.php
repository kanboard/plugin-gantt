<section id="main">
    <?= $this->projectHeader->render($project, 'TaskGanttController', 'show', false, 'Gantt') ?>
    <div class="menu-inline">
        <ul>
            <li <?= $sorting === 'board' ? 'class="active"' : '' ?>>
                <?= $this->url->icon('sort-numeric-asc', t('Sort by position'), 'TaskGanttController', 'show', array('project_id' => $project['id'], 'sorting' => 'board', 'plugin' => 'Gantt')) ?>
            </li>
            <li <?= $sorting === 'date' ? 'class="active"' : '' ?>>
                <?= $this->url->icon('sort-amount-asc', t('Sort by date'), 'TaskGanttController', 'show', array('project_id' => $project['id'], 'sorting' => 'date', 'plugin' => 'Gantt')) ?>
            </li>
            <li>
                <?= $this->modal->large('plus', t('Add task'), 'TaskCreationController', 'show', array('project_id' => $project['id'])) ?>
            </li>
        </ul>
    </div>

    <?php if (! empty($tasks)): ?>
        <div
            id="gantt-chart"
            data-records='<?= json_encode($tasks, JSON_HEX_APOS) ?>'
            data-save-url="<?= $this->url->href('TaskGanttController', 'save', array('project_id' => $project['id'], 'plugin' => 'Gantt')) ?>"
            data-label-start-date="<?= t('Start date:') ?>"
            data-label-due-date="<?= t('Due date:') ?>"
            data-label-end-date="<?= t('End date:') ?>"
            data-label-assignee="<?= t('Assignee:') ?>"
            data-label-not-defined="<?= t('There is no start date or due date or end date for this task.') ?>"
        ></div>
        <p class="alert alert-info"><?= t('Moving or resizing a task will change the start and due date of the task (or its end date if its already closed).') ?></p>
    <?php else: ?>
        <p class="alert"><?= t('There is no task in your project.') ?></p>
    <?php endif ?>
</section>
