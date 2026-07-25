import { FormEvent, useEffect, useState } from 'react';
import {
    AdminSession,
    errorMessage,
    fetchSession,
    login,
    logout,
    requestPasswordReset,
    resetPassword,
    updatePassword,
} from './api';

type SubmitState = {
    busy: boolean;
    error: string;
    success: string;
};

const initialSubmitState: SubmitState = { busy: false, error: '', success: '' };

function AuthFrame({ title, children }: { title: string; children: React.ReactNode }) {
    return (
        <main className="admin-auth">
            <section className="admin-auth__panel" aria-labelledby="admin-auth-title">
                <p className="admin-eyebrow">KUKA PRECIOUS METALS</p>
                <h1 id="admin-auth-title">{title}</h1>
                {children}
            </section>
        </main>
    );
}

function StatusMessage({ state }: { state: SubmitState }) {
    return (
        <>
            {state.error ? <p className="admin-message admin-message--error" role="alert">{state.error}</p> : null}
            {state.success ? <p className="admin-message admin-message--success" role="status">{state.success}</p> : null}
        </>
    );
}

function LoginPage() {
    const [state, setState] = useState(initialSubmitState);

    async function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        setState({ busy: true, error: '', success: '' });

        try {
            await login(String(form.get('email') ?? ''), String(form.get('password') ?? ''), form.get('remember') === 'on');
            window.location.assign('/admin');
        } catch (error) {
            setState({ busy: false, error: errorMessage(error, 'ログインできませんでした。'), success: '' });
        }
    }

    return (
        <AuthFrame title="管理画面ログイン">
            <form onSubmit={submit} className="admin-form">
                <label>メールアドレス<input name="email" type="email" autoComplete="username" required /></label>
                <label>パスワード<input name="password" type="password" autoComplete="current-password" required /></label>
                <label className="admin-checkbox"><input name="remember" type="checkbox" />ログイン状態を保持する</label>
                <StatusMessage state={state} />
                <button type="submit" disabled={state.busy}>{state.busy ? '確認中…' : 'ログイン'}</button>
            </form>
            <a className="admin-text-link" href="/admin/forgot-password">パスワードを忘れた場合</a>
        </AuthFrame>
    );
}

function ForgotPasswordPage() {
    const [state, setState] = useState(initialSubmitState);

    async function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        setState({ busy: true, error: '', success: '' });

        try {
            await requestPasswordReset(String(form.get('email') ?? ''));
            setState({ busy: false, error: '', success: '再設定用メールの送信を受け付けました。' });
        } catch (error) {
            setState({ busy: false, error: errorMessage(error, '再設定メールを送信できませんでした。'), success: '' });
        }
    }

    return (
        <AuthFrame title="パスワード再設定">
            <p>管理者アカウントのメールアドレスを入力してください。</p>
            <form onSubmit={submit} className="admin-form">
                <label>メールアドレス<input name="email" type="email" autoComplete="email" required /></label>
                <StatusMessage state={state} />
                <button type="submit" disabled={state.busy}>{state.busy ? '送信中…' : '再設定メールを送る'}</button>
            </form>
            <a className="admin-text-link" href="/admin/login">ログインへ戻る</a>
        </AuthFrame>
    );
}

function ResetPasswordPage() {
    const [state, setState] = useState(initialSubmitState);
    const email = new URLSearchParams(window.location.search).get('email') ?? '';
    const token = decodeURIComponent(window.location.pathname.split('/').pop() ?? '');

    async function submit(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        setState({ busy: true, error: '', success: '' });

        try {
            await resetPassword(
                String(form.get('email') ?? ''),
                token,
                String(form.get('password') ?? ''),
                String(form.get('password_confirmation') ?? ''),
            );
            window.location.assign('/admin/login');
        } catch (error) {
            setState({ busy: false, error: errorMessage(error, 'パスワードを再設定できませんでした。'), success: '' });
        }
    }

    return (
        <AuthFrame title="新しいパスワード">
            <form onSubmit={submit} className="admin-form">
                <label>メールアドレス<input name="email" type="email" defaultValue={email} autoComplete="email" required /></label>
                <label>新しいパスワード<input name="password" type="password" autoComplete="new-password" required /></label>
                <label>新しいパスワード（確認）<input name="password_confirmation" type="password" autoComplete="new-password" required /></label>
                <StatusMessage state={state} />
                <button type="submit" disabled={state.busy}>{state.busy ? '更新中…' : 'パスワードを更新'}</button>
            </form>
        </AuthFrame>
    );
}

