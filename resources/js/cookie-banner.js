/**
 * First-party cookie consent: stores analytics preference and loads Matomo only when accepted.
 */
import { Modal } from 'bootstrap';

const STORAGE_KEY = 'sur_cookie_consent_v1';

/**
 * @returns {{ analytics: boolean } | null}
 */
function readConsent() {
    try {
        const raw = localStorage.getItem(STORAGE_KEY);
        if (!raw) {
            return null;
        }
        const data = JSON.parse(raw);
        if (typeof data.analytics !== 'boolean') {
            return null;
        }
        return { analytics: data.analytics };
    } catch {
        return null;
    }
}

/**
 * @param {boolean} analytics
 */
function writeConsent(analytics) {
    localStorage.setItem(
        STORAGE_KEY,
        JSON.stringify({ v: 1, analytics })
    );
}

let matomoLoaded = false;

/**
 * Load Matomo tracker script after analytics consent.
 */
function loadMatomo() {
    if (matomoLoaded) {
        return;
    }
    const el = document.getElementById('sur-matomo-config');
    if (!el) {
        return;
    }
    let config;
    try {
        config = JSON.parse(el.textContent || '{}');
    } catch {
        return;
    }
    if (!config.trackerUrl || config.siteId === undefined) {
        return;
    }
    const base = String(config.trackerUrl).replace(/\/?$/, '/');
    const _paq = (window._paq = window._paq || []);
    _paq.push(['trackPageView']);
    _paq.push(['enableLinkTracking']);
    _paq.push(['setTrackerUrl', base + 'matomo.php']);
    _paq.push(['setSiteId', String(config.siteId)]);
    const d = document;
    const g = d.createElement('script');
    const s = d.getElementsByTagName('script')[0];
    g.async = true;
    g.src = base + 'matomo.js';
    if (s && s.parentNode) {
        s.parentNode.insertBefore(g, s);
    }
    matomoLoaded = true;
}

/**
 * @param {HTMLElement} modalEl
 * @param {boolean} settingsMode
 */
function setPanelVisibility(modalEl, settingsMode) {
    const welcome = modalEl.querySelector('[data-sur-panel="welcome"]');
    const settings = modalEl.querySelector('[data-sur-panel="settings"]');
    if (welcome) {
        welcome.classList.toggle('d-none', settingsMode);
    }
    if (settings) {
        settings.classList.toggle('d-none', !settingsMode);
    }
}

/**
 * Bootstrap cookie consent UI and Matomo loading.
 */
function initCookieBanner() {
    const modalEl = document.getElementById('surCookieConsentModal');
    if (!modalEl) {
        return;
    }

    const consent = readConsent();
    if (consent?.analytics) {
        loadMatomo();
    }

    const modal = new Modal(modalEl, {
        backdrop: 'static',
        keyboard: false,
    });

    const analyticsCheckbox = modalEl.querySelector('[data-sur-analytics-checkbox]');
    const btnEssential = modalEl.querySelector('[data-sur-action="essential"]');
    const btnAccept = modalEl.querySelector('[data-sur-action="accept-analytics"]');
    const btnSave = modalEl.querySelector('[data-sur-action="save-settings"]');
    const openTriggers = document.querySelectorAll('[data-sur-open-cookie-settings]');

    const openSettings = () => {
        setPanelVisibility(modalEl, true);
        const current = readConsent();
        if (analyticsCheckbox) {
            analyticsCheckbox.checked = Boolean(current?.analytics);
        }
        modal.show();
    };

    const openWelcome = () => {
        setPanelVisibility(modalEl, false);
        modal.show();
    };

    if (consent === null) {
        openWelcome();
    }

    openTriggers.forEach((node) => {
        node.addEventListener('click', (e) => {
            e.preventDefault();
            openSettings();
        });
    });

    if (btnEssential) {
        btnEssential.addEventListener('click', () => {
            writeConsent(false);
            modal.hide();
        });
    }

    if (btnAccept) {
        btnAccept.addEventListener('click', () => {
            writeConsent(true);
            loadMatomo();
            modal.hide();
        });
    }

    if (btnSave && analyticsCheckbox) {
        btnSave.addEventListener('click', () => {
            const next = Boolean(analyticsCheckbox.checked);
            const prev = readConsent()?.analytics === true;
            writeConsent(next);
            if (next) {
                loadMatomo();
            } else if (prev) {
                window.location.reload();
                return;
            }
            modal.hide();
        });
    }
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieBanner);
} else {
    initCookieBanner();
}
