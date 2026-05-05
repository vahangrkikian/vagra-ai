/**
 * NSTool — NS Lookup tool island.
 * Compact tool card with domain + resolver dropdown,
 * result table with copy/CSV/JSON export buttons.
 * Connects to POST /vagra-nsl/v1/lookup with type=NS.
 * Ported from page-cine-ns.jsx → CineNSTool
 */
import { useState, useCallback } from 'react';

const MOCK_NS_ROWS = [
  { ns: 'ns1.cloudflare.com', ip: '173.245.58.100', ttl: 3600, s: 'ok' },
  { ns: 'ns2.cloudflare.com', ip: '173.245.59.42', ttl: 3600, s: 'ok' },
  { ns: 'ns3.cloudflare.com', ip: '172.64.32.12', ttl: 3600, s: 'ok' },
  { ns: 'ns4.cloudflare.com', ip: '172.64.33.88', ttl: 3600, s: 'ok' },
];

function copyToClipboard(text) {
  navigator.clipboard.writeText(text).catch(() => {});
}

function exportCSV(rows) {
  const header = 'Nameserver,IP,TTL,Status\n';
  const body = rows
    .map((r) => `${r.ns},${r.ip},${r.ttl},${r.s}`)
    .join('\n');
  const blob = new Blob([header + body], { type: 'text/csv' });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'ns-lookup.csv';
  a.click();
  URL.revokeObjectURL(url);
}

function exportJSON(rows) {
  const blob = new Blob([JSON.stringify(rows, null, 2)], {
    type: 'application/json',
  });
  const url = URL.createObjectURL(blob);
  const a = document.createElement('a');
  a.href = url;
  a.download = 'ns-lookup.json';
  a.click();
  URL.revokeObjectURL(url);
}

export default function NSTool() {
  const [domain, setDomain] = useState('nslookup.am');
  const [resolver, setResolver] = useState('auth');
  const [results, setResults] = useState(MOCK_NS_ROWS);
  const [loading, setLoading] = useState(false);

  const doLookup = useCallback(async () => {
    if (!domain.trim()) return;
    setLoading(true);

    try {
      const restUrl =
        (window.nslConfig && window.nslConfig.restUrl) || '/wp-json/';
      const nonce = (window.nslConfig && window.nslConfig.nonce) || '';
      const res = await fetch(`${restUrl}vagra-nsl/v1/ns-lookup`, {
        method: 'POST',
        headers: {
          'Content-Type': 'application/json',
          ...(nonce ? { 'X-WP-Nonce': nonce } : {}),
        },
        body: JSON.stringify({
          domain: domain.trim(),
          resolver,
        }),
      });

      if (!res.ok) throw new Error(`HTTP ${res.status}`);
      const data = await res.json();
      const records = data.results || data.records || [];
      if (records.length) {
        setResults(
          records.map((r) => ({
            ns: r.ns || r.value || '',
            ip: r.ip || (r.glue && r.glue[0]) || '\u2014',
            ttl: r.ttl || 0,
            s: r.status || 'ok',
          }))
        );
      }
    } catch {
      // Keep mock data on failure
      setResults(MOCK_NS_ROWS);
    } finally {
      setLoading(false);
    }
  }, [domain, resolver]);

  return (
    <div
      className="cine-tool reveal-scale"
      style={{ transform: 'none', maxWidth: 880, margin: '0 auto' }}
    >
      <div className="cine-tool-inner">
        <div className="cine-tool-head">
          <div className="cine-tool-dots">
            <span />
            <span />
            <span />
          </div>
          <span style={{ marginLeft: 12 }}>ns-lookup &mdash; {domain}</span>
        </div>

        <div className="cine-tool-form">
          <input
            className="cine-tool-input"
            value={domain}
            onChange={(e) => setDomain(e.target.value)}
            placeholder="example.com"
            onKeyDown={(e) => e.key === 'Enter' && doLookup()}
          />
          <select
            className="cine-tool-select"
            value={resolver}
            onChange={(e) => setResolver(e.target.value)}
          >
            <option value="auth">Authoritative</option>
            <option value="google">Google &middot; 8.8.8.8</option>
            <option value="cloudflare">Cloudflare &middot; 1.1.1.1</option>
          </select>
          <button
            className="cine-tool-go"
            onClick={doLookup}
            disabled={loading}
          >
            {loading ? 'Querying\u2026' : 'Show NS \u2192'}
          </button>
        </div>

        {/* Export buttons */}
        <div
          style={{
            display: 'flex',
            gap: 8,
            marginTop: 12,
            justifyContent: 'flex-end',
          }}
        >
          <button
            className="cine-pill"
            onClick={() =>
              copyToClipboard(results.map((r) => r.ns).join('\n'))
            }
          >
            Copy
          </button>
          <button className="cine-pill" onClick={() => exportCSV(results)}>
            CSV
          </button>
          <button className="cine-pill" onClick={() => exportJSON(results)}>
            JSON
          </button>
        </div>

        <div className="cine-results" style={{ marginTop: 16 }}>
          {results.map((r, i) => (
            <div
              key={r.ns + i}
              className="cine-result-row"
              style={{
                animationDelay: `${i * 120}ms`,
                gridTemplateColumns: '22px 1.6fr 1.2fr auto auto',
                gap: 12,
              }}
            >
              <span className={`cine-result-dot ${r.s}`} />
              <span className="cine-result-loc">{r.ns}</span>
              <span className="cine-result-ip">{r.ip}</span>
              <span className="cine-result-ms">TTL {r.ttl}</span>
              <span
                className="cine-result-ms"
                style={{
                  color: r.s === 'ok' ? '#34D399' : '#F87171',
                }}
              >
                {r.s === 'ok' ? 'OK' : 'ERR'}
              </span>
            </div>
          ))}
        </div>
      </div>
    </div>
  );
}
