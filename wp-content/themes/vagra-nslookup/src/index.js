/**
 * Island Hydration Orchestrator
 *
 * Scans the DOM for mount-point elements matching <div id="nsl-*">
 * and lazy-loads only the needed React component via dynamic import().
 */

import { createElement } from 'react';
import { createRoot } from 'react-dom/client';

/**
 * Registry mapping element IDs to lazy component loaders.
 * Add new islands here as they are created.
 */
const islands = {
  // Example:
  // 'nsl-lookup': () => import('./components/NsLookup'),
  // 'nsl-propagation': () => import('./components/Propagation'),
};

/**
 * Hydrate a single island mount point.
 *
 * @param {HTMLElement} el - The mount-point element.
 */
async function hydrateIsland(el) {
  const id = el.id;
  const loader = islands[id];

  if (!loader) {
    return;
  }

  try {
    const module = await loader();
    const Component = module.default;

    // Read props from data-props attribute if present.
    let props = {};
    const rawProps = el.dataset.props;
    if (rawProps) {
      try {
        props = JSON.parse(rawProps);
      } catch {
        // Ignore malformed JSON.
      }
    }

    const root = createRoot(el);
    root.render(createElement(Component, props));
  } catch (err) {
    console.error(`[nsl-islands] Failed to hydrate "${id}":`, err);
  }
}

/**
 * Scan the DOM and hydrate all island mount points.
 */
function init() {
  const mountPoints = document.querySelectorAll('[id^="nsl-"]');

  mountPoints.forEach((el) => {
    if (islands[el.id]) {
      hydrateIsland(el);
    }
  });
}

if (document.readyState === 'loading') {
  document.addEventListener('DOMContentLoaded', init);
} else {
  init();
}
