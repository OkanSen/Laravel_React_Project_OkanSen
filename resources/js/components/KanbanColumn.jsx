import React from 'react';

const KanbanColumn = ({ status, tasks, onEdit }) => {
  return (
    <div className="kanban-column">
      <h2 className="column-title">{status.replace('_', ' ')}</h2>
      {tasks.map(task => (
        <div
          key={task.id}
          className="kanban-task"
          onClick={() => onEdit(task)}
        >
          <strong>{task.title}</strong>
          <p>{task.description}</p>
        </div>
      ))}
    </div>
  );
};

export default KanbanColumn;
