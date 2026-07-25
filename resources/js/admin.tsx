import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import '../css/admin.css';
import AdminApp from './admin/AdminApp';

const container = document.getElementById('admin-app');

if (!container) {
    throw new Error('Admin application root was not found.');
}

createRoot(container).render(
    <StrictMode>
        <AdminApp />
    </StrictMode>,
);
