import { useMemo, useState } from 'react';
import type { Locale, NewsFixture } from '../types';

function format(template: string, values: Record<string, string | number>) {
    return Object.entries(values).reduce((result, [key, value]) => result.replaceAll(`{${key}}`, String(value)), template);
}

const days = Array.from({ length: 35 }, (_, index) => index < 3 || index > 33 ? null : index - 2);

export default function NewsExplorer({ news, locale, newsUrl }: { news: NewsFixture; locale: Locale; newsUrl: string }) {
    const copy = (key: string) => String(news.copy[key] ?? '');
    const allCategory = 'all';
    const [category, setCategory] = useState(allCategory);
    const [page, setPage] = useState(1);
    const pageSize = 10;
    const filtered = useMemo(() => category === allCategory ? news.items : news.items.filter((item) => item.category_code === category), [category, news.items]);
    const categoryLabels = useMemo(() => new Map(news.categories.map((item) => [item.code, item.label])), [news.categories]);
    const pages = Math.max(Math.ceil(filtered.length / pageSize), 1);
    const visible = filtered.slice((page - 1) * pageSize, page * pageSize);
    const localePath = locale === 'zh' ? 'zh-CN' : locale;

    return (
        <>
            <ul className="news-rebuild-category-strip" aria-label={copy('filters_label')}>
                {news.categories.map((item) => <li key={item.code}><span aria-hidden="true">{item.mark}</span><strong>{item.label}</strong></li>)}
            </ul>
            <div className="news-rebuild-layout">
                <section aria-labelledby="news-list-title">
                <h2 id="news-list-title" className="news-rebuild-list-title">{copy('list_title')}</h2>
                <div className="news-rebuild-filters" aria-label={copy('filters_label')}>
                    <button type="button" aria-pressed={category === allCategory} onClick={() => { setCategory(allCategory); setPage(1); }}>{copy('all_category')}</button>
                    {news.categories.map((item) => <button key={item.code} type="button" aria-pressed={category === item.code} onClick={() => { setCategory(item.code); setPage(1); }}>{item.label}</button>)}
                </div>
                <p className="sr-only" aria-live="polite" lang={localePath}>{category}: {filtered.length}</p>
                <div className="news-rebuild-list">
                    {visible.map((article) => <a className="news-rebuild-row" key={article.article_key} href={`${newsUrl}/${article.slug}`}><time dateTime={article.date}>{article.date.replaceAll('-', '.')}</time><span className={`news-rebuild-row__category is-${article.category_code}`}>{categoryLabels.get(article.category_code) ?? article.category}</span><span className="news-rebuild-row__title">{article.title}{article.important ? <span className="news-rebuild-row__important">{copy('important')}</span> : null}</span><span aria-hidden="true">→</span></a>)}
                    {visible.length === 0 ? <p className="notice-box">{copy('result_empty')}</p> : null}
                </div>
                <nav className="news-rebuild-pagination" aria-label={copy('pagination')}>{Array.from({ length: Math.max(pages, 2) }, (_, index) => <button key={index} className={page === index + 1 ? 'is-current' : ''} type="button" aria-label={format(copy('page_label'), { page: index + 1 })} aria-current={page === index + 1 ? 'page' : undefined} disabled={index + 1 > pages} onClick={() => setPage(index + 1)}>{index + 1}</button>)}</nav>
                </section>
                <aside className="news-rebuild-sidebar">
                  <section className="news-rebuild-calendar" aria-labelledby="calendar-title">
                    <h2 id="calendar-title">{copy('calendar_title')}</h2><span className="fixture-badge">{copy('business_pending')}</span><h3>{news.calendar.month}</h3>
                    <div className="calendar-grid" role="grid" aria-label={format(copy('calendar_aria'), { month: news.calendar.month })}>{news.calendar.weekdays.map((day) => <strong key={day} role="columnheader">{day}</strong>)}{days.map((day, index) => <span key={index} className={day === null ? 'calendar-muted' : ''} role="gridcell">{day ?? ''}</span>)}</div>
                    <p className="muted">{news.calendar.notice}</p>
                  </section>
                  <section className="news-rebuild-side-card"><h2>{copy('market_title')}</h2><p>{copy('market_text')}</p><a href={`${newsUrl.replace(/\/news$/, '')}/prices`}>{copy('market_link')} <span aria-hidden="true">→</span></a></section>
                  <nav className="news-rebuild-related" aria-label={copy('related_title')}><h2>{copy('related_title')}</h2>{news.related.map((item) => <a key={item.key} href={`${newsUrl.replace(/\/news$/, '')}/${item.key}`}>{item.label}<span aria-hidden="true">→</span></a>)}</nav>
                </aside>
            </div>
        </>
    );
}
