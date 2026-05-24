/* Abstract preview art per theme. No fake screenshots —
   each one is a stylized panel using only the theme's brand color. */

function ThemePreview({ kind, accent, accentSoft }) {
  // A faux browser chrome wrapping content tinted by theme accent
  return (
    <svg viewBox="0 0 480 300" xmlns="http://www.w3.org/2000/svg" role="img" aria-hidden="true">
      <defs>
        <linearGradient id={`bg-${kind}`} x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stopColor="#0e1118" />
          <stop offset="100%" stopColor="#070810" />
        </linearGradient>
        <linearGradient id={`acc-${kind}`} x1="0" y1="0" x2="1" y2="1">
          <stop offset="0%" stopColor={accentSoft} />
          <stop offset="100%" stopColor={accent} />
        </linearGradient>
        <radialGradient id={`glow-${kind}`} cx="50%" cy="50%" r="50%">
          <stop offset="0%" stopColor={accent} stopOpacity="0.45" />
          <stop offset="100%" stopColor={accent} stopOpacity="0" />
        </radialGradient>
      </defs>
      <rect width="480" height="300" fill={`url(#bg-${kind})`} />
      {/* browser chrome */}
      <rect x="0" y="0" width="480" height="26" fill="#0b0d14" />
      <line x1="0" y1="26" x2="480" y2="26" stroke="#1a1d25" />
      <circle cx="14" cy="13" r="4" fill="#3a3d45" />
      <circle cx="28" cy="13" r="4" fill="#3a3d45" />
      <circle cx="42" cy="13" r="4" fill="#3a3d45" />
      <rect x="74" y="6" width="280" height="14" rx="3" fill="#15171f" />
      <rect x="84" y="11" width="120" height="4" rx="2" fill="#2a2d35" />

      {renderScene(kind, accent, accentSoft)}
    </svg>
  );
}

