/* Demo mock pages — abstract, theme-colored, full-height
   Each theme gets multiple "pages" (Home / inner pages) shown as
   responsive previews. All hand-built SVGs with no fake photography. */

function DemoPage({ theme, page }) {
  const accent = theme.accent;
  const soft = theme.accentSoft;
  return (
    <svg viewBox="0 0 1200 1800" xmlns="http://www.w3.org/2000/svg"
         preserveAspectRatio="xMidYMin meet"
         style={{ width: "100%", display: "block", background: "#07080c" }}>
      <defs>
        <linearGradient id={`dh-${theme.id}-${page}`} x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stopColor={soft} stopOpacity="0.4" />
          <stop offset="100%" stopColor={accent} stopOpacity="0.05" />
        </linearGradient>
        <linearGradient id={`db-${theme.id}-${page}`} x1="0" y1="0" x2="0" y2="1">
          <stop offset="0%" stopColor="#0e1118" />
          <stop offset="100%" stopColor="#07080c" />
        </linearGradient>
        <radialGradient id={`dg-${theme.id}-${page}`} cx="80%" cy="0%" r="80%">
          <stop offset="0%" stopColor={accent} stopOpacity="0.25" />
          <stop offset="100%" stopColor={accent} stopOpacity="0" />
        </radialGradient>
      </defs>

      <rect width="1200" height="1800" fill={`url(#db-${theme.id}-${page})`} />

      {/* Top nav strip */}
      <rect x="0" y="0" width="1200" height="70" fill="#0a0c12" />
      <rect x="48" y="28" width="120" height="14" rx="3" fill={accent} opacity="0.9" />
      <rect x="700" y="30" width="60"  height="10" rx="3" fill="#2a2d35" />
      <rect x="780" y="30" width="60"  height="10" rx="3" fill="#2a2d35" />
      <rect x="860" y="30" width="60"  height="10" rx="3" fill="#2a2d35" />
      <rect x="940" y="30" width="60"  height="10" rx="3" fill="#2a2d35" />
      <rect x="1040" y="22" width="112" height="26" rx="6" fill={accent} opacity="0.9" />

      {renderPage(theme, page, accent, soft)}
    </svg>
  );
}

