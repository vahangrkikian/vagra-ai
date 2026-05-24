/* Demos page — full live-preview-style browser */

/* Define which sub-pages each theme exposes */
const THEME_PAGES = {
  msp:          [{id:"", label:"Home"}, {id:"services", label:"Services"}, {id:"contact", label:"Contact"}, {id:"about", label:"About"}],
  legal:        [{id:"", label:"Home"}, {id:"practice-areas", label:"Practice Areas"}, {id:"contact", label:"Contact"}, {id:"about", label:"About"}],
  nslookup:     [{id:"", label:"Home"}, {id:"ns-lookup", label:"NS Lookup"}, {id:"propagation", label:"Propagation"}, {id:"faq", label:"FAQ"}],
  carvice:      [{id:"", label:"Home"}, {id:"contact", label:"Contact"}, {id:"about", label:"About"}, {id:"faq", label:"FAQ"}],
  driveease:    [{id:"", label:"Home"}, {id:"fleet", label:"Fleet"}, {id:"contact", label:"Contact"}, {id:"about", label:"About"}],
  tourvice:     [{id:"", label:"Home"}, {id:"contact", label:"Contact"}, {id:"about", label:"About"}],
  meridian:     [{id:"", label:"Home"}, {id:"gallery", label:"Gallery"}, {id:"about", label:"About"}, {id:"location", label:"Location"}],
  houseservice: [{id:"", label:"Home"}, {id:"about", label:"About"}, {id:"contact", label:"Contact"}, {id:"categories", label:"Categories"}],
};

const DEVICES = [
  { id: "desktop", label: "Desktop", width: 1280, frameW: "100%" },
  { id: "tablet",  label: "Tablet",  width: 820,  frameW: 460 },
  { id: "mobile",  label: "Mobile",  width: 390,  frameW: 280 },
];

function DemoIcon({ name, size = 16 }) {
  const paths = {
    desktop: <><rect x="3" y="4" width="18" height="13" rx="2" /><path d="M9 21h6M12 17v4" /></>,
    tablet:  <><rect x="5" y="3" width="14" height="18" rx="2" /><path d="M12 18h.01" /></>,
    mobile:  <><rect x="7" y="3" width="10" height="18" rx="2" /><path d="M12 18h.01" /></>,
    refresh: <><path d="M4 12a8 8 0 0 1 14-5.3M20 12a8 8 0 0 1-14 5.3" /><path d="M18 2v5h-5M6 22v-5h5" /></>,
    external: <><path d="M14 4h6v6M10 14L20 4M19 13v6a1 1 0 0 1-1 1H5a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h6" /></>,
  };
  return (
    <svg width={size} height={size} viewBox="0 0 24 24" fill="none"
         stroke="currentColor" strokeWidth="1.6" strokeLinecap="round" strokeLinejoin="round">
      {paths[name]}
    </svg>
  );
}

function DeviceSwitcher({ value, onChange }) {
  return (
    <div className="device-switcher">
      {DEVICES.map(d => (
        <button key={d.id}
                className="device-btn"
                data-active={value === d.id}
                onClick={() => onChange(d.id)}
                title={`${d.label} (${d.width}px)`}>
          <DemoIcon name={d.id} size={15} />
          <span>{d.label}</span>
        </button>
      ))}
    </div>
  );
}

function DemosHero() {
  return (
    <header className="demos-hero">
      <div className="hero-bg">
        <div className="hero-grid"></div>
        <div className="hero-glow"></div>
      </div>
      <div className="container">
        <span className="eyebrow" data-reveal>The demo library</span>
        <h1 data-reveal style={{"--reveal-delay":"60ms", fontSize:"clamp(36px, 4.5vw, 60px)"}}>
          Browse every theme. <span style={{color:"var(--text-muted)"}}>Live, in any size.</span>
        </h1>
        <p data-reveal style={{"--reveal-delay":"140ms", color:"var(--text-muted)", maxWidth: 620, fontSize: 17, marginTop: 14, lineHeight: 1.6}}>
          Click any theme to step inside. Toggle Desktop / Tablet / Mobile to see how it
          responds. Every screen below is the same code that ships in the WordPress.org zip.
        </p>
      </div>
    </header>
  );
}

