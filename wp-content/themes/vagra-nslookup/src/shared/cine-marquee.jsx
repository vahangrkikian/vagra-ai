/**
 * CineMarquee — infinite horizontal scroll of DNS record types/features.
 * Ported from page-cine-home.jsx → CineMarquee
 */

const ITEMS = [
  'A record',
  'AAAA record',
  'CNAME chain',
  'MX priority',
  'NS delegation',
  'TXT records',
  'SPF verify',
  'DKIM public key',
  'DMARC policy',
  'SOA serial',
  'PTR reverse',
  'CAA authorization',
  'SRV discovery',
  '30+ resolvers',
  '6 continents',
];

export default function CineMarquee() {
  return (
    <div className="cine-marquee">
      <div className="cine-marquee-track">
        {[...ITEMS, ...ITEMS].map((it, i) => (
          <span key={i} className="cine-marquee-item">
            {it}
          </span>
        ))}
      </div>
    </div>
  );
}
