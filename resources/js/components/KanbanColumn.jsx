import React from 'react';
import { Droppable, Draggable } from 'react-beautiful-dnd';

const KanbanColumn = ({ status, tasks, onEdit }) => {
  return (
    <div className="kanban-column-wrapper">
      <h2 className="column-title">{status.replace('_', ' ')}</h2>

      <Droppable droppableId={status}>
        {(provided) => (
          <div
            className="kanban-column"
            ref={provided.innerRef}
            {...provided.droppableProps}
          >
            {tasks.map((task, index) => (
              <Draggable key={task.id.toString()} draggableId={task.id.toString()} index={index}>
                {(provided) => (
                  <div
                    className="kanban-task"
                    ref={provided.innerRef}
                    {...provided.draggableProps}
                    {...provided.dragHandleProps}
                    onClick={() => onEdit(task)}
                  >
                    <strong>{task.title}</strong>
                    <p>{task.description}</p>
                  </div>
                )}
              </Draggable>
            ))}

            {provided.placeholder}
          </div>
        )}
      </Droppable>
    </div>
  );
};

export default KanbanColumn;
