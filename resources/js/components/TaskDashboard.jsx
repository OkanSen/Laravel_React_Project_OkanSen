import React, { useState, useEffect } from 'react';
import TaskForm from './TaskForm';
import Modal from './Modal';
import KanbanBoard from './KanbanBoard';
import '../styles/dashboard.scss';

const TaskDashboard = () => {
  const [tasks, setTasks] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedTask, setSelectedTask] = useState(null);

  const fetchTasks = async () => {
    try {
      const response = await fetch('/api/tasks');
      const data = await response.json();
      setTasks(data?.data || []);
    } catch (error) {
      console.error('Error fetching tasks:', error);
      setTasks([]);
    }
  };

  const handleStatusChange = async (taskId, newStatus) => {
    try {
      await fetch(`/api/tasks/${taskId}`, {
        method: 'PATCH',
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify({ status: newStatus }),
      });
  
      fetchTasks(); // Refresh tasks after update
    } catch (error) {
      console.error('Error updating task status:', error);
    }
  };
  

  useEffect(() => {
    fetchTasks();
  }, []);

  // create mode
  const openCreateModal = () => {
    setSelectedTask(null);     
    setShowModal(true);
  };

  // edit mode
  const openEditModal = (task) => {
    setSelectedTask(task);     
    setShowModal(true);
  };

  return (
    <div className="dashboard-container">
      <h1>Task Dashboard</h1>

      <KanbanBoard 
        tasks={tasks} 
        onEdit={openEditModal}
        onStatusChange={handleStatusChange}
      />

      {/*<div className="task-list">
        {tasks.map((task) => (
          <div
            key={task.id}
            className="task-card"
            onClick={() => openEditModal(task)}
          >
            <strong>{task.title}</strong>
            <span className="task-status">{task.status}</span>
          </div>
        ))}
      </div>*/}

      <button className="fab" onClick={openCreateModal}>＋</button>

      <Modal isOpen={showModal} onClose={() => setShowModal(false)}>
        <TaskForm
          task={selectedTask}
          onSuccess={() => {
            setShowModal(false);
            fetchTasks();
          }}
        />
      </Modal>
    </div>
  );
};

export default TaskDashboard;
