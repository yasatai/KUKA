import { type CSSProperties, useRef, useState } from 'react';
import type { Locale, Metal, PricesFixture } from '../types';

function format(template: string, values: Record<string, string | number>) {
    return Object.entries(values).reduce((result, [key, value]) => result.replaceAll(`{${key}}`, String(value)), template);
}

function numberLocale(locale: Locale) {
    return locale === 'zh' ? 'zh-CN' : locale;
}

function activeGrades(metal: Metal) {
    return [...metal.grades]
        .filter((grade) => grade.is_active)
        .sort((left, right) => left.sort_order - right.sort_order);
}

function chartPoints(values: number[]) {
    const width = 190;
    const height = 54;
    const minimum = Math.min(...values);
    const maximum = Math.max(...values);
    const range = Math.max(maximum - minimum, 1);
    const points = values.map((value, index) => [
        (index / Math.max(values.length - 1, 1)) * width,
        height - ((value - minimum) / range) * 38 - 8,
    ] as const);

    return {
        line: points.map(([x, y]) => `${x},${y}`).join(' '),
        area: `0,${height} ${points.map(([x, y]) => `${x},${y}`).join(' ')} ${width},${height}`,
    };
}

function PriceSparkline({ metal, active, prices }: { metal: Metal; active: boolean; prices: PricesFixture }) {
    const values = metal.trend.length > 0 ? metal.trend : [metal.representative];
    const points = chartPoints(values);
    const titleId = `prices-chart-${metal.id}-title`;
    const descriptionId = `prices-chart-${metal.id}-description`;

    return (
        <svg className="prices-card__chart" viewBox="0 0 190 54" role="img" aria-labelledby={`${titleId} ${descriptionId}`} preserveAspectRatio="none">
            <title id={titleId}>{format(prices.copy.cards.chart_title, { metal: metal.name })}</title>
            <desc id={descriptionId}>{prices.copy.cards.chart_description}</desc>
            <line className="prices-card__chart-grid" x1="0" y1="48" x2="190" y2="48" />
            <polygon className="prices-card__chart-area" points={points.area} />
            <polyline className="prices-card__chart-line" points={points.line} data-active={active ? 'true' : 'false'} />
        </svg>
    );
}

function TrendDataTables({ prices, locale }: { prices: PricesFixture; locale: Locale }) {
    return (
        <div className="sr-only">
            {prices.metals.map((metal) => {
                const values = metal.trend.length > 0 ? metal.trend : [metal.representative];
                return (
                    <table key={metal.id}>
                        <caption>{format(prices.copy.cards.trend_table, { metal: metal.name })}</caption>
                        <thead><tr><th scope="col">{prices.copy.cards.point}</th><th scope="col">{prices.copy.cards.value}</th></tr></thead>
                        <tbody>{values.map((value, index) => <tr key={`${metal.id}-${index}`}><th scope="row">{index === values.length - 1 ? prices.copy.cards.today : format(prices.copy.cards.days_ago, { count: values.length - 1 - index })}</th><td>{value.toLocaleString(numberLocale(locale))} {metal.unit}</td></tr>)}</tbody>
                    </table>
                );
            })}
        </div>
    );
}

function MetalCard({ metal, active, prices, locale, onSelect, onKeyDown, setRef }: {
    metal: Metal;
    active: boolean;
    prices: PricesFixture;
    locale: Locale;
    onSelect: () => void;
    onKeyDown: (event: React.KeyboardEvent<HTMLButtonElement>) => void;
    setRef: (node: HTMLButtonElement | null) => void;
}) {
    const grade = activeGrades(metal)[0];
    const change = `${metal.change >= 0 ? '+' : ''}${metal.change.toLocaleString(numberLocale(locale))}`;
    const style = { '--prices-accent': metal.accent } as CSSProperties;

    return (
        <button
            ref={setRef}
            type="button"
            className="prices-card"
            style={style}
            data-metal-code={metal.code}
            aria-pressed={active}
            onClick={onSelect}
            onKeyDown={onKeyDown}
        >
            <span className="prices-card__heading"><span className="prices-card__symbol" aria-hidden="true">{metal.symbol}</span><strong>{metal.name}</strong><small>{metal.englishName}</small></span>
            <span className="prices-card__grade">{prices.copy.cards.representative_grade}: {grade?.code ?? '—'}{grade?.display_name && grade.display_name !== grade.code ? ` (${grade.display_name})` : ''}</span>
            <span className="prices-card__price">{metal.representative.toLocaleString(numberLocale(locale))}<small>{metal.unit}</small></span>
            <span className={`prices-card__change${metal.change < 0 ? ' is-negative' : ''}`}>{prices.copy.cards.change} {change}</span>
            <PriceSparkline metal={metal} active={active} prices={prices} />
        </button>
    );
}

