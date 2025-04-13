import React from 'react';

export default function TaskList({ tasks }) {
  return (
    <div>
      <h2 style={{ marginBottom: '1rem' }}>📄 Existing Tasks</h2>
      <ul style={{ listStyle: 'none', paddingLeft: 0 }}>
        {tasks.map(task => (
          <li key={task.id} style={{ marginBottom: '0.5rem', padding: '0.5rem', border: '1px solid #444' }}>
            <strong>{task.title}</strong> — {task.status}
          </li>
        ))}
      </ul>
    </div>
  );
}
