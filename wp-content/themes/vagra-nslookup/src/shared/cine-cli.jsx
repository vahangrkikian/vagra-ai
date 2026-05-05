/**
 * CineCLI — terminal typing moment with green prompt, cyan answers, blinking cursor.
 * Ported from page-cine-home.jsx → CineStatement (CLI block)
 */

export default function CineCLI() {
  return (
    <div className="cine-cli reveal reveal-delay-2">
      <div className="cine-cli-line">
        <span className="cine-cli-prompt">$</span>
        <span>
          nslookup <span style={{ color: '#C7D2FE' }}>nslookup.am</span>{' '}
          +global
        </span>
        <span className="cine-cli-cursor" />
      </div>
      <div
        className="cine-cli-line cine-cli-meta"
        style={{ paddingLeft: 22 }}
      >
        ;; querying 30 resolvers across 6 continents&hellip;
      </div>
      <div className="cine-cli-line cine-cli-ans">
        &rarr; 28 resolvers returned 173.245.58.100 &middot; TTL 3600
      </div>
      <div className="cine-cli-line cine-cli-ans" style={{ color: '#FBBF24' }}>
        &rarr; 1 resolver still caching old value &middot; TTL 127
      </div>
      <div className="cine-cli-line cine-cli-ans" style={{ color: '#34D399' }}>
        &rarr; propagation complete in 00:04:12
      </div>
    </div>
  );
}
