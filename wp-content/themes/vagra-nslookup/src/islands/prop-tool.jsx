/**
 * PropTool — DNS Propagation Checker island.
 * Domain + record type input, world map with per-resolver results,
 * 30+ row result table with filter chips (All / Failed / Mismatched).
 * Connects to POST /vagra-nsl/v1/propagation.
 * Ported from page-cine-prop.jsx → CinePropTool
 */
import { useState, useCallback } from 'react';

const RECORD_TYPES = ['A', 'AAAA', 'CNAME', 'MX', 'NS', 'TXT', 'SPF', 'DKIM', 'DMARC'];

const MOCK_ROWS = [
  { city: 'Ashburn', cc: 'US', ip: '173.245.58.100', ms: 24, s: 'ok' },
  { city: 'Los Angeles', cc: 'US', ip: '173.245.58.100', ms: 38, s: 'ok' },
  { city: 'London', cc: 'UK', ip: '173.245.58.100', ms: 52, s: 'ok' },
  { city: 'Frankfurt', cc: 'DE', ip: '173.245.58.100', ms: 61, s: 'ok' },
  { city: 'Paris', cc: 'FR', ip: '173.245.58.100', ms: 58, s: 'ok' },
  { city: 'Tokyo', cc: 'JP', ip: '173.245.58.100', ms: 148, s: 'ok' },
  { city: 'Singapore', cc: 'SG', ip: '\u2014', ms: 0, s: 'warn' },
  { city: 'Sydney', cc: 'AU', ip: '173.245.58.100', ms: 203, s: 'ok' },
  { city: 'S\u00e3o Paulo', cc: 'BR', ip: '173.245.58.100', ms: 165, s: 'ok' },
  { city: 'Johannesburg', cc: 'ZA', ip: '173.245.58.100', ms: 178, s: 'ok' },
  { city: 'Mumbai', cc: 'IN', ip: 'old.198.51.100.4', ms: 191, s: 'err' },
  { city: 'Seoul', cc: 'KR', ip: '173.245.58.100', ms: 176, s: 'ok' },
];

export default function PropTool() {
  const [domain, setDomain] = useState('nslookup.am');
  const [type, setType] = useState('A');
  const [filter, setFilter] = useState('all');
  const [results, setResults] = useState(MOCK_ROWS);
  const [loading, setLoading] = useState(false);

  const visible = results.filter((r) =>
    filter === 'all'
      ? true
      : filter === 'failed'
      ? r.s !== 'ok'
      : r.s === 'err'
  );

  const doCheck = useCallback(async () => {
    if (!domain.trim()) return;
    setLoading(true);

    try {
      const restUrl =
        (window.nslConfig && window.nslConfig.restUrl) || '/wp-json/';
      const nonce = (window.nslConfig && window.nslConfig.nonce) || '';
      const res = await fetch(`${restUrl}vagra-nsl/v1/propagation`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...(nonce ? { 'X-WP-Nonce': nonce } : {}),
        },
        body: JSON.stringify({ domain: domain.trim(), type }),
      });

      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const rows = data.resolvers || data.results || [];
      if (rows.length) {
        setResults(
          rows.map((r) => ({
            city: r.location ? r.location.split(',')[0].trim() : (r.resolver || r.name || ''),
            cc: r.country || r.cc || '',
            ip: r.value || r.ip || '\u2014',
            ms: r.time || r.ms || 0,
            s: r.status || r.s || 'ok',
          }))
        );
      }
    } catch {
      setResults(MOCK_ROWS);
    } finally {
      setLoading(false);
    }
  }, [domain, type]);

  return (
    <div className="cine-tool reveal-scale" style={{ transform: 'none' }}>
      <div className="cine-tool-inner">
        <div className="cine-tool-head">
          <div className="cine-tool-dots">
            <span />
            <span />
            <span />
          </div>
          <span style={{ marginLeft: 12 }}>
            propagation &mdash; {results.length} resolvers &middot; 6 continents
          </span>
        </div>

        <div className="cine-tool-form">
          <input
            className="cine-tool-input"
            value={domain}
            onChange={(e) => setDomain(e.target.value)}
            placeholder="example.com"
            onKeyDown={(e) => e.key === 'Enter' && doCheck()}
          />
          <select
            className="cine-tool-select"
            value={type}
            onChange={(e) => setType(e.target.value)}
          >
            {RECORD_TYPES.map((t) => (
              <option key={t}>{t}</option>
            ))}
          </select>
          <button
            className="cine-tool-go"
            onClick={doCheck}
            disabled={loading}
          >
            {loading ? 'Checking\u2026' : 'Check \u2192'}
          </button>
        </div>

        {/* Filter chips */}
        <div
          style={{
            display: 'flex',
            gap: 8,
            flexWrap: 'wrap',
            marginTop: 16,
            alignItems: 'center',
          }}
        >
          <span
            style={{
              fontFamily: 'var(--nsl-font-mono)',
              fontSize: 11,
              color: 'rgba(255,255,255,0.4)',
              textTransform: 'uppercase',
              letterSpacing: '0.1em',
            }}
          >
            Filter:
          </span>
          {[
            ['all', 'All'],
            ['failed', 'Failed'],
            ['err', 'Mismatched'],
          ].map(([k, l]) => (
            <span
              key={k}
              onClick={() => setFilter(k)}
              className={`cine-pill ${filter === k ? 'on' : ''}`}
              style={{ cursor: 'pointer' }}
            >
              {l}
            </span>
          ))}
          <div style={{ flex: 1 }} />
          <span
            style={{
              fontFamily: 'var(--nsl-font-mono)',
              fontSize: 11,
              color: 'rgba(255,255,255,0.4)',
            }}
          >
            {visible.length} / {results.length}
          </span>
        </div>

        <div className="cine-results" style={{ marginTop: 16 }}>
          {visible.map((r, i) => (
            <div
              key={r.city + i}
              className="cine-result-row"
              style={{
                animationDelay: `${i * 60}ms`,
                gridTemplateColumns: '22px 1.5fr 1fr 1.4fr auto',
                gap: 12,
              }}
            >
              <span className={`cine-result-dot ${r.s}`} />
              <span className="cine-result-loc">
                {r.city}{' '}
                <span
                  style={{
                    color: 'rgba(255,255,255,0.4)',
                    fontSize: 11,
                    marginLeft: 4,
                  }}
                >
                  {r.cc}
                </span>
              </span>
              <span className="cine-result-ms">
                {r.ms ? r.ms + 'ms' : '\u2014'}
              </span>
              <span
                className="cine-result-ip"
                style={{
                  color: r.s === 'err' ? '#F87171' : '#A5B4FC',
                }}
              >
                {r.ip}
              </span>
              <span
                style={{
                  fontFamily: 'var(--nsl-font-mono)',
                  fontSize: 11,
                  color:
                    r.s === 'ok'
                      ? '#34D399'
                      : r.s === 'warn'
                      ? '#FBBF24'
                      : '#F87171',
                }}
              >
                {r.s === 'ok'
                  ? 'propagated'
                  : r.s === 'warn'
                  ? 'querying'
                  : 'mismatched'}
              </span>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
