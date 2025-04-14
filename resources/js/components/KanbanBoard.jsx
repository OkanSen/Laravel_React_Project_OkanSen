import React from 'react';
import KanbanColumn from './KanbanColumn';
import { DragDropContext } from 'react-beautiful-dnd';
import '../styles/kanban.scss';

const KanbanBoard = ({ tasks = [], onEdit, onStatusChange }) => {
  const statuses = [...new Set(tasks.map(task => task.status))];

  const handleDragEnd = (result) => {
    const { destination, source, draggableId } = result;

    if (!destination || destination.droppableId === source.droppableId) return;

    onStatusChange(draggableId, destination.droppableId); // Update task's status
  };

  return (
    <DragDropContext onDragEnd={handleDragEnd}>
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
    </DragDropContext>
  );
};

export default KanbanBoard;
