/**
 * useReveal — scroll-triggered reveal hook.
 * Watches .reveal and .reveal-scale elements, adds .in when visible.
 */
import { useEffect } from 'react';

export function useReveal() {
  useEffect(() => {
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((e) => {
          if (e.isIntersecting) e.target.classList.add('in');
        });
      },
      { threshold: 0.12, rootMargin: '0px 0px -8% 0px' }
    );
    document
      .querySelectorAll('.reveal, .reveal-scale')
      .forEach((el) => io.observe(el));
    return () => io.disconnect();
  }, []);
}
