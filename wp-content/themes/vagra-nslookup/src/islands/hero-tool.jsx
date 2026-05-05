/**
 * HeroTool — homepage DNS tool panel.
 * 13 record type pills, domain input, resolver dropdown, Check DNS button,
 * live result table with status dots, embedded WorldMap.
 * Connects to POST /vagra-nsl/v1/lookup API.
 * Ported from shared/components.jsx → HeroTool
 */
import { useState, useEffect, useCallback } from 'react';
import WorldMap from '../shared/world-map.jsx';

const RECORD_TYPES = [
  'A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT',
  'SPF', 'DKIM', 'DMARC', 'SOA', 'PTR', 'CAA', 'SRV',
];

const SISTER_LINKS = {
  SPF: '/tools/',
  DKIM: '/tools/',
  DMARC: '/tools/',
};

const RESOLVERS_SELECT = [
  { value: 'auth', label: 'Authoritative' },
  { value: 'google', label: 'Google \u00b7 8.8.8.8' },
  { value: 'cloudflare', label: 'Cloudflare \u00b7 1.1.1.1' },
  { value: 'quad9', label: 'Quad9 \u00b7 9.9.9.9' },
  { value: 'opendns', label: 'OpenDNS \u00b7 208.67.222.222' },
];

export default function HeroTool() {
  const [domain, setDomain] = useState('nslookup.am');
  const [type, setType] = useState('A');
  const [resolver, setResolver] = useState('auth');
  const [results, setResults] = useState([]);
  const [loading, setLoading] = useState(false);
  const [error, setError] = useState(null);

  // Map results to resolver positions for WorldMap
  const mapResolvers = results
    .filter((r) => r.x !== undefined)
    .map((r) => ({
      x: r.x,
      y: r.y,
      status: r.status || 'ok',
    }));

  const okCount = results.filter((r) => r.status === 'ok').length;

  const doLookup = useCallback(async () => {
    if (!domain.trim()) return;
    setLoading(true);
    setError(null);
    setResults([]);

    try {
      const restUrl =
        (window.nslConfig && window.nslConfig.restUrl) || '/wp-json/';
      const nonce = (window.nslConfig && window.nslConfig.nonce) || '';
      const res = await fetch(`${restUrl}vagra-nsl/v1/lookup`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...(nonce ? { 'X-WP-Nonce': nonce } : {}),
        },
        body: JSON.stringify({ domain: domain.trim(), type, resolver }),
      });

      if (!res.ok) {
        throw new Error(`HTTP ${res.status}`);
      }

      const data = await res.json();
      const records = data.records || data.results || [];
      // Map API records to display format
      setResults(
        records.length
          ? records.map((r, i) => ({
              name: r.value || '',
              loc: data.resolver || 'Authoritative',
              ip: r.value || '',
              ms: r.time || 0,
              status: r.status || 'ok',
              x: MOCK_RESULTS[i % MOCK_RESULTS.length]?.x,
              y: MOCK_RESULTS[i % MOCK_RESULTS.length]?.y,
            }))
          : []
      );
    } catch (err) {
      setError(err.message);
      // Show mock data on error so the UI is always populated
      setResults(MOCK_RESULTS);
    } finally {
      setLoading(false);
    }
  }, [domain, type, resolver]);

  // Auto-run a demo lookup on mount
  useEffect(() => {
    // Use mock data for initial display
    const timer = setTimeout(() => {
      setResults(MOCK_RESULTS.slice(0, 4));
      let i = 4;
      const interval = setInterval(() => {
        if (i >= MOCK_RESULTS.length) {
          clearInterval(interval);
          return;
        }
        setResults((prev) => [...prev, MOCK_RESULTS[i]]);
        i++;
      }, 480);
    }, 300);
    return () => clearTimeout(timer);
  }, []);

  return (
    <div className="nsl-tool card card-elev" id="tool">
      <div className="nsl-tool-head">
        <div className="nsl-tool-pills">
          {RECORD_TYPES.map((t) => {
            const sister = SISTER_LINKS[t];
            return (
              <button
                key={t}
                className={`nsl-pill ${type === t ? 'nsl-pill-on' : ''}`}
                onClick={() => {
                  if (sister && type !== t) {
                    // Still select it; the link is informational
                  }
                  setType(t);
                }}
              >
                {t}
              </button>
            );
          })}
        </div>
      </div>

      <div className="nsl-tool-search">
        <input
          className="input input-lg"
          value={domain}
          onChange={(e) => setDomain(e.target.value)}
          placeholder="nslookup.am"
          style={{ flex: 2 }}
          onKeyDown={(e) => e.key === 'Enter' && doLookup()}
        />
        <select
          className="input input-lg select"
          style={{ flex: 1, minWidth: 160 }}
          value={resolver}
          onChange={(e) => setResolver(e.target.value)}
        >
          {RESOLVERS_SELECT.map((r) => (
            <option key={r.value} value={r.value}>
              {r.label}
            </option>
          ))}
        </select>
        <button
          className="btn btn-primary btn-lg"
          onClick={doLookup}
          disabled={loading}
        >
          <svg
            width="16"
            height="16"
            viewBox="0 0 16 16"
            fill="none"
          >
            <path
              d="M2 8h10m-4-4l4 4-4 4"
              stroke="currentColor"
              strokeWidth="1.8"
              strokeLinecap="round"
              strokeLinejoin="round"
            />
          </svg>
          {loading ? 'Checking\u2026' : 'Check DNS'}
        </button>
      </div>

      <div className="nsl-tool-body">
        <div className="nsl-map-wrap">
          <WorldMap resolvers={mapResolvers} />
          <div className="nsl-map-legend">
            <span className="badge badge-mono">{type}</span>
            <span
              style={{
                fontFamily: 'var(--nsl-font-mono)',
                fontSize: 13,
                color: 'var(--nsl-muted)',
              }}
            >
              {domain}
            </span>
            <span style={{ flex: 1 }} />
            <span className="nsl-stat">
              <span className="dot dot-ok" />
              {okCount}/{results.length || 30} resolved
            </span>
          </div>
        </div>

        <div className="nsl-tool-list">
          {error && (
            <div
              className="nsl-row"
              style={{ color: '#F87171', fontSize: 13 }}
            >
              API unavailable &mdash; showing demo data
            </div>
          )}
          {results
            .filter(Boolean)
            .slice()
            .reverse()
            .slice(0, 5)
            .map((r, i) => (
              <div key={(r.name || r.loc) + i} className="nsl-row">
                <span
                  className={`dot dot-${
                    r.status === 'ok'
                      ? 'ok'
                      : r.status === 'warn'
                      ? 'warn'
                      : 'loading'
                  }`}
                />
                <span className="nsl-row-loc">{r.loc}</span>
                <span className="nsl-row-ip mono">{r.ip}</span>
                <span className="nsl-row-ms mono">
                  {r.ms ? `${r.ms}ms` : '\u2014'}
                </span>
              </div>
            ))}
          {loading && (
            <div className="nsl-row nsl-row-loading">
              <span className="dot dot-loading" />
              <span className="nsl-row-loc">
                Querying remaining resolvers&hellip;
              </span>
            </div>
          )}
        </div>
      </div>
    </div>
  );
}

