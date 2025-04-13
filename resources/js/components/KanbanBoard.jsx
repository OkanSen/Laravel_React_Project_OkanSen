import React from 'react';
import KanbanColumn from './KanbanColumn';
import '../styles/kanban.scss';

const KanbanBoard = ({ tasks = [], onEdit }) => {
  const statuses = [...new Set(tasks.map(task => task.status))];

  return (
    <div className="kanban-board">
      {statuses.map(status => (
        <KanbanColumn
          key={status}
          status={status}
          tasks={tasks.filter(task => task.status === status)}
          onEdit={onEdit}
        />
      ))}
    </div>
  );
};

export default KanbanBoard;
