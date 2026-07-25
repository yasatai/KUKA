import axios from '../shared/http';

export type AdminSession = {
    id: number;
    name: string;
    email: string;
    roles: string[];
    permissions: string[];
};

type DataResponse<T> = {
    data: T;
};

export async function initializeCsrf(): Promise<void> {
    await axios.get('/sanctum/csrf-cookie');
}

export async function login(email: string, password: string, remember: boolean): Promise<void> {
    await initializeCsrf();
    await axios.post('/admin/login', { email, password, remember });
}

export async function logout(): Promise<void> {
    await axios.post('/admin/logout');
}

export async function fetchSession(): Promise<AdminSession> {
    const response = await axios.get<DataResponse<AdminSession>>('/api/v1/admin/session');

    return response.data.data;
}

export async function requestPasswordReset(email: string): Promise<void> {
    await initializeCsrf();
    await axios.post('/admin/forgot-password', { email });
}

export async function resetPassword(
    email: string,
    token: string,
    password: string,
    passwordConfirmation: string,
): Promise<void> {
    await initializeCsrf();
    await axios.post('/admin/reset-password', {
        email,
        token,
        password,
        password_confirmation: passwordConfirmation,
    });
}

export async function updatePassword(
    currentPassword: string,
    password: string,
    passwordConfirmation: string,
): Promise<void> {
    await axios.put('/admin/user/password', {
        current_password: currentPassword,
        password,
        password_confirmation: passwordConfirmation,
    });
}

export function errorMessage(error: unknown, fallback: string): string {
    if (!axios.isAxiosError(error)) {
        return fallback;
    }

    const data = error.response?.data as
        | { message?: string; errors?: Record<string, string[]> }
        | undefined;
    const validationMessage = data?.errors ? Object.values(data.errors)[0]?.[0] : undefined;

    return validationMessage ?? data?.message ?? fallback;
}
