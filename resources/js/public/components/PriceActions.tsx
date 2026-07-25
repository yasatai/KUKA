import { useState } from 'react';
import type { PricesFixture } from '../types';

export default function PriceActions({ prices }: { prices: PricesFixture }) {
    const [notice, setNotice] = useState('');

    return (
        <div className="prices-actions-island">
            <div className="prices-document-actions">
                <button type="button" className="prices-document-button" onClick={() => window.print()}><span aria-hidden="true">▣</span>{prices.copy.actions.print}</button>
                <button type="button" className="prices-document-button" title={prices.copy.actions.pdf_title} onClick={() => setNotice(prices.copy.actions.pdf_notice)}><span aria-hidden="true">PDF</span>{prices.copy.actions.pdf}</button>
            </div>
            <p className="prices-action-status" role="status" aria-live="polite">{notice}</p>
        </div>
    );
}
