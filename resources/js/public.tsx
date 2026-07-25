import { StrictMode } from 'react';
import { createRoot } from 'react-dom/client';
import '../css/public.css';
import ContactWizard from './public/components/ContactWizard';
import MobileNavigation from './public/components/MobileNavigation';
import NewsExplorer from './public/components/NewsExplorer';
import PriceActions from './public/components/PriceActions';
import PriceExplorer from './public/components/PriceExplorer';
import { initialisePublicMotion } from './public/motion';
import { getPublicPagePayload } from './public/pagePayload';

function mount(selector: string, component: React.ReactNode) {
    const container = document.querySelector<HTMLElement>(selector);
    if (!container) return;
    createRoot(container).render(<StrictMode>{component}</StrictMode>);
}

document.documentElement.dataset.kukaJs = 'enabled';
const payload = getPublicPagePayload();
mount('[data-mobile-nav-root]', <MobileNavigation payload={payload} />);
mount('[data-price-actions]', <PriceActions prices={payload.prices} />);
mount('[data-price-explorer]', <PriceExplorer prices={payload.prices} locale={payload.locale} />);
mount('[data-news-explorer]', <NewsExplorer news={payload.news} locale={payload.locale} newsUrl={payload.urls.news} />);
mount('[data-contact-wizard]', <ContactWizard contact={payload.contact} urls={payload.urls} />);

window.addEventListener('load', initialisePublicMotion, { once: true });
