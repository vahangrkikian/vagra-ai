/* Reusable small components: icons, nav, etc. */

const Icon = ({ name, size = 16, stroke = 1.6 }) => {
  const paths = {
    arrow: <path d="M5 12h14M13 6l6 6-6 6" />,
    download: <><path d="M12 4v12M6 11l6 6 6-6" /><path d="M4 20h16" /></>,
    spark: <><path d="M12 3v4M12 17v4M3 12h4M17 12h4M5.6 5.6l2.8 2.8M15.6 15.6l2.8 2.8M5.6 18.4l2.8-2.8M15.6 8.4l2.8-2.8" /></>,
    key: <><circle cx="8" cy="14" r="4" /><path d="M11 14h10M17 14v4M21 14v3" /></>,
    github: <path d="M12 2a10 10 0 0 0-3.2 19.5c.5.1.7-.2.7-.5v-2c-2.8.6-3.4-1.2-3.4-1.2-.4-1.2-1.1-1.5-1.1-1.5-.9-.6.1-.6.1-.6 1 .1 1.6 1 1.6 1 .9 1.6 2.4 1.1 3 .9.1-.7.4-1.1.7-1.4-2.2-.2-4.6-1.1-4.6-5 0-1.1.4-2 1-2.7-.1-.3-.5-1.3.1-2.7 0 0 .8-.3 2.8 1a9.6 9.6 0 0 1 5 0c1.9-1.3 2.8-1 2.8-1 .5 1.4.2 2.4.1 2.7.6.7 1 1.6 1 2.7 0 3.9-2.3 4.7-4.6 5 .4.3.7.9.7 1.9v2.8c0 .3.2.6.7.5A10 10 0 0 0 12 2Z" />,
    x: <path d="M4 4l16 16M20 4L4 20" />,
    linkedin: <><rect x="3" y="3" width="18" height="18" rx="3" /><path d="M8 10v7M8 7v.01M12 17v-4M12 13a3 3 0 0 1 6 0v4" /></>,
  };
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none"
         stroke="currentColor" strokeWidth={stroke} strokeLinecap="round" strokeLinejoin="round">
      {paths[name]}
    </svg>
  );
};

function Nav() {
  const [scrolled, setScrolled] = React.useState(false);
  const [menuOpen, setMenuOpen] = React.useState(false);
  React.useEffect(() => {
    const fn = () => setScrolled(window.scrollY > 8);
    fn();
    window.addEventListener("scroll", fn, { passive: true });
    return () => window.removeEventListener("scroll", fn);
  }, []);
  // Close menu on route change / resize
  React.useEffect(() => {
    const close = () => setMenuOpen(false);
    window.addEventListener("resize", close);
    return () => window.removeEventListener("resize", close);
  }, []);
  return (
    <nav className="nav" data-scrolled={scrolled}>
      <div className="container nav-row">
        <a className="brand" href="#top">
          <span className="brand-mark"></span>
          <span>vagra<span className="brand-dot">.ai</span></span>
        </a>
        <div className={"nav-links" + (menuOpen ? " nav-links--open" : "")}>
          <a href="/#themes" onClick={() => setMenuOpen(false)}>Themes</a>
          <a href="/demos/" onClick={() => setMenuOpen(false)}>Demos</a>
          <a href="/#ai" onClick={() => setMenuOpen(false)}>AI</a>
          <a href="/#pricing" onClick={() => setMenuOpen(false)}>Pricing</a>
          <a href="/#faq" onClick={() => setMenuOpen(false)}>FAQ</a>
          <a href="https://github.com" target="_blank" rel="noopener" style={{display:"inline-flex",alignItems:"center",gap:6}}>
            <Icon name="github" size={15} /> GitHub
          </a>
        </div>
        <a className="nav-cta" href="#themes">
          Browse themes <Icon name="arrow" size={14} />
        </a>
        <button
          className={"hamburger" + (menuOpen ? " hamburger--open" : "")}
          onClick={() => setMenuOpen(o => !o)}
          aria-label="Toggle menu"
          aria-expanded={menuOpen}
        >
          <span></span>
          <span></span>
          <span></span>
        </button>
      </div>
    </nav>
  );
}

/* IntersectionObserver-based reveal */
function useReveal() {
  React.useEffect(() => {
    const els = document.querySelectorAll("[data-reveal]");
    const io = new IntersectionObserver((entries) => {
      entries.forEach(e => {
        if (e.isIntersecting) {
          e.target.setAttribute("data-visible", "true");
          io.unobserve(e.target);
        }
      });
    }, { threshold: 0.12, rootMargin: "0px 0px -60px 0px" });
    els.forEach(el => io.observe(el));
    return () => io.disconnect();
  }, []);
}

Object.assign(window, { Icon, Nav, useReveal });
