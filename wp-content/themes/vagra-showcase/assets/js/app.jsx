/* Main app — assembles sections and wires tweaks */

const TWEAK_DEFAULTS = /*EDITMODE-BEGIN*/{
  "accent": "#6366f1",
  "mode": "dark",
  "hero": "grid",
  "density": "comfy"
}/*EDITMODE-END*/;

const ACCENTS = [
  { value: "#6366f1", soft: "#818cf8", label: "Indigo" },
  { value: "#0ea5c4", soft: "#22b8d7", label: "Cyan"   },
  { value: "#d4af37", soft: "#e8c862", label: "Gold"   },
  { value: "#10b981", soft: "#34d399", label: "Emerald"},
  { value: "#ef4444", soft: "#f87171", label: "Crimson"},
];

function App() {
  const [t, setTweak] = useTweaks(TWEAK_DEFAULTS);

  // Apply tweaks to :root
  React.useEffect(() => {
    const r = document.documentElement;
    const accent = t.accent;
    const soft = (ACCENTS.find(a => a.value.toLowerCase() === (accent||"").toLowerCase()) || {soft: accent}).soft;
    r.style.setProperty("--accent", accent);
    r.style.setProperty("--accent-soft", soft);
    r.setAttribute("data-mode", t.mode);
    r.style.setProperty("--section-y",
      t.density === "compact" ? "clamp(56px, 6vw, 96px)" : "clamp(72px, 8vw, 128px)");
  }, [t.accent, t.mode, t.density]);

  useReveal();

  return (
    <>
      <Nav />
      <main>
        <Hero heroVariant={t.hero} />
        <ThemeGrid />
        <AIDemo />
        <Steps />
        <Stats />
        <Testimonials />
        <Pricing />
        <FAQSection />
        <FinalCTA />
      </main>
      <Footer />

      <TweaksPanel title="Tweaks">
        <TweakSection label="Brand" />
        <TweakColor label="Accent" value={t.accent}
                    options={ACCENTS.map(a => a.value)}
                    onChange={(v) => setTweak('accent', v)} />
        <TweakSection label="Surface" />
        <TweakRadio label="Mode" value={t.mode}
                    options={['dark','light']}
                    onChange={(v) => setTweak('mode', v)} />
        <TweakRadio label="Density" value={t.density}
                    options={['comfy','compact']}
                    onChange={(v) => setTweak('density', v)} />
        <TweakSection label="Hero" />
        <TweakRadio label="Background" value={t.hero}
                    options={['grid','static']}
                    onChange={(v) => setTweak('hero', v)} />
      </TweaksPanel>
    </>
  );
}

ReactDOM.createRoot(document.getElementById("root")).render(<App />);
