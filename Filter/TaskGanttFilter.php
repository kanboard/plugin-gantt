<?php

namespace Kanboard\Plugin\Gantt\Filter;

use Kanboard\Core\Filter\FilterInterface;
use Kanboard\Filter\BaseDateFilter;
use Kanboard\Model\TaskModel;

/**
 * Filter tasks by due and creation date
 *
 * @package filter
 * @author  Manuel Raposo
 */
class TaskGanttFilter extends BaseDateFilter implements FilterInterface
{
    /**
     * Get search attribute
     *
     * @access public
     * @return string[]
     */
    public function getAttributes()
    {
        return array();
    }

    /**
     * Apply filter
     *
     * @access public
     * @return FilterInterface
     */
    public function apply()
    {
        if ($this->value == "none") {
            $this->query->eq(TaskModel::TABLE.'.date_due', 0);
            $this->query->eq(TaskModel::TABLE.'.date_started', 0);
        }
        else {
            $this->query->notNull(TaskModel::TABLE.'.date_due');
            $this->query->neq(TaskModel::TABLE.'.date_due', 0);
            $this->query->notNull(TaskModel::TABLE.'.date_started');
            $this->query->neq(TaskModel::TABLE.'.date_started', 0);
        }

        return $this;
    }
}
