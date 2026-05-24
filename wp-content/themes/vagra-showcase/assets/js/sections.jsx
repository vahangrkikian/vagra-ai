/* Page sections */

function Hero({ heroVariant }) {
  const ref = React.useRef(null);
  React.useEffect(() => {
    const el = ref.current;
    if (!el) return;
    const mouse = el.querySelector(".hero-mouse");
    const onMove = (e) => {
      const r = el.getBoundingClientRect();
      mouse.style.left = (e.clientX - r.left) + "px";
      mouse.style.top  = (e.clientY - r.top)  + "px";
    };
    el.addEventListener("mousemove", onMove);
    return () => el.removeEventListener("mousemove", onMove);
  }, []);

  return (
    <header id="top" className="hero" ref={ref}>
      <div className="hero-bg">
        {heroVariant !== "static" && <div className="hero-grid"></div>}
        <div className="hero-glow"></div>
      </div>
      <div className="hero-mouse"></div>

      <div className="container hero-inner">
        <span className="eyebrow" data-reveal>8 niches · 8 themes · 8 concierges</span>
        <h1 data-reveal style={{ "--reveal-delay": "60ms" }}>
          WordPress themes that{" "}
          <span className="gradient">know your industry.</span>
        </h1>
        <p className="hero-sub" data-reveal style={{ "--reveal-delay": "140ms" }}>
          Purpose-built themes with a native AI concierge for cybersecurity firms,
          law offices, hotels, car services, DNS tooling, tourism, rentals, and home services.
          Free on WordPress.org. No bloat. No plugin sprawl.
        </p>
        <div className="hero-ctas" data-reveal style={{ "--reveal-delay": "220ms" }}>
          <a href="#themes" className="btn btn-primary">
            Explore themes <Icon name="arrow" size={15} />
          </a>
          <a href="#ai" className="btn btn-ghost">
            See AI in action
          </a>
        </div>
        <div className="hero-trust" data-reveal style={{ "--reveal-delay": "300ms" }}>
          <span><b style={{color:"var(--text-body)"}}>8</b> themes</span>
          <span className="sep">·</span>
          <span>PageSpeed <b style={{color:"var(--text-body)"}}>90+</b></span>
          <span className="sep">·</span>
          <span>WP.org compliant</span>
          <span className="sep">·</span>
          <span>GPL-2.0</span>
          <span className="sep">·</span>
          <span>i18n ready</span>
        </div>
      </div>

      <div className="container hero-preview" data-reveal style={{ "--reveal-delay": "380ms" }}>
        <div className="hero-preview-track">
          {[1,3,6].map((i) => {
            const t = THEMES[i];
            return (
              <div className="hero-preview-card" key={t.id}
                   style={{ "--theme-accent": t.accent }}>
                <ThemePreview kind={t.preview} accent={t.accent} accentSoft={t.accentSoft} />
              </div>
            );
          })}
        </div>
      </div>
    </header>
  );
}

function ThemeGrid() {
  const [filter, setFilter] = React.useState("all");
  const list = filter === "all" ? THEMES : THEMES.filter(t => t.category === filter);
  return (
    <section id="themes">
      <div className="container">
        <div className="section-head">
          <span className="eyebrow" data-reveal>The collection</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms"}}>Eight themes. One philosophy.</h2>
          <p className="section-lede" data-reveal style={{"--reveal-delay":"120ms"}}>
            Every theme is hand-built for a single vertical — its own custom post types, its own
            booking logic, its own AI persona. No starter-template skins. No multipurpose compromise.
          </p>
        </div>

        <div className="filter-bar" data-reveal>
          {CATEGORIES.map(c => (
            <button key={c.id}
                    className="filter-chip"
                    data-active={filter === c.id}
                    onClick={() => setFilter(c.id)}>
              {c.label}
            </button>
          ))}
        </div>

        <div className="theme-grid">
          {list.map((t, i) => (
            <article key={t.id}
                     className="theme-card"
                     data-reveal
                     style={{
                       "--theme-accent": t.accent,
                       "--reveal-delay": `${i*60}ms`,
                     }}>
              <div className="theme-card-preview">
                <ThemePreview kind={t.preview} accent={t.accent} accentSoft={t.accentSoft} />
              </div>
              <div className="theme-card-body">
                <div className="theme-card-meta">
                  <span className="theme-card-niche">{t.niche}</span>
                  {t.elementor && (
                    <span className="theme-card-compat">
                      <svg width="12" height="12" viewBox="0 0 24 24" fill="currentColor"><path d="M21 2H3a1 1 0 0 0-1 1v18a1 1 0 0 0 1 1h18a1 1 0 0 0 1-1V3a1 1 0 0 0-1-1zm-1 18H4V4h16v16z"/><path d="M7 6h10v2H7zM7 10h10v2H7zM7 14h6v2H7z"/></svg>
                      Elementor
                    </span>
                  )}
                  <span className="theme-card-status">
                    <span className="live-dot"></span> Live
                  </span>
                </div>
                <h3>{t.name}</h3>
                <p className="theme-card-tag">{t.tagline}</p>
                <div className="theme-card-ai">
                  <Icon name="spark" size={13} /> AI: {t.ai}
                </div>
                <div className="theme-card-actions">
                  <a className="theme-card-btn" href={t.url} target="_blank" rel="noopener">Preview</a>
                  <a className="theme-card-btn primary" href={t.url} target="_blank" rel="noopener">
                    Details →
                  </a>
                </div>
              </div>
            </article>
          ))}
        </div>
      </div>
    </section>
  );
}

