<?php

namespace Kanboard\Plugin\Gantt\Formatter;

use Kanboard\Formatter\BaseFormatter;
use Kanboard\Core\Filter\FormatterInterface;

/**
 * Task Gantt Formatter
 *
 * @package formatter
 * @author  Frederic Guillot
 */
class TaskGanttFormatter extends BaseFormatter implements FormatterInterface
{
    /**
     * Local cache for project columns
     *
     * @access private
     * @var array
     */
    private $columns = array();
    
    /**
     * Apply formatter
     *
     * @access public
     * @return array
     */
    public function format()
    {
        $bars = array();

        foreach ($this->query->findAll() as $task) {
            $bars[] = $this->formatTask($task);
        }

        return $bars;
    }

    /**
     * Format a single task
     *
     * @access private
     * @param  array  $task
     * @return array
     */
    private function formatTask(array $task)
    {
        if (! isset($this->columns[$task['project_id']])) {
            $this->columns[$task['project_id']] = $this->columnModel->getList($task['project_id']);
        }

        $start = $task['date_started'] ?: time();
        $end = $task['date_completed'] ?: ($task['date_due'] ?:$start);

        $task_id = array(
            'type' => 'task',
            'id' => $task['id'],
            'title' => $task['title'],
            'start' => array(
                (int) date('Y', $start),
                (int) date('n', $start),
                (int) date('j', $start),
            ),
            'due' => array(
                (int) date('Y', $task['date_due'] ?:$start),
                (int) date('n', $task['date_due'] ?:$start),
                (int) date('j', $task['date_due'] ?:$start),
            ),
            'column_title' => $task['column_name'],
            'assignee' => $task['assignee_name'] ?: $task['assignee_username'],
            'progress' => $this->taskModel->getProgress($task, $this->columns[$task['project_id']]).'%',
            'link' => $this->helper->url->href('TaskViewController', 'show', array('project_id' => $task['project_id'], 'task_id' => $task['id'])),
            'color' => $this->colorModel->getColorProperties($task['color_id']),
            'not_defined' => (empty($task['date_due']) && empty($task['date_completed'])) || empty($task['date_started']),
        );
        if (!empty($task['date_completed'])) {
            $task_id['end'] = array(
                (int) date('Y', $task['date_completed']),
                (int) date('n', $task['date_completed']),
                (int) date('j', $task['date_completed'])
            );
        }
        return $task_id;
    }
}