function AdminFoundation({ session }: { session: AdminSession }) {
    const [state, setState] = useState(initialSubmitState);

    async function submitPassword(event: FormEvent<HTMLFormElement>) {
        event.preventDefault();
        const form = new FormData(event.currentTarget);
        setState({ busy: true, error: '', success: '' });

        try {
            await updatePassword(
                String(form.get('current_password') ?? ''),
                String(form.get('password') ?? ''),
                String(form.get('password_confirmation') ?? ''),
            );
            event.currentTarget.reset();
            setState({ busy: false, error: '', success: 'パスワードを変更しました。' });
        } catch (error) {
            setState({ busy: false, error: errorMessage(error, 'パスワードを変更できませんでした。'), success: '' });
        }
    }

    async function signOut() {
        await logout();
        window.location.assign('/admin/login');
    }

    return (
        <main className="admin-shell">
            <header className="admin-shell__header">
                <div><p className="admin-eyebrow">KUKA ADMIN</p><h1>管理基盤</h1></div>
                <button type="button" className="admin-button--secondary" onClick={signOut}>ログアウト</button>
            </header>
            <section className="admin-foundation" aria-labelledby="phase-title">
                <p>ログイン中: {session.name}（{session.email}）</p>
                <h2 id="phase-title">Phase 1 基盤</h2>
                <p>価格・お知らせ・問い合わせの管理機能は、後続Phaseで権限に応じて追加されます。</p>
                <dl><dt>役割</dt><dd>{session.roles.join(', ') || '未割当'}</dd><dt>権限数</dt><dd>{session.permissions.length}</dd></dl>
            </section>
            <section className="admin-foundation" aria-labelledby="password-title">
                <h2 id="password-title">パスワード変更</h2>
                <form onSubmit={submitPassword} className="admin-form admin-form--compact">
                    <label>現在のパスワード<input name="current_password" type="password" autoComplete="current-password" required /></label>
                    <label>新しいパスワード<input name="password" type="password" autoComplete="new-password" required /></label>
                    <label>新しいパスワード（確認）<input name="password_confirmation" type="password" autoComplete="new-password" required /></label>
                    <StatusMessage state={state} />
                    <button type="submit" disabled={state.busy}>{state.busy ? '更新中…' : 'パスワードを変更'}</button>
                </form>
            </section>
        </main>
    );
}

function SessionGate() {
    const [session, setSession] = useState<AdminSession | null>(null);
    const [error, setError] = useState('');

    useEffect(() => {
        let active = true;

        fetchSession()
            .then((data) => {
                if (active) setSession(data);
            })
            .catch(() => {
                if (active) {
                    setError('認証を確認できませんでした。ログイン画面へ移動します。');
                    window.location.replace('/admin/login');
                }
            });

        return () => {
            active = false;
        };
    }, []);

    if (error) return <p role="alert">{error}</p>;
    if (!session) return <p className="admin-loading" role="status">認証情報を確認しています…</p>;

    return <AdminFoundation session={session} />;
}

export default function AdminApp() {
    const path = window.location.pathname;

    if (path === '/admin/login') return <LoginPage />;
    if (path === '/admin/forgot-password') return <ForgotPasswordPage />;
    if (path.startsWith('/admin/reset-password/')) return <ResetPasswordPage />;

    return <SessionGate />;
}
