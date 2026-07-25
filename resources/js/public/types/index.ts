export type Locale = 'ja' | 'en' | 'zh' | 'ko';
export type NavigationItem = { page_key: string; label: string; home_label?: string; header_label?: string; href: string };
export type LanguageOption = { locale: Locale; label: string; short_label: string; review_label: string; is_review: boolean; is_current: boolean; available: boolean; href: string | null };

export type PublicTextCopy = { text: string; desktop_lines: string[] };
export type HomeAction = { key: 'contact' | 'line' | 'prices' | 'items' | 'process'; label: string; description: string };
export type HomeAssurance = { icon: 'gift' | 'chart' | 'line' | 'payment'; title: string; description: string; dynamic_description?: string | null };
export type HomeReason = { title: string; description: PublicTextCopy };
export type HomeProcessStep = { number: string; title: string; description: PublicTextCopy };
export type HomeItemCard = { item_id: string; label: string };
export type HomeFixture = {
    utility: { text: string };
    hero: {
        image: string; alt: string; eyebrow: PublicTextCopy; title: PublicTextCopy; lead: PublicTextCopy;
        assurances: HomeAssurance[]; actions: HomeAction[]; note: PublicTextCopy;
    };
    prices: { eyebrow: string; title: PublicTextCopy; lead: PublicTextCopy; link: string; card_link: string; note: PublicTextCopy };
    reasons: { eyebrow: string; title: PublicTextCopy; items: HomeReason[] };
    process: { eyebrow: string; title: PublicTextCopy; steps: HomeProcessStep[]; link: string };
    items: { eyebrow: string; title: PublicTextCopy; lead: PublicTextCopy; link: string; cards: HomeItemCard[] };
    store: { eyebrow: string; title: PublicTextCopy; lead: PublicTextCopy; link: string };
    news: { eyebrow: string; title: PublicTextCopy; link: string };
    final_cta: { eyebrow: string; title: PublicTextCopy; lead: PublicTextCopy; actions: HomeAction[] };
    footer: {
        description: PublicTextCopy;
        groups?: Array<{ page_key: string; label: string; links: Array<{ label: string; enabled: boolean }> }>;
        legal_links: string[];
        contact_label?: string;
        preview_note?: string;
    };
};

export type SiteFixture = {
    locale: { label: string; short_label: string; review_label: string };
    meta: { fixture: boolean; notice: string; review_banner: string };
    brand: { name: string; tagline: string; description: string };
    navigation: NavigationItem[];
    home: HomeFixture;
    ui: {
        language_navigation: string;
        translation_unavailable: string;
        mobile: { open: string; close: string; dialog: string; navigation: string };
    };
};

export type GradePrice = {
    code: string;
    display_name: string;
    price: number | null;
    previous_change: number | null;
    note: string;
    sort_order: number;
    is_active: boolean;
};
export type Metal = {
    id: string;
    code: 'GOLD' | 'SILVER' | 'PLATINUM' | 'PALLADIUM';
    name: string;
    englishName: string;
    symbol: string;
    unit: string;
    representative: number;
    change: number;
    accent: string;
    grades: GradePrice[];
    trend: number[];
};
export type PricesRelatedItem = { key: string; route: 'items' | 'process' | 'company'; image: string; alt: string; title: string; description: string };
export type PricesFixture = {
    copy: {
        updated: string;
        hero: { image: string; alt: string; title: string; lead: string };
        breadcrumb: string;
        actions: {
            updated: string; print: string; pdf: string; pdf_title: string; pdf_notice: string;
            line: string; line_description: string; contact: string; contact_description: string;
        };
        cards: {
            group_label: string; reference_suffix: string; representative_grade: string; change: string;
            chart_title: string; chart_description: string; trend_table: string; point: string;
            value: string; today: string; days_ago: string; empty: string;
        };
        table: {
            caption: string; heading: string; grade: string; reference_price: string;
            change: string; note: string; unavailable: string;
        };
        notes: { title: string };
        related: { title: string; items: PricesRelatedItem[] };
        final_cta: { title: string; lead: string; line: string; line_description: string; contact: string; contact_description: string };
        noscript: string;
    };
    meta: { fixture: boolean; label: string; updatedAt: string; disclaimer: string };
    metals: Metal[];
    notes: string[];
};

export type NewsCategory = { code: string; label: string; mark: string };
export type NewsArticle = { article_key: string; slug: string; page_status: string; is_indexable: boolean; date: string; category_code: string; category: string; important: boolean; title: string; excerpt: string; body: string[] };
export type NewsFixture = {
    copy: Record<string, string | Record<string, string>>;
    meta: { fixture: boolean; notice: string };
    categories: NewsCategory[];
    items: NewsArticle[];
    calendar: { month: string; weekdays: string[]; closedDates: number[]; notice: string };
    related: { key: string; label: string }[];
};

export type ContactFixture = {
    copy: Record<string, string | { image: string; alt: string; eyebrow: string; title: string; lead: string }>;
    meta: { fixture: boolean; notice: string };
    methods: { key: 'line' | 'phone' | 'store'; mark: string; title: string; description: string; detail: string }[];
    precheck: string[];
    assurances: { mark: string; title: string; description: string }[];
    customerTypes: string[];
    categories: string[];
    fields: Record<string, { label: string; required: boolean }>;
    attachment: { maxFiles: number; maxSizeMb: number; accept: string[] };
    privacySummary: string;
    ui: {
        steps: { input: string; confirm: string; complete: string; aria: string };
        required: string; optional: string; no_connection: string; input_title: string; error_title: string; select: string;
        message_hint: string; attachment_hint: string; attachment_alt: string; attachment_remove: string; privacy_label: string;
        confirm_button: string; not_sent: string; confirm_title: string; category_short: string; email_short: string; phone_short: string;
        message_short: string; attachments_short: string; none: string; attachments_count: string; confirm_notice: string; edit: string;
        switching: string; complete_preview: string; preview: string; complete_title: string; complete_text: string; complete_notice: string;
        restart: string; current_screen: string;
        errors: Record<string, string>;
    };
};

export type PublicPagePayload = {
    locale: Locale;
    htmlLang: string;
    pageKey: string;
    site: SiteFixture;
    prices: PricesFixture;
    news: NewsFixture;
    contact: ContactFixture;
    languageOptions: LanguageOption[];
    urls: { contact: string; contactConfirm: string; contactComplete: string; news: string };
};

declare global {
    interface Window { __KUKA_PUBLIC_PAGE__?: PublicPagePayload }
}
