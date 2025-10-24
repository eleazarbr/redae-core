const namespaces = new Map();
// Align with project structure using lowercase `pages` directory
const localPages = import.meta.glob("./pages/**/*.vue");

export function registerInertiaNamespace(namespace, pages) {
  namespaces.set(namespace, pages);
}

// Expose the registrar globally so packages can register themselves
// Expose the registrar globally so packages can register themselves (best-effort)
if (typeof globalThis !== 'undefined' && globalThis.window) {
  // Do not overwrite if another script defined it first
  globalThis.window.registerInertiaNamespace = globalThis.window.registerInertiaNamespace || registerInertiaNamespace;
}

export async function resolveInertia(name) {
  const [namespace, page] = name.includes("::") ? name.split("::") : [null, name];

  if (!namespace) {
    // Try local first, then fall back to any registered namespace that contains the page
    const localLoader = findLoader(localPages, page);
    if (localLoader) {
      const chunk = await localLoader();
      return chunk.default;
    }

    for (const registry of namespaces.values()) {
      const loader = findLoader(registry ?? {}, page);
      if (loader) {
        const chunk = await loader();
        return chunk.default;
      }
    }

    throw new Error(`Page not found: ${page}`);
  }

  // If a namespace was given, wait briefly for lazy namespace registration
  if (!namespaces.has(namespace)) {
    await waitForNamespace(namespace);
  }

  const registry = namespaces.get(namespace);
  return loadPage(registry ?? {}, page);
}

async function loadPage(pages, key) {
  const loader = findLoader(pages, key);
  if (!loader) {
    throw new Error(`Page not found: ${key}`);
  }
  const chunk = await loader();
  return chunk.default;
}

function findLoader(pages, key) {
  // Normalize given key (e.g. "Dashboard" or "auth/Login")
  const normalized = String(key)
    .replace(/^\.\//, '')
    .replace(/\.vue$/i, '');

  // Try a few common candidate keys used by Vite's glob maps
  const candidates = [
    key,
    `./${normalized}`,
    `./${normalized}.vue`,
    `./pages/${normalized}.vue`,
  ];

  for (const candidate of candidates) {
    const tryLoader = pages?.[candidate];
    if (tryLoader) {
      return tryLoader;
    }
  }

  // Fallback: match by filename tail to support arbitrary glob base paths
  const tail = `${normalized}.vue`;
  const entry = Object.entries(pages || {}).find(([path]) =>
    path.endsWith(`/${tail}`) || path.endsWith(`\\${tail}`)
  );

  if (entry) {
    const [, loader] = entry;
    return loader;
  }

  return undefined;
}

async function waitForNamespace(namespace, { timeout = 2000, interval = 50 } = {}) {
  const start = Date.now();
  while (!namespaces.has(namespace)) {
    if (Date.now() - start >= timeout) {
      throw new Error(`Inertia namespace not registered: ${namespace}`);
    }
    await new Promise((r) => setTimeout(r, interval));
  }
}
