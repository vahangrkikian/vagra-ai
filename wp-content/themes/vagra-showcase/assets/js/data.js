/* Themes data + abstract preview SVG generator
   No fake screenshots — each theme gets a stylized abstract panel
   colored to its brand. */

const THEMES = [
  {
    id: "msp",
    name: "Vagra MSP",
    niche: "Cybersecurity",
    category: "business",
    accent: "#3366FF",
    accentSoft: "#5C82FF",
    tagline: "Security services that sell themselves.",
    ai: "Security Advisor",
    url: "http://msp.vagraai.local/",
    persona: { initials: "SN", name: "ShieldNet MSP", role: "Security advisor • shieldnet.com" },
    preview: "shield",
    chat: [
      { from: "ai", text: "Hi — I'm ShieldNet. What can I help secure today?" },
      { from: "user", text: "What's DMARC and do we need it?" },
      { from: "ai", text: "DMARC tells receiving mail servers what to do with messages that fail SPF or DKIM checks — quarantine or reject. If your domain sends business email, yes, you need it. Want me to grab a free DMARC audit for your domain?" },
    ],
  },
  {
    id: "legal",
    name: "Vagra Legal",
    niche: "Law Firm",
    category: "business",
    accent: "#C9A84C",
    accentSoft: "#E3C66B",
    tagline: "Quiet authority. Modern intake.",
    ai: "Intake Assistant",
    url: "http://legal.vagraai.local/",
    elementor: true,
    persona: { initials: "MA", name: "Morrison & Associates", role: "Intake assistant • not legal advice" },
    preview: "scales",
    chat: [
      { from: "ai", text: "Welcome to Morrison & Associates. I can help schedule a consult — I can't give legal advice. What brings you in?" },
      { from: "user", text: "Rear-ended in a parking lot last week." },
      { from: "ai", text: "Sorry to hear that. Personal injury is one of our practice areas. A few quick details and I'll book you with a partner this week — what's your name and the city of the incident?" },
    ],
  },
  {
    id: "nslookup",
    name: "Vagra NSLookup",
    niche: "DNS Tools",
    category: "tools",
    accent: "#4F46E5",
    accentSoft: "#7C72F0",
    tagline: "DNS, demystified.",
    ai: "DNS Expert",
    url: "http://nslookup.vagraai.local/",
    elementor: true,
    persona: { initials: "NS", name: "nslookup.am", role: "DNS expert • 13 record types" },
    preview: "globe",
    chat: [
      { from: "ai", text: "Hey — what domain are we inspecting?" },
      { from: "user", text: "Why won't my MX records propagate?" },
      { from: "ai", text: "Three usual suspects: (1) TTL on the previous record hasn't expired, (2) recursive resolvers cache aggressively, (3) registrar nameservers were updated but not all glue records. Drop the domain and I'll pull current state across 20 resolvers." },
    ],
  },
  {
    id: "carvice",
    name: "Carvice",
    niche: "Car Service",
    category: "automotive",
    accent: "#1a73e8",
    accentSoft: "#5295f5",
    tagline: "The auto-repair marketplace.",
    ai: "Auto Advisor",
    url: "http://carvice.vagraai.local/",
    persona: { initials: "CV", name: "Carvice", role: "Auto advisor • EN · RU · HY" },
    preview: "wrench",
    chat: [
      { from: "ai", text: "What's the car doing — or not doing?" },
      { from: "user", text: "Squeals when I brake in the morning." },
      { from: "ai", text: "Could be rotor surface rust burning off (normal first stop) or pad wear indicators. I'd start with chassis & brakes specialists. Three top-rated within 5 km of Yerevan — want me to show availability for tomorrow?" },
    ],
  },
  {
    id: "driveease",
    name: "DriveEase",
    niche: "Car Rental",
    category: "automotive",
    accent: "#10B981",
    accentSoft: "#34D399",
    tagline: "Rentals without the counter.",
    ai: "Rental Agent",
    url: "http://driveease.vagraai.local/",
    persona: { initials: "DE", name: "DriveEase", role: "Rental agent • online check-in" },
    preview: "wheel",
    chat: [
      { from: "ai", text: "Where are you picking up, and when?" },
      { from: "user", text: "Yerevan airport, this Friday for 5 days." },
      { from: "ai", text: "Got it. 14 cars available — 4 under €30/day. Most popular for your dates: Renault Clio (€26), Skoda Octavia (€38). Want me to hold one while you decide?" },
    ],
  },
  {
    id: "tourvice",
    name: "TourVice",
    niche: "Tourism",
    category: "hospitality",
    accent: "#B8612A",
    accentSoft: "#D78657",
    tagline: "Armenia, on its own terms.",
    ai: "Travel Guide",
    url: "http://tourvice.vagraai.local/",
    persona: { initials: "TV", name: "TourVice", role: "Travel guide • Armenia" },
    preview: "mountain",
    chat: [
      { from: "ai", text: "First time in Armenia, or coming back?" },
      { from: "user", text: "First time, 8 days, no rental car." },
      { from: "ai", text: "Then I'd skip the long drives. Our 8-day 'Stone & Wine' tour: Yerevan base, day trips to Garni, Geghard, Khor Virap, and a vineyard overnight in Areni. Private driver included. Want the itinerary?" },
    ],
  },
  {
    id: "meridian",
    name: "Meridian",
    niche: "Hotel",
    category: "hospitality",
    accent: "#d4af37",
    accentSoft: "#e8c862",
    tagline: "The five-star booking experience.",
    ai: "Hotel Concierge",
    url: "http://meridian.vagraai.local/",
    persona: { initials: "MR", name: "The Meridian", role: "Concierge • 5★ • Manhattan" },
    preview: "skyline",
    chat: [
      { from: "ai", text: "Welcome to The Meridian. Looking for a room, dining, or local recommendations?" },
      { from: "user", text: "King room with a view, this weekend?" },
      { from: "ai", text: "Two options for Fri–Sun: Deluxe Panorama King ($489/night, north-facing skyline) and Executive Studio King ($545, corner suite, river view). Both include breakfast. Shall I hold the Panorama?" },
    ],
  },
  {
    id: "houseservice",
    name: "House Service",
    niche: "Home Services",
    category: "services",
    accent: "#2563eb",
    accentSoft: "#60a5fa",
    tagline: "Trusted pros at your doorstep.",
    ai: "Service Advisor",
    url: "http://houseservice.vagraai.local/",
    persona: { initials: "HS", name: "House Service", role: "Service advisor • quotes in 60s" },
    preview: "house",
    chat: [
      { from: "ai", text: "What do you need help with around the house?" },
      { from: "user", text: "Kitchen faucet is leaking, getting worse." },
      { from: "ai", text: "Plumbing — got it. I have 3 licensed plumbers available this week in your area. PipeWorks Pro has a 4.9★ rating and can come tomorrow morning. Want me to request a quote?" },
    ],
  },
];