function renderScene(kind, accent, accentSoft) {
  const acc = accent;
  const dim = "#1f232c";
  const text = "#3a3f4a";

  switch (kind) {
    case "shield":
      return (
        <g>
          <rect x="0" y="26" width="480" height="274" fill={`url(#glow-shield)`} opacity="0.6" />
          {/* shield */}
          <path d="M240 70 L300 90 V160 C300 200 270 220 240 230 C210 220 180 200 180 160 V90 Z"
                fill="none" stroke={acc} strokeWidth="2" opacity="0.9" />
          <path d="M240 100 L280 115 V160 C280 188 260 200 240 206 C220 200 200 188 200 160 V115 Z"
                fill={acc} opacity="0.12" />
          <path d="M225 155 L238 168 L260 142" stroke={acc} strokeWidth="3" strokeLinecap="round" strokeLinejoin="round" fill="none" />
          {/* nav row */}
          <rect x="20" y="42" width="80" height="6" rx="2" fill={text} />
          <rect x="380" y="42" width="80" height="14" rx="4" fill={acc} opacity="0.8" />
          {/* metrics chips */}
          <rect x="40" y="250" width="100" height="32" rx="8" fill="#0e1118" stroke={dim} />
          <rect x="160" y="250" width="100" height="32" rx="8" fill="#0e1118" stroke={dim} />
          <rect x="280" y="250" width="100" height="32" rx="8" fill="#0e1118" stroke={dim} />
          <circle cx="56" cy="266" r="4" fill={acc} />
          <circle cx="176" cy="266" r="4" fill={acc} />
          <circle cx="296" cy="266" r="4" fill={acc} />
        </g>
      );

    case "scales":
      return (
        <g>
          {/* serif headline mock */}
          <rect x="40" y="60" width="260" height="14" rx="3" fill="#2a2d35" />
          <rect x="40" y="84" width="200" height="14" rx="3" fill="#2a2d35" />
          <rect x="40" y="120" width="160" height="6" rx="2" fill={text} />
          <rect x="40" y="134" width="220" height="6" rx="2" fill={text} />
          <rect x="40" y="148" width="180" height="6" rx="2" fill={text} />
          <rect x="40" y="180" width="120" height="32" rx="6" fill={acc} opacity="0.9" />
          {/* scales icon */}
          <g transform="translate(340, 80)" stroke={acc} strokeWidth="2" fill="none">
            <line x1="50" y1="20" x2="50" y2="140" />
            <line x1="20" y1="20" x2="80" y2="20" />
            <path d="M20 20 L0 70 L40 70 Z" fill={acc} fillOpacity="0.15" />
            <path d="M80 20 L60 70 L100 70 Z" fill={acc} fillOpacity="0.15" />
            <ellipse cx="50" cy="145" rx="20" ry="3" />
          </g>
          <rect x="40" y="260" width="400" height="1" fill={dim} />
        </g>
      );

    case "globe":
      return (
        <g>
          {/* terminal panel */}
          <rect x="40" y="50" width="400" height="200" rx="10" fill="#0a0c12" stroke={dim} />
          <line x1="40" y1="74" x2="440" y2="74" stroke={dim} />
          {/* row of fake records */}
          {[0,1,2,3,4].map(i => (
            <g key={i} transform={`translate(56, ${88 + i*28})`}>
              <rect width="36" height="14" rx="3" fill={acc} opacity={0.18 + i*0.04} />
              <rect x="48" y="4" width="40" height="6" rx="2" fill={text} />
              <rect x="100" y="4" width="220" height="6" rx="2" fill="#2a2d35" />
              <rect x="340" y="4" width="40" height="6" rx="2" fill={text} />
            </g>
          ))}
          {/* corner dots = ascii globe */}
          <g transform="translate(380, 80)">
            <circle cx="20" cy="20" r="18" fill="none" stroke={accentSoft} strokeWidth="1" opacity="0.4" />
            <ellipse cx="20" cy="20" rx="18" ry="6" fill="none" stroke={accentSoft} strokeWidth="1" opacity="0.5" />
            <ellipse cx="20" cy="20" rx="6" ry="18" fill="none" stroke={accentSoft} strokeWidth="1" opacity="0.5" />
            <circle cx="20" cy="20" r="2" fill={acc} />
          </g>
        </g>
      );

    case "wrench":
      return (
        <g>
          {/* category grid 3x2 */}
          {Array.from({length: 6}).map((_, i) => {
            const col = i % 3, row = Math.floor(i / 3);
            return (
              <g key={i} transform={`translate(${40 + col*140}, ${60 + row*100})`}>
                <rect width="120" height="80" rx="10" fill="#0e1118" stroke={dim} />
                <rect x="14" y="14" width="24" height="24" rx="5" fill={acc} opacity={0.2 + i*0.05} />
                <rect x="14" y="50" width="80" height="5" rx="2" fill={text} />
                <rect x="14" y="62" width="50" height="4" rx="2" fill="#2a2d35" />
              </g>
            );
          })}
          {/* search bar */}
          <rect x="40" y="260" width="400" height="28" rx="6" fill="#0e1118" stroke={dim} />
          <circle cx="58" cy="274" r="5" fill="none" stroke={acc} strokeWidth="1.5" />
        </g>
      );

    case "wheel":
      return (
        <g>
          {/* car card */}
          <rect x="40" y="56" width="240" height="160" rx="10" fill="#0e1118" stroke={dim} />
          {/* car silhouette */}
          <g transform="translate(60, 90)" fill={acc}>
            <path d="M0 60 C0 50 10 30 30 30 L80 16 C100 16 130 30 150 30 C170 30 195 50 195 60 L195 80 L0 80 Z" opacity="0.85" />
            <circle cx="40" cy="80" r="14" fill="#0a0c12" />
            <circle cx="40" cy="80" r="8" fill={acc} />
            <circle cx="155" cy="80" r="14" fill="#0a0c12" />
            <circle cx="155" cy="80" r="8" fill={acc} />
          </g>
          {/* price */}
          <rect x="56" y="180" width="80" height="20" rx="4" fill="#0a0c12" />
          <rect x="64" y="187" width="50" height="6" rx="2" fill={accentSoft} />
          {/* sidebar filters */}
          <rect x="300" y="56" width="140" height="160" rx="10" fill="#0e1118" stroke={dim} />
          {[0,1,2,3].map(i => (
            <g key={i} transform={`translate(312, ${74 + i*32})`}>
              <rect width="14" height="14" rx="3" fill={i < 2 ? acc : dim} />
              <rect x="22" y="4" width="80" height="6" rx="2" fill={text} />
            </g>
          ))}
          <rect x="40" y="232" width="400" height="48" rx="8" fill="#0e1118" stroke={dim} />
          <rect x="56" y="248" width="180" height="16" rx="4" fill={acc} opacity="0.8" />
        </g>
      );

    case "mountain":
      return (
        <g>
          {/* sky */}
          <rect x="0" y="26" width="480" height="180" fill={`url(#glow-mountain)`} opacity="0.3" />
          {/* sun */}
          <circle cx="120" cy="120" r="28" fill={accentSoft} opacity="0.6" />
          {/* mountains */}
          <path d="M0 230 L80 130 L150 200 L220 110 L320 220 L400 150 L480 230 Z"
                fill="none" stroke={acc} strokeWidth="2" />
          <path d="M0 230 L80 130 L150 200 L220 110 L320 220 L400 150 L480 230 L480 280 L0 280 Z"
                fill={acc} opacity="0.15" />
          {/* tour info card */}
          <rect x="40" y="240" width="200" height="40" rx="8" fill="#0e1118" stroke={dim} />
          <rect x="56" y="252" width="60" height="6" rx="2" fill={accentSoft} />
          <rect x="56" y="266" width="120" height="5" rx="2" fill={text} />
        </g>
      );

    case "skyline":
      return (
        <g>
          {/* navy sky */}
          <rect x="0" y="26" width="480" height="220" fill="#0a1224" />
          {/* skyline silhouette */}
          <g fill={acc} opacity="0.55">
            <rect x="0" y="200" width="40" height="46" />
            <rect x="46" y="160" width="32" height="86" />
            <rect x="82" y="120" width="36" height="126" />
            <rect x="122" y="180" width="28" height="66" />
            <rect x="154" y="100" width="44" height="146" />
            <rect x="202" y="140" width="34" height="106" />
            <rect x="240" y="80" width="50" height="166" />
            <rect x="294" y="170" width="30" height="76" />
            <rect x="328" y="130" width="40" height="116" />
            <rect x="372" y="150" width="34" height="96" />
            <rect x="410" y="180" width="28" height="66" />
            <rect x="442" y="160" width="38" height="86" />
          </g>
          {/* window lights */}
          {Array.from({length: 30}).map((_, i) => (
            <rect key={i} x={20 + (i*32) % 460} y={120 + ((i*47) % 100)} width="2" height="2" fill={accentSoft} />
          ))}
          {/* booking widget */}
          <rect x="40" y="252" width="400" height="36" rx="8" fill="#0e1118" stroke={dim} />
          <rect x="56" y="264" width="60" height="12" rx="3" fill="#1a1d25" />
          <rect x="124" y="264" width="60" height="12" rx="3" fill="#1a1d25" />
          <rect x="192" y="264" width="60" height="12" rx="3" fill="#1a1d25" />
          <rect x="340" y="262" width="84" height="16" rx="4" fill={acc} opacity="0.9" />
        </g>
      );

    case "house":
      return (
        <g>
          {/* roof */}
          <path d="M240 60 L80 160 L400 160 Z" fill={acc} opacity="0.15" stroke={acc} strokeWidth="2" />
          {/* house body */}
          <rect x="120" y="160" width="240" height="100" fill="#0e1118" stroke={dim} />
          {/* door */}
          <rect x="210" y="200" width="60" height="60" rx="4" fill={acc} opacity="0.2" stroke={acc} strokeWidth="1.5" />
          <circle cx="260" cy="230" r="3" fill={acc} />
          {/* windows */}
          <rect x="140" y="180" width="44" height="34" rx="3" fill="#0a0c12" stroke={dim} />
          <line x1="162" y1="180" x2="162" y2="214" stroke={dim} />
          <line x1="140" y1="197" x2="184" y2="197" stroke={dim} />
          <rect x="296" y="180" width="44" height="34" rx="3" fill="#0a0c12" stroke={dim} />
          <line x1="318" y1="180" x2="318" y2="214" stroke={dim} />
          <line x1="296" y1="197" x2="340" y2="197" stroke={dim} />
          {/* service cards */}
          {[0,1,2].map(i => (
            <g key={i} transform={`translate(${60 + i*140}, 265)`}>
              <rect width="120" height="24" rx="5" fill="#0e1118" stroke={dim} />
              <circle cx="16" cy="12" r="5" fill={acc} opacity={0.4 + i*0.2} />
              <rect x="28" y="8" width="60" height="5" rx="2" fill={text} />
            </g>
          ))}
        </g>
      );

    default:
      return null;
  }
}

window.ThemePreview = ThemePreview;
