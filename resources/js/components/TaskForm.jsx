import React, { useState, useEffect } from 'react';
import '../styles/taskform.scss';

const TaskForm = ({ task, onSuccess }) => {
  const isEdit = !!task;

  const [title, setTitle] = useState('');
  const [description, setDescription] = useState('');
  const [startTime, setStartTime] = useState('');
  //const [status, setStatus] = useState('pending');
  const [status, setStatus] = useState(task?.status || 'Pending');

  useEffect(() => {
    if (isEdit) {
      setTitle(task.title || '');
      setDescription(task.description || '');
      setStartTime(task.start_time ? task.start_time.slice(0, 16) : '');
      setStatus(task.status || 'Pending'); 
      console.log('Editing status:', task?.status);

    }
  }, [task]);

  const handleSubmit = async (e) => {
    e.preventDefault();

    const payload = {
      title,
      description,
      start_time: startTime,
      status,
    };

    const url = isEdit ? `/api/tasks/${task.id}` : '/api/tasks';
    const method = isEdit ? 'PUT' : 'POST';

    try {
      const response = await fetch(url, {
        method,
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
        },
        body: JSON.stringify(payload),
      });

      if (!response.ok) throw new Error('Request failed');

      onSuccess();
    } catch (err) {
      console.error('Error submitting task:', err);
    }
  };

  const handleDelete = async () => {
    if (!isEdit) return;

    const confirmDelete = confirm('Delete this task?');
    if (!confirmDelete) return;

    try {
      const response = await fetch(`/api/tasks/${task.id}`, {
        method: 'DELETE',
        headers: { Accept: 'application/json' },
      });

      if (!response.ok) throw new Error('Delete failed');

      onSuccess();
    } catch (err) {
      console.error('Error deleting task:', err);
    }
  };

  return (
    <form className="task-form" onSubmit={handleSubmit}>
      <h2>{isEdit ? 'Edit Task' : 'Create Task'}</h2>

      <label>Title</label>
      <input
        type="text"
        value={title}
        onChange={(e) => setTitle(e.target.value)}
        required
      />

      <label>Description</label>
      <textarea
        value={description}
        onChange={(e) => setDescription(e.target.value)}
        rows="4"
      />

      <label>Start Time</label>
      <input
        type="datetime-local"
        value={startTime}
        onChange={(e) => setStartTime(e.target.value)}
      />

      <label>Status</label>
      <select value={status} onChange={(e) => setStatus(e.target.value)}>
        <option value="Pending">Pending</option>
        <option value="In Progress">In Progress</option>
        <option value="Needs Revision">Needs Revision</option>
        <option value="Completed">Completed</option>
      </select>

      <div className="form-buttons">
        <button type="submit">{isEdit ? 'Save Changes' : 'Create Task'}</button>
        {isEdit && (
          <button type="button" className="delete-btn" onClick={handleDelete}>
            Delete
          </button>
        )}
      </div>
    </form>
  );
};

export default TaskForm;