function renderPage(theme, page, accent, soft) {
  const text = "#3a3f4a";
  const dim = "#1f232c";
  const surface = "#0e1118";

  /* ─────────────────── HOME variants ─────────────────── */
  if (page === "home") {
    return (
      <g>
        {/* Hero band */}
        <rect x="0" y="70" width="1200" height="520" fill={`url(#dh-${theme.id}-${page})`} />
        <rect x="0" y="70" width="1200" height="520" fill={`url(#dg-${theme.id}-${page})`} />
        {heroByTheme(theme, accent, soft)}

        {/* Eyebrow + headline */}
        <rect x="80" y="180" width="120" height="10" rx="3" fill={soft} opacity="0.9" />
        <rect x="80" y="220" width="600" height="36" rx="4" fill="#f5f6f8" opacity="0.9" />
        <rect x="80" y="270" width="480" height="36" rx="4" fill="#f5f6f8" opacity="0.6" />
        <rect x="80" y="335" width="540" height="8"  rx="2" fill={text} />
        <rect x="80" y="353" width="500" height="8"  rx="2" fill={text} />
        <rect x="80" y="371" width="420" height="8"  rx="2" fill={text} />
        <rect x="80" y="420" width="160" height="48" rx="8" fill={accent} />
        <rect x="252" y="420" width="160" height="48" rx="8" fill="none" stroke="#2a2d35" strokeWidth="1.5" />

        {/* Section: 3-card grid */}
        <rect x="80" y="660" width="200" height="10" rx="3" fill={soft} opacity="0.9" />
        <rect x="80" y="690" width="420" height="28" rx="4" fill="#f5f6f8" opacity="0.85" />
        {[0,1,2].map(i => (
          <g key={i} transform={`translate(${80 + i*355}, 770)`}>
            <rect width="335" height="260" rx="14" fill={surface} stroke={dim} />
            <rect x="22" y="22" width="44" height="44" rx="10" fill={accent} opacity="0.22" />
            <rect x="22" y="22" width="44" height="44" rx="10" fill="none" stroke={accent} opacity="0.5" />
            <rect x="22" y="92" width="200" height="14" rx="3" fill="#f5f6f8" opacity="0.85" />
            <rect x="22" y="122" width="280" height="7" rx="2" fill={text} />
            <rect x="22" y="138" width="240" height="7" rx="2" fill={text} />
            <rect x="22" y="154" width="200" height="7" rx="2" fill={text} />
            <rect x="22" y="210" width="80"  height="10" rx="3" fill={soft} opacity="0.9" />
          </g>
        ))}

        {/* Section: feature split */}
        <rect x="80" y="1110" width="500" height="380" rx="14" fill={surface} stroke={dim} />
        {heroByTheme(theme, accent, soft, { x: 80, y: 1110, w: 500, h: 380, mini: true })}

        <rect x="620" y="1140" width="120" height="10" rx="3" fill={soft} opacity="0.9" />
        <rect x="620" y="1170" width="420" height="28" rx="4" fill="#f5f6f8" opacity="0.85" />
        <rect x="620" y="1210" width="380" height="28" rx="4" fill="#f5f6f8" opacity="0.6" />
        {[0,1,2,3].map(i => (
          <g key={i} transform={`translate(620, ${1280 + i*48})`}>
            <circle cx="9" cy="10" r="6" fill={accent} opacity="0.7" />
            <rect x="26" y="4"  width="380" height="6" rx="2" fill={text} />
            <rect x="26" y="16" width="240" height="6" rx="2" fill={text} opacity="0.6" />
          </g>
        ))}

        {/* CTA strip */}
        <rect x="80" y="1570" width="1040" height="160" rx="14" fill={surface} stroke={dim} />
        <rect x="80" y="1570" width="1040" height="160" rx="14" fill={accent} opacity="0.08" />
        <rect x="120" y="1620" width="500" height="22" rx="3" fill="#f5f6f8" opacity="0.9" />
        <rect x="120" y="1652" width="400" height="10" rx="2" fill={text} />
        <rect x="940" y="1640" width="140" height="44" rx="8" fill={accent} />
      </g>
    );
  }

  /* ─────────────────── INNER PAGES per theme ─────────────────── */
  if (page === "rooms" || page === "fleet" || page === "tours") {
    return (
      <g>
        {/* Page header */}
        <rect x="0" y="70" width="1200" height="260" fill={`url(#dh-${theme.id}-${page})`} />
        <rect x="80" y="140" width="120" height="10" rx="3" fill={soft} />
        <rect x="80" y="170" width="520" height="34" rx="4" fill="#f5f6f8" opacity="0.9" />
        <rect x="80" y="216" width="380" height="8"  rx="2" fill={text} />
        <rect x="80" y="232" width="320" height="8"  rx="2" fill={text} />

        {/* Filter bar */}
        <rect x="80" y="360" width="1040" height="56" rx="10" fill={surface} stroke={dim} />
        {["All", "Standard", "Deluxe", "Suite", "Penthouse"].map((_, i) => (
          <g key={i} transform={`translate(${100 + i*120}, 376)`}>
            <rect width="100" height="24" rx="6" fill={i === 0 ? accent : "transparent"} stroke={i === 0 ? "none" : dim} />
            <rect x="20" y="9" width="60" height="6" rx="2" fill={i === 0 ? "white" : text} opacity={i === 0 ? 0.95 : 0.7} />
          </g>
        ))}
        <rect x="960" y="376" width="140" height="24" rx="6" fill={surface} stroke={dim} />

        {/* Card grid 3x2 */}
        {Array.from({length: 6}).map((_, i) => {
          const col = i % 3, row = Math.floor(i / 3);
          const x = 80 + col*355, y = 460 + row*440;
          return (
            <g key={i} transform={`translate(${x}, ${y})`}>
              <rect width="335" height="400" rx="14" fill={surface} stroke={dim} />
              {/* Image area */}
              <rect width="335" height="220" rx="14" fill={accent} opacity="0.18" />
              <rect width="335" height="220" rx="14" fill={`url(#dg-${theme.id}-${page})`} opacity="0.4" />
              {cardArtByTheme(theme, accent, soft, i)}
              <rect x="248" y="184" width="72" height="22" rx="11" fill="#0a0c12" opacity="0.85" />
              <rect x="262" y="192" width="44" height="6" rx="2" fill={soft} />

              {/* Body */}
              <rect x="20" y="244" width="60" height="9" rx="2" fill={soft} opacity="0.9" />
              <rect x="20" y="266" width="220" height="15" rx="3" fill="#f5f6f8" opacity="0.9" />
              <rect x="20" y="294" width="280" height="7" rx="2" fill={text} />
              <rect x="20" y="310" width="240" height="7" rx="2" fill={text} />
              {/* spec row */}
              <rect x="20" y="340" width="60"  height="20" rx="4" fill="#0a0c12" stroke={dim} />
              <rect x="86" y="340" width="60"  height="20" rx="4" fill="#0a0c12" stroke={dim} />
              <rect x="152" y="340" width="60" height="20" rx="4" fill="#0a0c12" stroke={dim} />
              <rect x="232" y="338" width="84" height="24" rx="6" fill={accent} />
            </g>
          );
        })}
      </g>
    );
  }

  /* services / practice / categories — generic services grid */
  if (page === "services" || page === "practice" || page === "categories") {
    return (
      <g>
        <rect x="0" y="70" width="1200" height="260" fill={`url(#dh-${theme.id}-${page})`} />
        <rect x="80" y="140" width="120" height="10" rx="3" fill={soft} />
        <rect x="80" y="170" width="520" height="34" rx="4" fill="#f5f6f8" opacity="0.9" />
        <rect x="80" y="216" width="420" height="8" rx="2" fill={text} />

        {Array.from({length: 6}).map((_, i) => {
          const col = i % 3, row = Math.floor(i / 3);
          return (
            <g key={i} transform={`translate(${80 + col*355}, ${400 + row*280})`}>
              <rect width="335" height="250" rx="14" fill={surface} stroke={dim} />
              <rect x="24" y="24" width="52" height="52" rx="12" fill={accent} opacity="0.22" />
              <rect x="24" y="24" width="52" height="52" rx="12" fill="none" stroke={accent} opacity="0.55" />
              <rect x="24" y="100" width="240" height="16" rx="3" fill="#f5f6f8" opacity="0.85" />
              <rect x="24" y="130" width="280" height="7" rx="2" fill={text} />
              <rect x="24" y="146" width="260" height="7" rx="2" fill={text} />
              <rect x="24" y="162" width="220" height="7" rx="2" fill={text} />
              <rect x="24" y="196" width="80" height="10" rx="3" fill={soft} opacity="0.9" />
              <rect x="24" y="216" width="40" height="6" rx="2" fill={text} opacity="0.5" />
            </g>
          );
        })}

        <rect x="80" y="1040" width="1040" height="200" rx="14" fill={surface} stroke={dim} />
        <rect x="120" y="1080" width="500" height="22" rx="3" fill="#f5f6f8" opacity="0.85" />
        <rect x="120" y="1115" width="600" height="8" rx="2" fill={text} />
        <rect x="120" y="1131" width="500" height="8" rx="2" fill={text} />
        <rect x="120" y="1170" width="160" height="40" rx="8" fill={accent} />
      </g>
    );
  }

  /* booking / chat — single page detail with sidebar */
  if (page === "booking" || page === "lookup" || page === "contact") {
    return (
      <g>
        <rect x="0" y="70" width="1200" height="200" fill={`url(#dh-${theme.id}-${page})`} />
        <rect x="80" y="130" width="120" height="10" rx="3" fill={soft} />
        <rect x="80" y="160" width="420" height="34" rx="4" fill="#f5f6f8" opacity="0.9" />

        {/* Main card */}
        <rect x="80" y="320" width="720" height="900" rx="14" fill={surface} stroke={dim} />
        {/* Steps */}
        <g transform="translate(120, 360)">
          <circle cx="14" cy="14" r="14" fill={accent} />
          <rect x="40" y="10" width="80" height="8" rx="2" fill="#f5f6f8" opacity="0.85" />
          <rect x="40" y="22" width="60" height="6" rx="2" fill={text} />

          <rect x="150" y="13" width="100" height="2" fill={dim} />

          <circle cx="270" cy="14" r="14" fill="none" stroke={dim} strokeWidth="1.5" />
          <rect x="296" y="10" width="80" height="8" rx="2" fill={text} />
          <rect x="296" y="22" width="60" height="6" rx="2" fill={text} opacity="0.5" />

          <rect x="406" y="13" width="100" height="2" fill={dim} />

          <circle cx="526" cy="14" r="14" fill="none" stroke={dim} strokeWidth="1.5" />
          <rect x="552" y="10" width="80" height="8" rx="2" fill={text} />
        </g>

        {/* Form fields */}
        {[0,1,2,3].map(i => (
          <g key={i} transform={`translate(120, ${440 + i*88})`}>
            <rect width="120" height="8" rx="2" fill={text} />
            <rect y="18" width="640" height="52" rx="8" fill="#0a0c12" stroke={dim} />
            <rect x="20" y="40" width="180" height="8" rx="2" fill={text} opacity="0.5" />
          </g>
        ))}
        <rect x="120" y="820" width="640" height="120" rx="8" fill="#0a0c12" stroke={dim} />
        <rect x="120" y="980" width="640" height="56" rx="10" fill={accent} />
        <rect x="370" y="1000" width="140" height="14" rx="3" fill="white" opacity="0.9" />

        {/* Sidebar summary */}
        <rect x="840" y="320" width="280" height="500" rx="14" fill={surface} stroke={dim} />
        <rect x="864" y="350" width="120" height="10" rx="3" fill={soft} />
        <rect x="864" y="376" width="200" height="20" rx="3" fill="#f5f6f8" opacity="0.85" />
        <rect x="864" y="406" width="240" height="8" rx="2" fill={text} />
        <rect x="864" y="422" width="180" height="8" rx="2" fill={text} />

        <rect x="864" y="460" width="232" height="1" fill={dim} />
        {[0,1,2,3].map(i => (
          <g key={i} transform={`translate(864, ${480 + i*46})`}>
            <rect width="120" height="8" rx="2" fill={text} />
            <rect x="180" y="0" width="52" height="8" rx="2" fill="#f5f6f8" opacity="0.85" />
            <rect y="18" width="232" height="1" fill={dim} />
          </g>
        ))}
        <rect x="864" y="690" width="120" height="14" rx="3" fill="#f5f6f8" opacity="0.85" />
        <rect x="1020" y="690" width="80" height="20" rx="3" fill={accent} />

        <rect x="840" y="850" width="280" height="200" rx="14" fill={surface} stroke={dim} />
        <rect x="864" y="876" width="200" height="14" rx="3" fill="#f5f6f8" opacity="0.85" />
        <rect x="864" y="906" width="232" height="7" rx="2" fill={text} />
        <rect x="864" y="922" width="180" height="7" rx="2" fill={text} />
        <rect x="864" y="970" width="232" height="40" rx="8" fill="#0a0c12" stroke={dim} />
        <rect x="884" y="984" width="100" height="12" rx="3" fill={accent} opacity="0.8" />
      </g>
    );
  }

  return null;
}

