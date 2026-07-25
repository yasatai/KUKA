import { useEffect, useRef, useState } from 'react';
import type { PublicPagePayload } from '../types';

export default function MobileNavigation({ payload }: { payload: PublicPagePayload }) {
    const { site, languageOptions } = payload;
    const activePageKey = payload.pageKey === 'news_show' ? 'news' : payload.pageKey;
    const [open, setOpen] = useState(false);
    const toggleRef = useRef<HTMLButtonElement>(null);
    const panelRef = useRef<HTMLDivElement>(null);

    useEffect(() => {
        if (!open) return;
        const previousOverflow = document.body.style.overflow;
        document.body.classList.add('is-nav-open');
        panelRef.current?.querySelector<HTMLElement>('button, a')?.focus();

        const handleKeyDown = (event: KeyboardEvent) => {
            if (event.key === 'Escape') { event.preventDefault(); setOpen(false); return; }
            if (event.key !== 'Tab' || !panelRef.current) return;
            const focusable = Array.from(panelRef.current.querySelectorAll<HTMLElement>('button:not([disabled]), a[href]'));
            const first = focusable[0];
            const last = focusable.at(-1);
            if (event.shiftKey && document.activeElement === first) { event.preventDefault(); last?.focus(); }
            else if (!event.shiftKey && document.activeElement === last) { event.preventDefault(); first?.focus(); }
        };
        document.addEventListener('keydown', handleKeyDown);
        return () => {
            document.removeEventListener('keydown', handleKeyDown);
            document.body.classList.remove('is-nav-open');
            document.body.style.overflow = previousOverflow;
            toggleRef.current?.focus();
        };
    }, [open]);

    return (
        <>
            <button ref={toggleRef} className="mobile-nav-toggle" type="button" aria-expanded={open} aria-controls="mobile-nav-panel" aria-label={site.ui.mobile.open} onClick={() => setOpen(true)}><span aria-hidden="true">☰</span></button>
            {open ? (
                <div ref={panelRef} id="mobile-nav-panel" className="mobile-nav-panel" role="dialog" aria-modal="true" aria-label={site.ui.mobile.dialog}>
                    <div className="mobile-nav-panel__head"><span className="site-brand"><span className="site-brand__name">{site.brand.name}</span></span><button className="mobile-nav-close" type="button" aria-label={site.ui.mobile.close} onClick={() => setOpen(false)}>×</button></div>
                    <nav aria-label={site.ui.mobile.navigation}>{site.navigation.map((item) => <a key={item.href} href={item.href} aria-current={item.page_key === activePageKey ? 'page' : undefined} onClick={() => setOpen(false)}>{item.header_label ?? item.label}</a>)}</nav>
                    <div>
                        <p className="mobile-nav-panel__language-title">{site.ui.language_navigation}</p>
                        <nav className="mobile-language-nav" aria-label={site.ui.language_navigation}>
                            {languageOptions.map((option) => option.available && option.href ? (
                                <a key={option.locale} href={option.href} hrefLang={option.locale === 'zh' ? 'zh-CN' : option.locale} lang={option.locale === 'zh' ? 'zh-CN' : option.locale} aria-current={option.is_current ? 'page' : undefined}>
                                    <strong>{option.label}</strong>{option.is_review ? <small>{option.review_label}</small> : null}
                                </a>
                            ) : (
                                <span key={option.locale} aria-disabled="true"><strong>{option.label}</strong><small>{site.ui.translation_unavailable}</small></span>
                            ))}
                        </nav>
                        <p className="mobile-nav-panel__notice">{site.meta.notice}</p>
                    </div>
                </div>
            ) : null}
        </>
    );
}