function AIDemo() {
  const demoable = THEMES;
  const [tabId, setTabId] = React.useState("msp");
  const theme = demoable.find(t => t.id === tabId);
  const [visible, setVisible] = React.useState(theme.chat.length);
  const [playing, setPlaying] = React.useState(false);
  const tabsRef = React.useRef(null);

  // Reset & replay on tab change
  React.useEffect(() => {
    setPlaying(true);
    setVisible(0);
    const timers = [];
    theme.chat.forEach((_, i) => {
      timers.push(setTimeout(() => setVisible(i + 1), 600 + i * 1400));
    });
    timers.push(setTimeout(() => setPlaying(false), 600 + theme.chat.length * 1400));
    return () => timers.forEach(clearTimeout);
  }, [tabId]);

  // Scroll active tab into view
  React.useEffect(() => {
    if (!tabsRef.current) return;
    const active = tabsRef.current.querySelector('[data-active="true"]');
    if (active) active.scrollIntoView({ behavior: "smooth", block: "nearest", inline: "center" });
  }, [tabId]);

  return (
    <section id="ai">
      <div className="container split">
        <div>
          <span className="eyebrow" data-reveal>The AI difference</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms", marginTop: 14}}>
            Not a chatbot plugin.<br />
            <span style={{color:"var(--text-muted)"}}>A concierge that speaks your industry.</span>
          </h2>
          <p data-reveal style={{"--reveal-delay":"140ms", marginTop: 20, color:"var(--text-muted)", fontSize: 16, lineHeight: 1.6}}>
            Every vagra.ai theme ships with a domain-trained AI assistant. The legal theme
            won't give legal advice — it captures intake. The hotel theme books rooms. The MSP
            theme explains DMARC to prospects who don't know what to ask.
          </p>
          <ul className="bullets" data-reveal style={{"--reveal-delay":"220ms"}}>
            <li>Trained per vertical — not generic</li>
            <li>Captures leads inline — name, email, intent</li>
            <li>Zero server-side storage — sessionStorage only</li>
            <li>Your API key, your control, your costs</li>
            <li>Edit the system prompt in the Customizer, no code</li>
          </ul>
        </div>

        <div className="chat-demo" data-reveal style={{"--reveal-delay":"100ms", "--tab-accent": theme.accent}}>
          <div className="chat-tabs" ref={tabsRef}>
            {demoable.map(t => (
              <button key={t.id}
                      className="chat-tab"
                      data-active={t.id === tabId}
                      onClick={() => setTabId(t.id)}
                      style={{ "--tab-accent": t.accent }}>
                <span className="tab-dot"></span>
                {t.name}
              </button>
            ))}
          </div>
          <div className="chat-header">
            <div className="chat-avatar">{theme.persona.initials}</div>
            <div className="chat-persona">
              <span className="chat-persona-name">{theme.persona.name}</span>
              <span className="chat-persona-role">{theme.persona.role}</span>
            </div>
            <span className="chat-status">
              <span className="live-dot"></span> Online
            </span>
          </div>
          <div className="chat-body">
            {theme.chat.slice(0, visible).map((m, i) => (
              <div key={`${tabId}-${i}`} className={`msg ${m.from}`}>
                <div className="bubble">{m.text}</div>
              </div>
            ))}
            {playing && visible < theme.chat.length && (
              <div className="msg ai">
                <div className="bubble" style={{padding: 0, background: "var(--bg-3)"}}>
                  <div className="typing"><span></span><span></span><span></span></div>
                </div>
              </div>
            )}
          </div>
          <div className="chat-input">
            <input placeholder={`Ask ${theme.persona.name}…`} disabled />
            <button onClick={() => { setPlaying(true); setVisible(0); setTimeout(() => setTabId(tabId), 0); }}>
              Replay
            </button>
          </div>
        </div>
      </div>
    </section>
  );
}

