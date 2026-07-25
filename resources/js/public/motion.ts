import gsap from 'gsap';
import { ScrollTrigger } from 'gsap/ScrollTrigger';

export function initialisePublicMotion() {
    if (document.body.dataset.page === 'home') return () => undefined;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return () => undefined;

    gsap.registerPlugin(ScrollTrigger);
    const context = gsap.context(() => {
        const heroContent = document.querySelector<HTMLElement>('[data-hero-content]');
        if (heroContent?.children.length) {
            gsap.from(heroContent.children, { opacity: 0, y: 20, duration: 0.7, stagger: 0.09, ease: 'power2.out', clearProps: 'all' });
        }
        gsap.utils.toArray<HTMLElement>('[data-reveal]').forEach((element) => gsap.from(element, { scrollTrigger: { trigger: element, start: 'top 88%', once: true }, opacity: 0, y: 24, duration: 0.65, ease: 'power2.out', clearProps: 'all' }));
        gsap.utils.toArray<HTMLElement>('[data-reveal-group]').forEach((group) => {
            if (group.children.length) {
                gsap.from(group.children, { scrollTrigger: { trigger: group, start: 'top 88%', once: true }, opacity: 0, y: 20, duration: 0.55, stagger: 0.07, ease: 'power2.out', clearProps: 'all' });
            }
        });
        const priceCards = document.querySelectorAll<HTMLElement>('[data-price-card]');
        if (priceCards.length > 0) {
            gsap.from(priceCards, { opacity: 0, y: 16, duration: 0.55, stagger: 0.07, ease: 'power2.out', clearProps: 'all' });
        }
    });

    return () => context.revert();
}