function DemosApp() {
  useReveal();
  const [activeId, setActiveId] = React.useState(THEMES[6].id); // Meridian first
  const [pageId, setPageId] = React.useState("home");
  const [device, setDevice] = React.useState("desktop");

  const theme = THEMES.find(t => t.id === activeId);
  const pages = THEME_PAGES[activeId];
  const device_ = DEVICES.find(d => d.id === device);

  // Reset page when switching theme
  React.useEffect(() => {
    setPageId(pages[0].id);
  }, [activeId]);

  return (
    <>
      <Nav />
      <DemosHero />

      <section className="demos-stage-section" style={{paddingTop: 20}}>
        <div className="container">
          <div className="demos-layout">
            {/* LEFT: theme selector */}
            <aside className="demos-sidebar" data-reveal>
              <div className="sidebar-head">
                <span className="eyebrow">8 themes</span>
              </div>
              <ul className="theme-list">
                {THEMES.map(t => (
                  <li key={t.id}>
                    <button className="theme-list-btn"
                            data-active={t.id === activeId}
                            style={{"--theme-accent": t.accent}}
                            onClick={() => setActiveId(t.id)}>
                      <span className="tl-dot"></span>
                      <span className="tl-name">
                        {t.name}
                        <span className="tl-niche">{t.niche}</span>
                      </span>
                      <span className="tl-arrow">→</span>
                    </button>
                  </li>
                ))}
              </ul>
              <div className="sidebar-foot">
                <a href="/#pricing" className="theme-card-btn primary" style={{display:"block", textAlign:"center"}}>
                  All themes — Free
                </a>
              </div>
            </aside>

            {/* RIGHT: preview stage */}
            <div className="demos-stage" data-reveal style={{"--reveal-delay":"100ms", "--theme-accent": theme.accent}}>
              <div className="stage-bar">
                <div className="stage-bar-l">
                  <span className="theme-card-niche">{theme.niche}</span>
                  <strong className="stage-title">{theme.name}</strong>
                  <span className="stage-tagline">{theme.tagline}</span>
                </div>
                <div className="stage-bar-c">
                  <DeviceSwitcher value={device} onChange={setDevice} />
                </div>
                <div className="stage-bar-r">
                  <button className="stage-icon-btn" title="Refresh">
                    <DemoIcon name="refresh" size={15} />
                  </button>
                  <a className="stage-cta" href={`/#theme-${theme.id}`}>
                    Get this theme <Icon name="arrow" size={13} />
                  </a>
                </div>
              </div>

              <div className="stage-tabs">
                <div className="stage-tabs-inner">
                  {pages.map(p => (
                    <button key={p.id}
                            className="stage-tab"
                            data-active={pageId === p.id}
                            onClick={() => setPageId(p.id)}>
                      {p.label}
                    </button>
                  ))}
                </div>
                <div className="stage-url">
                  <span className="url-protocol">{theme.id === "houseservice" ? "houseservice" : theme.id}.vagraai.local</span>
                  <span className="url-path">/{pageId}</span>
                </div>
              </div>

              <div className={`stage-viewport device-${device}`}>
                <div className={`device-wrap dw-${device}`}>
                  {device === "mobile" && <MobileFrame />}
                  {device === "tablet"  && <TabletFrame />}
                  <div className="device-screen">
                    <iframe
                      key={`${theme.id}-${pageId}-${device}`}
                      src={`${theme.url}${pageId}?hide_admin_bar=1`}
                      title={`${theme.name} — ${pages.find(p => p.id === pageId)?.label || "Home"}`}
                      className="demo-iframe"
                      sandbox="allow-scripts allow-same-origin"
                      loading="lazy"
                    />
                  </div>
                </div>
              </div>

              <div className="stage-foot">
                <span>
                  <span className="live-dot"></span> Live preview · served from {theme.id}.vagraai.local
                </span>
                <span style={{fontFamily:"var(--ff-mono)", fontSize: 11.5, color:"var(--text-dim)"}}>
                  Viewport {device_.width}px · {device_.label}
                </span>
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* Bottom: quick gallery / try another */}
      <section style={{paddingTop: 40}}>
        <div className="container">
          <div className="section-head centered">
            <span className="eyebrow" data-reveal>More demos</span>
            <h2 data-reveal style={{"--reveal-delay":"60ms"}}>Jump to another niche.</h2>
          </div>
          <div className="mini-grid">
            {THEMES.filter(t => t.id !== activeId).map((t, i) => (
              <button key={t.id}
                      className="mini-card"
                      data-reveal
                      style={{"--theme-accent": t.accent, "--reveal-delay": `${i*50}ms`}}
                      onClick={() => { setActiveId(t.id); window.scrollTo({ top: 240, behavior: "smooth" }); }}>
                <div className="mini-card-art">
                  <ThemePreview kind={t.preview} accent={t.accent} accentSoft={t.accentSoft} />
                </div>
                <div className="mini-card-body">
                  <span className="theme-card-niche">{t.niche}</span>
                  <strong>{t.name}</strong>
                  <span style={{color:"var(--text-muted)", fontSize: 13}}>{t.tagline}</span>
                </div>
              </button>
            ))}
          </div>
        </div>
      </section>

      <FinalCTA />
      <Footer />
    </>
  );
}

function MobileFrame() {
  return (
    <div className="mobile-frame">
      <div className="mobile-notch"></div>
    </div>
  );
}
function TabletFrame() { return <div className="tablet-frame"></div>; }

ReactDOM.createRoot(document.getElementById("root")).render(<DemosApp />);
