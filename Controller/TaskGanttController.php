<?php

namespace Kanboard\Plugin\Gantt\Controller;

use Kanboard\Controller\BaseController;
use Kanboard\Filter\TaskProjectFilter;
use Kanboard\Model\TaskModel;

/**
 * Tasks Gantt Controller
 *
 * @package  Kanboard\Controller
 * @author   Frederic Guillot
 * @property \Kanboard\Plugin\Gantt\Formatter\TaskGanttFormatter $taskGanttFormatter
 */
class TaskGanttController extends BaseController
{
    /**
     * Show Gantt chart for one project
     */
    public function show()
    {
        $project = $this->getProject();
        $search = $this->helper->projectHeader->getSearchQuery($project);
        $sorting = $this->request->getStringParam('sorting', 'board');
        $filter = $this->taskLexer->build($search)->withFilter(new TaskProjectFilter($project['id']));

        if ($sorting === 'date') {
            $filter->getQuery()->asc(TaskModel::TABLE.'.date_started')->asc(TaskModel::TABLE.'.date_creation');
        } else {
            $filter->getQuery()->asc('column_position')->asc(TaskModel::TABLE.'.position');
        }

        $this->response->html($this->helper->layout->app('Gantt:task_gantt/show', array(
            'project' => $project,
            'title' => $project['name'],
            'description' => $this->helper->projectHeader->getDescription($project),
            'sorting' => $sorting,
            'tasks' => $filter->format($this->taskGanttFormatter),
        )));
    }

    /**
     * Save new task start date and due date or end date (if the task is already closed)
     */
    public function save()
    {
        $this->getProject();
        $values = $this->request->getJson();
        $data = array(
            'id' => $values['id'],
            'date_started' => strtotime($values['start']),
            'date_due' => strtotime($values['due']),
        );
        if (isset($values['end']) && !empty($values['end'])) {
            unset($data['date_due']);
            $data['date_completed'] = strtotime($values['end']);
        }
        $result = $this->taskModificationModel->update($data);

        if (! $result) {
            $this->response->json(array('message' => 'Unable to save task'), 400);
        } else {
            $this->response->json(array('message' => 'OK'), 201);
        }
    }
}