function Steps() {
  return (
    <section id="how">
      <div className="container">
        <div className="section-head centered">
          <span className="eyebrow" data-reveal>How it works</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms"}}>From install to live concierge in under five minutes.</h2>
        </div>
        <div className="steps">
          {STEPS.map((s, i) => (
            <div className="step" key={i} data-reveal style={{"--reveal-delay": `${i*100}ms`}}>
              <div style={{display:"flex", justifyContent:"space-between", alignItems:"center"}}>
                <span className="step-num">0{i+1}</span>
                <span className="step-icon"><Icon name={s.icon} size={20} /></span>
              </div>
              <h3>{s.title}</h3>
              <p>{s.body}</p>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function Stats() {
  return (
    <section className="stats">
      <div className="container">
        <div className="stats-grid">
          {STATS.map((s, i) => (
            <div className="stat" key={i} data-reveal style={{"--reveal-delay": `${i*60}ms`}}>
              <div className="stat-value">{s.v}</div>
              <div className="stat-label">{s.l}</div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function Testimonials() {
  return (
    <section id="customers">
      <div className="container">
        <div className="section-head centered">
          <span className="eyebrow" data-reveal>Early signal</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms"}}>Built with the people who'll ship it.</h2>
          <p className="section-lede" data-reveal style={{"--reveal-delay":"120ms"}}>
            We're working closely with a small group of agencies, MSPs, and operators before
            we hit a thousand installs. Here's what they're saying.
          </p>
        </div>
        <div className="testimonials">
          {TESTIMONIALS.map((t, i) => (
            <div className="testimonial" key={i} data-reveal style={{"--reveal-delay": `${i*80}ms`}}>
              <blockquote>{t.quote}</blockquote>
              <div className="testimonial-author">
                <div className="author-avatar">{t.initials}</div>
                <div>
                  <div className="author-name">{t.name}</div>
                  <div className="author-role">{t.role}</div>
                </div>
              </div>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function Pricing() {
  const tiers = [
    {
      name: "Free",
      tag: "On WordPress.org. Forever.",
      amt: "$0",
      per: "/ forever",
      features: [
        "All 8 themes, full templates",
        "AI chat widget (BYOK)",
        "One-click demo content import",
        "Community support",
      ],
      cta: "Browse on WordPress.org",
    },
    {
      name: "Pro",
      tag: "Per theme. Best for single-vertical operators.",
      amt: "$49",
      per: "/ year",
      featured: true,
      features: [
        "Everything in Free",
        "Premium page templates",
        "Extended demo content packs",
        "Advanced Customizer options",
        "Priority support — 24h response",
        "White-label option",
      ],
      cta: "Get Pro",
    },
    {
      name: "Agency",
      tag: "All eight themes. Unlimited sites.",
      amt: "$199",
      per: "/ year",
      features: [
        "All 8 themes, Pro features",
        "Unlimited sites",
        "Remove vagra.ai credit",
        "Early access to new themes",
        "Direct line to the team",
      ],
      cta: "Get Agency",
    },
  ];
  return (
    <section id="pricing">
      <div className="container">
        <div className="section-head centered">
          <span className="eyebrow" data-reveal>Pricing</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms"}}>Free to start. Honest from there.</h2>
          <p className="section-lede" data-reveal style={{"--reveal-delay":"120ms"}}>
            The cores are GPL-2.0 and free on WordPress.org. Pro and Agency add the conveniences
            you'd build yourself — sold honestly, no enterprise sales call.
          </p>
        </div>
        <div className="pricing-grid">
          {tiers.map((t, i) => (
            <div className="price-card" key={t.name} data-featured={!!t.featured} data-reveal style={{"--reveal-delay": `${i*80}ms`}}>
              <h3>{t.name}</h3>
              <p className="price-tag">{t.tag}</p>
              <div className="price-amount">
                <span className="amt">{t.amt}</span>
                <span className="per">{t.per}</span>
              </div>
              <ul className="price-features">
                {t.features.map(f => <li key={f}>{f}</li>)}
              </ul>
              <a className="price-cta" href="#">{t.cta}</a>
            </div>
          ))}
        </div>
      </div>
    </section>
  );
}

function FAQSection() {
  return (
    <section id="faq">
      <div className="container">
        <div className="section-head centered">
          <span className="eyebrow" data-reveal>FAQ</span>
          <h2 data-reveal style={{"--reveal-delay":"60ms"}}>Questions, answered.</h2>
        </div>
        <div className="faq">
          {FAQ.map((item, i) => (
            <details className="faq-item" key={i} data-reveal style={{"--reveal-delay": `${i*40}ms`}}>
              <summary>{item.q}</summary>
              <p>{item.a}</p>
            </details>
          ))}
        </div>
      </div>
    </section>
  );
}

function FinalCTA() {
  return (
    <section className="final-cta">
      <div className="container">
        <span className="eyebrow" data-reveal>Last word</span>
        <h2 data-reveal style={{"--reveal-delay":"60ms", marginTop: 18}}>
          Your industry deserves more than a starter template.
        </h2>
        <p className="section-lede" data-reveal style={{"--reveal-delay":"120ms", maxWidth: 580, margin: "16px auto 0"}}>
          Eight niche themes, free on WordPress.org. Install one and have a concierge live
          by the time your coffee's done.
        </p>
        <div className="hero-ctas" data-reveal style={{"--reveal-delay":"200ms"}}>
          <a href="#themes" className="btn btn-primary">
            Get started — free <Icon name="arrow" size={15} />
          </a>
          <a href="#" className="btn btn-ghost">
            <Icon name="github" size={15} /> View on GitHub
          </a>
        </div>
      </div>
    </section>
  );
}

function Footer() {
  return (
    <footer>
      <div className="container">
        <div className="foot-grid">
          <div className="foot-col foot-brand">
            <a className="brand" href="#top">
              <span className="brand-mark"></span>
              <span>vagra<span className="brand-dot">.ai</span></span>
            </a>
            <p>WordPress themes that know your industry. Built by Ethiuni — bridges, not cathedrals.</p>
            <div className="foot-social">
              <a href="#" aria-label="GitHub"><Icon name="github" size={16} /></a>
              <a href="#" aria-label="X"><Icon name="x" size={16} /></a>
              <a href="#" aria-label="LinkedIn"><Icon name="linkedin" size={16} /></a>
            </div>
          </div>
          <div className="foot-col">
            <h4>Themes</h4>
            <ul>
              {THEMES.map(t => <li key={t.id}><a href={`#theme-${t.id}`}>{t.name}</a></li>)}
            </ul>
          </div>
          <div className="foot-col">
            <h4>Resources</h4>
            <ul>
              <li><a href="#">Documentation</a></li>
              <li><a href="#">Changelog</a></li>
              <li><a href="#">Support</a></li>
              <li><a href="#">Status</a></li>
              <li><a href="#">Blog</a></li>
            </ul>
          </div>
          <div className="foot-col">
            <h4>Company</h4>
            <ul>
              <li><a href="#">About Ethiuni</a></li>
              <li><a href="#">Contact</a></li>
              <li><a href="#">Press kit</a></li>
              <li><a href="#">Privacy</a></li>
              <li><a href="#">Terms</a></li>
            </ul>
          </div>
        </div>
        <div className="foot-bottom">
          <span>© 2026 Vagra.ai · All themes GPL-2.0-or-later</span>
          <span>nslookup.am · vagra.ai</span>
        </div>
      </div>
    </footer>
  );
}

Object.assign(window, {
  Hero, ThemeGrid, AIDemo, Steps, Stats, Testimonials,
  Pricing, FAQSection, FinalCTA, Footer,
});