function MetalTable({ metal, prices, locale }: { metal: Metal; prices: PricesFixture; locale: Locale }) {
    const grades = activeGrades(metal);

    return (
        <section className="prices-grade-panel" aria-labelledby={`prices-grade-${metal.id}`}>
            <h2 id={`prices-grade-${metal.id}`}><span aria-hidden="true">{metal.symbol}</span>{format(prices.copy.table.heading, { metal: metal.name })}<small>({metal.unit})</small></h2>
            <div className="prices-grade-table-wrap">
                <table className="prices-grade-table">
                    <caption className="sr-only">{format(prices.copy.table.caption, { metal: metal.name })}</caption>
                    <thead><tr><th scope="col">{prices.copy.table.grade}</th><th scope="col">{prices.copy.table.reference_price}</th><th scope="col">{prices.copy.table.change}</th><th scope="col">{prices.copy.table.note}</th></tr></thead>
                    <tbody>
                        {grades.map((grade) => (
                            <tr key={grade.code}>
                                <th scope="row">{grade.code}{grade.display_name !== grade.code ? <small> ({grade.display_name})</small> : null}</th>
                                <td>{grade.price === null ? prices.copy.table.unavailable : grade.price.toLocaleString(numberLocale(locale))}</td>
                                <td className={grade.previous_change !== null && grade.previous_change < 0 ? 'is-negative' : ''}>{grade.previous_change === null ? prices.copy.table.unavailable : `${grade.previous_change >= 0 ? '+' : ''}${grade.previous_change.toLocaleString(numberLocale(locale))}`}</td>
                                <td>{grade.note || prices.copy.table.unavailable}</td>
                            </tr>
                        ))}
                    </tbody>
                </table>
            </div>
        </section>
    );
}

export default function PriceExplorer({ prices, locale }: { prices: PricesFixture; locale: Locale }) {
    const [activeId, setActiveId] = useState(prices.metals[0]?.id ?? '');
    const cardRefs = useRef<Array<HTMLButtonElement | null>>([]);

    if (prices.metals.length === 0) {
        return <p className="prices-empty" role="status">{prices.copy.cards.empty}</p>;
    }

    const selectAndFocus = (index: number) => {
        setActiveId(prices.metals[index].id);
        cardRefs.current[index]?.focus();
    };
    const move = (currentIndex: number, direction: number) => {
        selectAndFocus((currentIndex + direction + prices.metals.length) % prices.metals.length);
    };

    return (
        <div className="prices-explorer">
            <div className="prices-card-grid" role="group" aria-label={prices.copy.cards.group_label}>
                {prices.metals.map((metal, index) => (
                    <MetalCard
                        key={metal.id}
                        metal={metal}
                        active={metal.id === activeId}
                        prices={prices}
                        locale={locale}
                        setRef={(node) => { cardRefs.current[index] = node; }}
                        onSelect={() => setActiveId(metal.id)}
                        onKeyDown={(event) => {
                            if (event.key === 'ArrowRight' || event.key === 'ArrowDown') { event.preventDefault(); move(index, 1); }
                            if (event.key === 'ArrowLeft' || event.key === 'ArrowUp') { event.preventDefault(); move(index, -1); }
                            if (event.key === 'Home') { event.preventDefault(); selectAndFocus(0); }
                            if (event.key === 'End') { event.preventDefault(); selectAndFocus(prices.metals.length - 1); }
                        }}
                    />
                ))}
            </div>
            <TrendDataTables prices={prices} locale={locale} />
            <p className="prices-market-disclaimer">{prices.meta.disclaimer}</p>
            <div className="prices-grade-grid">
                {prices.metals.map((metal) => <MetalTable key={metal.id} metal={metal} prices={prices} locale={locale} />)}
            </div>
        </div>
    );
}
