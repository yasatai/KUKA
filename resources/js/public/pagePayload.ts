import type { PublicPagePayload } from './types';

export function getPublicPagePayload(): PublicPagePayload {
    const payload = window.__KUKA_PUBLIC_PAGE__;
    if (!payload) throw new Error('KUKA public page payload is unavailable.');
    return payload;
}
