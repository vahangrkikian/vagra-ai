/**
 * WorldMap — SVG dot-grid world map with animated resolver pings.
 * Ported from shared/components.jsx → WorldMap
 */
import { useMemo } from 'react';

function fract(x) {
  return x - Math.floor(x);
}

function generateLandDots() {
  const regions = [
    [90, 260, 60, 200, 0.55],   // North America
    [140, 240, 170, 230, 0.45],
    [180, 230, 210, 260, 0.7],   // Central America
    [230, 330, 240, 380, 0.65],  // South America
    [330, 400, 50, 110, 0.45],   // Greenland
    [430, 540, 80, 160, 0.7],    // Europe
    [450, 560, 170, 340, 0.6],   // Africa
    [540, 620, 130, 210, 0.55],  // Middle East
    [540, 820, 60, 140, 0.5],    // Russia
    [620, 700, 170, 240, 0.6],   // India
    [700, 790, 200, 260, 0.55],  // SE Asia
    [700, 820, 120, 200, 0.55],  // China / E Asia
    [820, 860, 140, 190, 0.7],   // Japan
    [760, 880, 290, 350, 0.6],   // Australia
    [880, 910, 330, 360, 0.8],   // NZ
  ];
  const pts = [];
  const step = 12;
  for (const [x0, x1, y0, y1, d] of regions) {
    for (let x = x0; x <= x1; x += step) {
      for (let y = y0; y <= y1; y += step) {
        const jx = x + Math.sin(x * 0.3 + y * 0.11) * 3;
        const jy = y + Math.cos(x * 0.19 + y * 0.27) * 3;
        const n = fract(Math.sin(x * 12.9898 + y * 78.233) * 43758.5453);
        if (n < d) pts.push([jx, jy]);
      }
    }
  }
  return pts;
}

export default function WorldMap({ resolvers = [] }) {
  const dots = useMemo(() => generateLandDots(), []);
  return (
    <svg
      viewBox="0 0 960 420"
      className="nsl-map"
      xmlns="http://www.w3.org/2000/svg"
      aria-hidden
    >
      <defs>
        <radialGradient id="nsl-ping" cx="50%" cy="50%" r="50%">
          <stop offset="0%" stopColor="#4F46E5" stopOpacity="0.55" />
          <stop offset="60%" stopColor="#4F46E5" stopOpacity="0.08" />
          <stop offset="100%" stopColor="#4F46E5" stopOpacity="0" />
        </radialGradient>
        <linearGradient id="nsl-arc" x1="0" x2="1">
          <stop offset="0%" stopColor="#0EA5C4" stopOpacity="0" />
          <stop offset="50%" stopColor="#0EA5C4" stopOpacity="0.7" />
          <stop offset="100%" stopColor="#4F46E5" stopOpacity="0" />
        </linearGradient>
      </defs>

      {dots.map(([x, y], i) => (
        <circle key={i} cx={x} cy={y} r="1.6" fill="#D5DBE5" />
      ))}

      {resolvers.filter(Boolean).map((r, i) => (
        <g key={i} transform={`translate(${r.x} ${r.y})`}>
          <circle r="28" fill="url(#nsl-ping)">
            <animate
              attributeName="r"
              values="10;32;10"
              dur="2.6s"
              begin={`${i * 0.18}s`}
              repeatCount="indefinite"
            />
            <animate
              attributeName="opacity"
              values="0.9;0;0.9"
              dur="2.6s"
              begin={`${i * 0.18}s`}
              repeatCount="indefinite"
            />
          </circle>
          <circle
            r="4"
            fill={
              r.status === 'ok'
                ? '#12A85C'
                : r.status === 'warn'
                ? '#E89B0A'
                : '#4F46E5'
            }
            stroke="#fff"
            strokeWidth="1.5"
          />
        </g>
      ))}
    </svg>
  );
}
