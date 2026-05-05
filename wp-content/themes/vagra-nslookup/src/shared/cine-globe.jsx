/**
 * CineGlobe — animated SVG globe with rotating rings, arc connectors,
 * traveling dot particles, pulsing ping rings, active location cycling.
 * Ported from page-cine-home.jsx → CineGlobe
 */
import { useState, useEffect } from 'react';

const ROWS = [
  { loc: 'Ashburn', cc: 'US', ms: 24, s: 'ok' },
  { loc: 'London', cc: 'UK', ms: 52, s: 'ok' },
  { loc: 'Frankfurt', cc: 'DE', ms: 61, s: 'ok' },
  { loc: 'Tokyo', cc: 'JP', ms: 148, s: 'ok' },
  { loc: 'Mumbai', cc: 'IN', ms: 191, s: 'err' },
  { loc: 'Sydney', cc: 'AU', ms: 203, s: 'ok' },
];

const PTS = [
  { x: 280, y: 200, s: 'ok' },
  { x: 490, y: 170, s: 'ok' },
  { x: 510, y: 185, s: 'ok' },
  { x: 750, y: 210, s: 'ok' },
  { x: 650, y: 240, s: 'err' },
  { x: 790, y: 350, s: 'ok' },
];

function arc(p, from) {
  return `M ${from.x} ${from.y} Q ${(from.x + p.x) / 2} ${
    Math.min(from.y, p.y) - 80
  } ${p.x} ${p.y}`;
}