const CATEGORIES = [
  { id: "all", label: "All themes" },
  { id: "business", label: "Business" },
  { id: "tools", label: "Tools" },
  { id: "automotive", label: "Automotive" },
  { id: "hospitality", label: "Hospitality" },
  { id: "services", label: "Services" },
];

const TESTIMONIALS = [
  {
    quote: "We replaced three plugins and a chatbot subscription with one Vagra MSP install. Intake form fills are up 40% because the chat actually answers technical questions before the form.",
    name: "Devon Hart",
    role: "MD, Wirestack MSP",
    initials: "DH",
  },
  {
    quote: "I've shipped law-firm sites for fifteen years. This is the first theme where the AI doesn't embarrass me. It captures intake and gracefully refuses to give legal advice — which is exactly what a junior paralegal does.",
    name: "Priya Anand",
    role: "Independent web consultant",
    initials: "PA",
  },
  {
    quote: "Meridian shipped our booking flow in a weekend. PageSpeed 96 on mobile. The concierge upsells suite categories better than our front desk does at 2am.",
    name: "Marcus Kohl",
    role: "GM, Hotel Trentwood",
    initials: "MK",
  },
];

const FAQ = [
  {
    q: "Is this really free?",
    a: "Yes. All eight core themes are GPL-2.0 and published on WordPress.org at no cost. Pro features — extended template packs, white-label, priority support — are optional add-ons.",
  },
  {
    q: "Do I need an API key for the AI chat?",
    a: "Yes. You bring your own Anthropic key. We never proxy your traffic, never see your conversations, and never store messages server-side. Cost and data stay yours.",
  },
  {
    q: "Can I use these on client sites?",
    a: "Absolutely. GPL gives you unlimited use. The Agency plan adds white-label support and removes the small attribution line in the footer.",
  },
  {
    q: "How is this different from starter templates?",
    a: "Starter templates are skins on a single generic theme. Each vagra.ai theme is a separate build with industry-specific custom post types, booking flows, and an AI persona trained for that vertical. Cybersecurity sites get DMARC explainers. Hotels get a booking wizard. Different code, not different stylesheets.",
  },
  {
    q: "What about updates and support?",
    a: "Free themes get updates via WordPress.org on the standard cadence. Pro subscribers get priority support with a guaranteed 24-hour first response and access to release candidates one cycle early.",
  },
  {
    q: "Does it work with [page builder]?",
    a: "All themes are FSE-first and use core block patterns. Elementor, Bricks, and Beaver Builder will render — but you'll lose the niche-specific blocks that make each theme worth installing.",
  },
];

const STEPS = [
  {
    label: "Install",
    title: "Install free from WordPress.org",
    body: "Each theme is GPL-2.0 and indexed on .org. Search, install, activate — same as any theme you've used.",
    icon: "download",
  },
  {
    label: "Import",
    title: "One-click demo import",
    body: "Pulls rooms, services, team, pages, menus. Thirty seconds to a site that already looks done. Then swap the content for yours.",
    icon: "spark",
  },
  {
    label: "Wire AI",
    title: "Paste your Claude API key",
    body: "One field in the Customizer. The concierge speaks your industry's language out of the box — edit the system prompt anytime.",
    icon: "key",
  },
];

const STATS = [
  { v: "90+", l: "PageSpeed score" },
  { v: "0", l: "Theme Check errors" },
  { v: "GPL-2.0", l: "Licensed & free" },
  { v: "EN · AM · RU", l: "i18n-ready" },
  { v: "WP 6.9+", l: "Tested up to" },
];

Object.assign(window, { THEMES, CATEGORIES, TESTIMONIALS, FAQ, STEPS, STATS });