/* Distinctive hero artwork per theme */
function heroByTheme(theme, accent, soft, opts = {}) {
  const { x = 0, y = 70, w = 1200, h = 520, mini = false } = opts;
  const cx = x + w * (mini ? 0.5 : 0.78);
  const cy = y + h * 0.5;
  const scale = mini ? 0.5 : 1;
  const s = (n) => n * scale;

  switch (theme.id) {
    case "msp":
      return (
        <g transform={`translate(${cx - s(100)}, ${cy - s(120)})`}>
          <path d={`M${s(100)} 0 L${s(190)} ${s(40)} V${s(140)} C${s(190)} ${s(200)} ${s(160)} ${s(220)} ${s(100)} ${s(240)} C${s(40)} ${s(220)} ${s(10)} ${s(200)} ${s(10)} ${s(140)} V${s(40)} Z`}
                fill="none" stroke={accent} strokeWidth="2" />
          <path d={`M${s(100)} ${s(30)} L${s(170)} ${s(60)} V${s(140)} C${s(170)} ${s(186)} ${s(146)} ${s(202)} ${s(100)} ${s(214)} C${s(54)} ${s(202)} ${s(30)} ${s(186)} ${s(30)} ${s(140)} V${s(60)} Z`}
                fill={accent} opacity="0.15" />
          <path d={`M${s(72)} ${s(130)} L${s(94)} ${s(152)} L${s(132)} ${s(108)}`} stroke={accent} strokeWidth={s(4)} fill="none" strokeLinecap="round" strokeLinejoin="round" />
        </g>
      );
    case "legal":
      return (
        <g transform={`translate(${cx - s(80)}, ${cy - s(110)})`} stroke={accent} strokeWidth={s(2)} fill="none">
          <line x1={s(80)} y1={s(20)} x2={s(80)} y2={s(220)} />
          <line x1={s(30)} y1={s(20)} x2={s(130)} y2={s(20)} />
          <path d={`M${s(30)} ${s(20)} L${s(0)} ${s(100)} L${s(60)} ${s(100)} Z`} fill={accent} fillOpacity="0.15" />
          <path d={`M${s(130)} ${s(20)} L${s(100)} ${s(100)} L${s(160)} ${s(100)} Z`} fill={accent} fillOpacity="0.15" />
          <ellipse cx={s(80)} cy={s(230)} rx={s(30)} ry={s(5)} />
        </g>
      );
    case "nslookup":
      return (
        <g transform={`translate(${cx - s(110)}, ${cy - s(110)})`}>
          <circle cx={s(110)} cy={s(110)} r={s(100)} fill="none" stroke={soft} strokeWidth={s(1.5)} opacity="0.5" />
          <ellipse cx={s(110)} cy={s(110)} rx={s(100)} ry={s(30)} fill="none" stroke={soft} strokeWidth={s(1.2)} opacity="0.55" />
          <ellipse cx={s(110)} cy={s(110)} rx={s(30)} ry={s(100)} fill="none" stroke={soft} strokeWidth={s(1.2)} opacity="0.55" />
          <ellipse cx={s(110)} cy={s(110)} rx={s(70)} ry={s(100)} fill="none" stroke={soft} strokeWidth={s(1)} opacity="0.35" transform={`rotate(20 ${s(110)} ${s(110)})`} />
          <circle cx={s(110)} cy={s(110)} r={s(6)} fill={accent} />
          {[40, 80, 130, 180].map(d => (
            <circle key={d} cx={s(110 + d*0.6)} cy={s(110 - d*0.4)} r={s(3)} fill={accent} opacity="0.8" />
          ))}
        </g>
      );
    case "carvice":
      return (
        <g transform={`translate(${cx - s(140)}, ${cy - s(50)})`} fill={accent}>
          <path d={`M0 ${s(70)} C0 ${s(58)} ${s(14)} ${s(34)} ${s(40)} ${s(34)} L${s(110)} ${s(16)} C${s(140)} ${s(16)} ${s(180)} ${s(34)} ${s(206)} ${s(34)} C${s(230)} ${s(34)} ${s(270)} ${s(58)} ${s(270)} ${s(70)} L${s(270)} ${s(96)} L0 ${s(96)} Z`} opacity="0.85" />
          <circle cx={s(56)} cy={s(96)} r={s(18)} fill="#0a0c12" />
          <circle cx={s(56)} cy={s(96)} r={s(10)} fill={accent} />
          <circle cx={s(214)} cy={s(96)} r={s(18)} fill="#0a0c12" />
          <circle cx={s(214)} cy={s(96)} r={s(10)} fill={accent} />
        </g>
      );
    case "driveease":
      return (
        <g transform={`translate(${cx - s(110)}, ${cy - s(110)})`}>
          <circle cx={s(110)} cy={s(110)} r={s(100)} fill="none" stroke={accent} strokeWidth={s(8)} opacity="0.85" />
          <circle cx={s(110)} cy={s(110)} r={s(70)} fill="none" stroke={accent} strokeWidth={s(2)} opacity="0.55" />
          <circle cx={s(110)} cy={s(110)} r={s(20)} fill={accent} />
          {[0, 60, 120, 180, 240, 300].map(a => (
            <line key={a} x1={s(110)} y1={s(110)} x2={s(110 + Math.cos(a*Math.PI/180)*90)} y2={s(110 + Math.sin(a*Math.PI/180)*90)} stroke={accent} strokeWidth={s(6)} opacity="0.6" />
          ))}
        </g>
      );
    case "tourvice":
      return (
        <g transform={`translate(${cx - s(160)}, ${cy - s(80)})`}>
          <circle cx={s(60)} cy={s(20)} r={s(28)} fill={soft} opacity="0.7" />
          <path d={`M0 ${s(160)} L${s(80)} ${s(40)} L${s(150)} ${s(120)} L${s(220)} ${s(20)} L${s(320)} ${s(160)} Z`}
                fill="none" stroke={accent} strokeWidth={s(2)} />
          <path d={`M0 ${s(160)} L${s(80)} ${s(40)} L${s(150)} ${s(120)} L${s(220)} ${s(20)} L${s(320)} ${s(160)} L${s(320)} ${s(220)} L0 ${s(220)} Z`}
                fill={accent} opacity="0.18" />
        </g>
      );
    case "meridian":
      return (
        <g transform={`translate(${cx - s(180)}, ${cy - s(110)})`} fill={accent} opacity="0.6">
          <rect x="0" y={s(140)} width={s(34)} height={s(80)} />
          <rect x={s(40)} y={s(100)} width={s(28)} height={s(120)} />
          <rect x={s(74)} y={s(60)} width={s(32)} height={s(160)} />
          <rect x={s(112)} y={s(120)} width={s(24)} height={s(100)} />
          <rect x={s(142)} y={s(40)} width={s(38)} height={s(180)} />
          <rect x={s(186)} y={s(80)} width={s(30)} height={s(140)} />
          <rect x={s(222)} y={s(20)} width={s(42)} height={s(200)} />
          <rect x={s(270)} y={s(110)} width={s(26)} height={s(110)} />
          <rect x={s(302)} y={s(70)} width={s(34)} height={s(150)} />
        </g>
      );
    default: return null;
  }
}