export default function CineGlobe() {
  const [active, setActive] = useState(1);
  useEffect(() => {
    const id = setInterval(
      () => setActive((a) => (a % (ROWS.length - 1)) + 1),
      1600
    );
    return () => clearInterval(id);
  }, []);

  return (
    <div className="cine-globe-wrap" style={{ marginTop: 64 }}>
      <div className="cine-globe reveal-scale">
        <svg viewBox="0 0 960 480" xmlns="http://www.w3.org/2000/svg">
          <defs>
            <radialGradient id="cine-glow" cx="50%" cy="50%" r="50%">
              <stop offset="0%" stopColor="#4F46E5" stopOpacity="0.6" />
              <stop offset="70%" stopColor="#4F46E5" stopOpacity="0.05" />
              <stop offset="100%" stopColor="#4F46E5" stopOpacity="0" />
            </radialGradient>
            <radialGradient id="cine-glow-active" cx="50%" cy="50%" r="50%">
              <stop offset="0%" stopColor="#67E8F9" stopOpacity="0.85" />
              <stop offset="60%" stopColor="#67E8F9" stopOpacity="0.08" />
              <stop offset="100%" stopColor="#67E8F9" stopOpacity="0" />
            </radialGradient>
            <linearGradient id="cine-line" x1="0" x2="1">
              <stop offset="0%" stopColor="#A5B4FC" stopOpacity="0" />
              <stop offset="50%" stopColor="#A5B4FC" stopOpacity="0.9" />
              <stop offset="100%" stopColor="#67E8F9" stopOpacity="0" />
            </linearGradient>
            <linearGradient id="cine-line-active" x1="0" x2="1">
              <stop offset="0%" stopColor="#67E8F9" stopOpacity="0" />
              <stop offset="50%" stopColor="#67E8F9" stopOpacity="1" />
              <stop offset="100%" stopColor="#A5B4FC" stopOpacity="0" />
            </linearGradient>
            <linearGradient
              id="cine-meridian"
              x1="0"
              y1="0"
              x2="0"
              y2="1"
            >
              <stop offset="0%" stopColor="#67E8F9" stopOpacity="0" />
              <stop offset="50%" stopColor="#67E8F9" stopOpacity="0.4" />
              <stop offset="100%" stopColor="#67E8F9" stopOpacity="0" />
            </linearGradient>
          </defs>

          {/* rotating globe ring */}
          <g
            style={{
              transformOrigin: '480px 240px',
              animation: 'cine-spin 40s linear infinite',
            }}
          >
            <ellipse
              cx="480"
              cy="240"
              rx="420"
              ry="120"
              fill="none"
              stroke="rgba(255,255,255,0.06)"
              strokeWidth="1"
            />
            <ellipse
              cx="480"
              cy="240"
              rx="420"
              ry="60"
              fill="none"
              stroke="rgba(255,255,255,0.04)"
              strokeWidth="1"
            />
            <ellipse
              cx="480"
              cy="240"
              rx="420"
              ry="180"
              fill="none"
              stroke="rgba(255,255,255,0.03)"
              strokeWidth="1"
            />
          </g>

          {/* meridian sweep */}
          <rect x="0" y="40" width="2" height="400" fill="url(#cine-meridian)">
            <animate
              attributeName="x"
              values="40;920;40"
              dur="9s"
              repeatCount="indefinite"
            />
          </rect>

          {/* dot grid world */}
          {Array.from({ length: 60 }).map((_, i) =>
            Array.from({ length: 20 }).map((__, j) => {
              const x = 40 + i * (880 / 40);
              const y = 40 + j * (400 / 20);
              const n =
                Math.sin(x * 0.03) * Math.cos(y * 0.04) +
                Math.sin(x * 0.07 + y * 0.02);
              if (n < -0.15) return null;
              return (
                <circle
                  key={`${i}-${j}`}
                  cx={x}
                  cy={y}
                  r="1.5"
                  fill="rgba(255,255,255,0.1)"
                />
              );
            })
          )}

          {/* concentric ring pulses from origin */}
          {[0, 1.2, 2.4].map((d, i) => (
            <circle
              key={i}
              cx={PTS[0].x}
              cy={PTS[0].y}
              r="0"
              fill="none"
              stroke="#67E8F9"
              strokeOpacity="0.4"
              strokeWidth="1.5"
            >
              <animate
                attributeName="r"
                values="0;180"
                dur="3.6s"
                begin={`${d}s`}
                repeatCount="indefinite"
              />
              <animate
                attributeName="opacity"
                values="0.6;0"
                dur="3.6s"
                begin={`${d}s`}
                repeatCount="indefinite"
              />
            </circle>
          ))}

          {/* arc connectors */}
          {PTS.slice(1).map((p, i) => {
            const d = arc(p, PTS[0]);
            const isActive = i + 1 === active;
            return (
              <g key={`arc-${i}`}>
                <path
                  d={d}
                  fill="none"
                  stroke={
                    isActive ? 'url(#cine-line-active)' : 'url(#cine-line)'
                  }
                  strokeWidth={isActive ? 2.4 : 1.2}
                  opacity={isActive ? 1 : 0.5}
                  style={{
                    transition: 'opacity 600ms, stroke-width 600ms',
                  }}
                  className="cine-connector"
                />
                <circle
                  r={isActive ? 3.5 : 2}
                  fill={isActive ? '#67E8F9' : '#A5B4FC'}
                >
                  <animateMotion
                    dur={`${isActive ? 1.4 : 2.6}s`}
                    repeatCount="indefinite"
                    path={d}
                  />
                  <animate
                    attributeName="opacity"
                    values="0;1;1;0"
                    dur={`${isActive ? 1.4 : 2.6}s`}
                    repeatCount="indefinite"
                  />
                </circle>
              </g>
            );
          })}

          {/* points */}
          {PTS.map((p, i) => {
            const isActive = i === active;
            const isOrigin = i === 0;
            return (
              <g key={i} transform={`translate(${p.x} ${p.y})`}>
                <circle
                  r="30"
                  fill={
                    isActive
                      ? 'url(#cine-glow-active)'
                      : 'url(#cine-glow)'
                  }
                >
                  <animate
                    attributeName="r"
                    values="10;36;10"
                    dur="3s"
                    begin={`${i * 0.25}s`}
                    repeatCount="indefinite"
                  />
                  <animate
                    attributeName="opacity"
                    values="0.9;0;0.9"
                    dur="3s"
                    begin={`${i * 0.25}s`}
                    repeatCount="indefinite"
                  />
                </circle>
                {isOrigin && (
                  <circle
                    r="10"
                    fill="none"
                    stroke="#67E8F9"
                    strokeWidth="1"
                    opacity="0.6"
                  >
                    <animate
                      attributeName="r"
                      values="6;14;6"
                      dur="2.4s"
                      repeatCount="indefinite"
                    />
                  </circle>
                )}
                <circle
                  r={isActive ? 6 : 4}
                  fill={p.s === 'ok' ? '#34D399' : '#F87171'}
                  stroke="#fff"
                  strokeWidth="1.5"
                  style={{ transition: 'r 400ms' }}
                />
                {isActive && (
                  <text
                    y="-14"
                    textAnchor="middle"
                    fontFamily="var(--nsl-font-mono)"
                    fontSize="11"
                    fill="#E0F2FE"
                    fontWeight="500"
                  >
                    {ROWS[i].loc.toUpperCase()}
                  </text>
                )}
              </g>
            );
          })}
        </svg>
        <style>{`@keyframes cine-spin { to { transform: rotate(360deg); } }`}</style>
      </div>

      <div className="cine-globe-list">
        {ROWS.map((r, i) => {
          const isActive = i === active;
          return (
            <div
              key={r.loc}
              className="cine-globe-row reveal"
              style={{
                transitionDelay: `${60 * i}ms`,
                background: isActive
                  ? 'rgba(103,232,249,0.08)'
                  : 'transparent',
                borderColor: isActive
                  ? 'rgba(103,232,249,0.35)'
                  : 'rgba(255,255,255,0.06)',
                transform: isActive ? 'translateX(4px)' : 'translateX(0)',
                transition:
                  'background 300ms, border-color 300ms, transform 300ms',
              }}
            >
              <span className={`cine-result-dot ${r.s}`} />
              <div>
                <div className="loc">
                  {r.loc}
                  <span
                    className="mono"
                    style={{
                      fontSize: 12,
                      color: 'rgba(255,255,255,0.4)',
                      marginLeft: 6,
                    }}
                  >
                    {r.cc}
                  </span>
                </div>
              </div>
              <span
                className="mono"
                style={{ color: isActive ? '#67E8F9' : undefined }}
              >
                {isActive
                  ? 'querying\u2026'
                  : r.s === 'ok'
                  ? 'propagated'
                  : 'mismatched'}
              </span>
              <span className="ms">{r.ms}ms</span>
            </div>
          );
        })}
      </div>
    </div>
  );
}