const MOCK_RESULTS = [
  {
    name: 'Google (US-E)',
    loc: 'Ashburn, US',
    x: 215,
    y: 150,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 24,
  },
  {
    name: 'Cloudflare (US-W)',
    loc: 'Los Angeles, US',
    x: 120,
    y: 175,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 38,
  },
  {
    name: 'Quad9 (EU)',
    loc: 'Frankfurt, DE',
    x: 490,
    y: 125,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 18,
  },
  {
    name: 'OpenDNS (EU)',
    loc: 'London, UK',
    x: 455,
    y: 110,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 22,
  },
  {
    name: 'NextDNS (APAC)',
    loc: 'Tokyo, JP',
    x: 840,
    y: 160,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 46,
  },
  {
    name: 'AliDNS (APAC)',
    loc: 'Singapore, SG',
    x: 760,
    y: 240,
    status: 'warn',
    ip: '\u2014',
    ms: 0,
  },
  {
    name: 'DNS.SB (AU)',
    loc: 'Sydney, AU',
    x: 850,
    y: 320,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 58,
  },
  {
    name: 'LibreDNS (SA)',
    loc: 'S\u00e3o Paulo, BR',
    x: 310,
    y: 310,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 72,
  },
  {
    name: 'Cloudflare (AF)',
    loc: 'Johannesburg, ZA',
    x: 530,
    y: 310,
    status: 'ok',
    ip: '142.250.80.46',
    ms: 64,
  },
];