function cardArtByTheme(theme, accent, soft, i) {
  // Small art in each grid card — varied
  switch (theme.id) {
    case "meridian":
      // skyline window strips
      return (
        <g opacity="0.4">
          {Array.from({length: 6}).map((_, j) => (
            <rect key={j} x={30 + j*48} y={60 + (j%2)*30} width="24" height="110" fill={accent} />
          ))}
        </g>
      );
    case "driveease":
      return (
        <g transform="translate(80, 70)" opacity="0.6">
          <circle cx="80" cy="70" r="44" fill="none" stroke={accent} strokeWidth="6" />
          <circle cx="80" cy="70" r="10" fill={accent} />
        </g>
      );
    case "tourvice":
      return (
        <g opacity="0.5">
          <path d={`M0 200 L${60 + i*10} ${80 + i*8} L${140 + i*5} ${140 - i*4} L${220} ${60 + i*6} L${335} ${180 - i*3} L${335} 220 L0 220 Z`} fill={accent} />
        </g>
      );
    default:
      return (
        <g opacity="0.5">
          <rect x="40" y="60" width="40" height="40" rx="10" fill={accent} />
          <rect x="100" y="60" width="40" height="40" rx="10" fill={accent} opacity="0.6" />
          <rect x="160" y="60" width="40" height="40" rx="10" fill={accent} opacity="0.4" />
        </g>
      );
  }
}

window.DemoPage = DemoPage;
