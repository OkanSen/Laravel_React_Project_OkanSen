import React, { useState, useEffect } from 'react';
import TaskForm from './TaskForm';
import Modal from './Modal';
import KanbanBoard from './KanbanBoard';
import '../styles/dashboard.scss';

const TaskDashboard = () => {
  const [tasks, setTasks] = useState([]);
  const [showModal, setShowModal] = useState(false);
  const [selectedTask, setSelectedTask] = useState(null); // <-- NEW

  const fetchTasks = async () => {
    try {
      const response = await fetch('/api/tasks');
      const data = await response.json();
      setTasks(data?.data || []); // ensure it's an array
    } catch (error) {
      console.error('Error fetching tasks:', error);
      setTasks([]);
    }
  };

  useEffect(() => {
    fetchTasks();
  }, []);

  const openCreateModal = () => {
    setSelectedTask(null);     // create mode
    setShowModal(true);
  };

  const openEditModal = (task) => {
    setSelectedTask(task);     // edit mode
    setShowModal(true);
  };

  return (
    <div className="dashboard-container">
      <h1>Task Dashboard</h1>

      <KanbanBoard tasks={tasks} onEdit={openEditModal} />

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
