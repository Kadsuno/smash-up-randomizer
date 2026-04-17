/**
 * First-party cookie consent: bottom strip + preference dialog; Matomo loads only after analytics opt-in.
 */

const STORAGE_KEY = 'sur_cookie_consent_v1';
const BODY_BAR_CLASS = 'sur-cookie-bar-visible';

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
    localStorage.setItem(STORAGE_KEY, JSON.stringify({ v: 1, analytics }));
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
 * @param {HTMLInputElement | null} analyticsCheckbox
 */
function syncCheckboxFromStorage(analyticsCheckbox) {
    if (!analyticsCheckbox) {
        return;
    }
    const c = readConsent();
    analyticsCheckbox.checked = Boolean(c?.analytics);
}

/**
 * @param {HTMLElement | null} bar
 */
function setBodyBarOffset(bar) {
    if (!bar) {
        return;
    }
    if (bar.classList.contains('hidden')) {
        document.body.classList.remove(BODY_BAR_CLASS);
    } else {
        document.body.classList.add(BODY_BAR_CLASS);
    }
}

/**
 * @param {HTMLElement | null} bar
 */
function hideBar(bar) {
    if (!bar) {
        return;
    }
    bar.classList.add('hidden');
    document.body.classList.remove(BODY_BAR_CLASS);
}

/**
 * @param {HTMLDialogElement} dialogEl
 */
function closeDialog(dialogEl) {
    if (dialogEl && typeof dialogEl.close === 'function') {
        dialogEl.close();
    }
}

/**
 * @param {boolean} analytics
 * @param {HTMLDialogElement} dialogEl
 */
function applyConsentChoice(analytics, dialogEl) {
    const prev = readConsent()?.analytics === true;
    writeConsent(analytics);
    if (analytics) {
        loadMatomo();
    } else if (prev) {
        window.location.reload();
        return;
    }
    closeDialog(dialogEl);
    syncCheckboxFromStorage(dialogEl.querySelector('[data-sur-analytics-checkbox]'));
}

/**
 * Cookie consent UI and Matomo loading.
 */
function initCookieBanner() {
    const bar = document.getElementById('sur-cookie-consent-bar');
    const dialogEl = document.getElementById('surCookieConsentModal');
    if (!dialogEl || dialogEl.tagName !== 'DIALOG') {
        return;
    }

    const consent = readConsent();
    if (consent?.analytics) {
        loadMatomo();
    }

    setBodyBarOffset(bar);

    const analyticsCheckbox = dialogEl.querySelector('[data-sur-analytics-checkbox]');

    const openDialog = () => {
        syncCheckboxFromStorage(analyticsCheckbox);
        if (typeof dialogEl.showModal === 'function') {
            dialogEl.showModal();
        }
    };

    document.querySelectorAll('[data-sur-open-cookie-settings]').forEach((node) => {
        node.addEventListener('click', (e) => {
            e.preventDefault();
            openDialog();
        });
    });

    dialogEl.addEventListener('close', () => {
        syncCheckboxFromStorage(analyticsCheckbox);
    });

    /** Static backdrop: block Escape from closing (parity with former Bootstrap modal). */
    dialogEl.addEventListener('cancel', (e) => {
        e.preventDefault();
    });

    const rejectOptional = () => {
        hideBar(bar);
        applyConsentChoice(false, dialogEl);
    };

    const acceptAll = () => {
        hideBar(bar);
        applyConsentChoice(true, dialogEl);
    };

    document.querySelectorAll('[data-sur-action="bar-reject"]').forEach((btn) => {
        btn.addEventListener('click', rejectOptional);
    });

    document.querySelectorAll('[data-sur-action="bar-accept-all"]').forEach((btn) => {
        btn.addEventListener('click', acceptAll);
    });

    document.querySelectorAll('[data-sur-action="bar-customize"]').forEach((btn) => {
        btn.addEventListener('click', () => {
            openDialog();
        });
    });

    const saveBtn = dialogEl.querySelector('[data-sur-action="save-settings"]');
    if (saveBtn && analyticsCheckbox) {
        saveBtn.addEventListener('click', () => {
            const next = Boolean(analyticsCheckbox.checked);
            hideBar(bar);
            applyConsentChoice(next, dialogEl);
        });
    }

    dialogEl.querySelectorAll('[data-sur-action="modal-reject"]').forEach((btn) => {
        btn.addEventListener('click', rejectOptional);
    });

    dialogEl.querySelectorAll('[data-sur-action="modal-cancel"]').forEach((btn) => {
        btn.addEventListener('click', () => {
            syncCheckboxFromStorage(analyticsCheckbox);
            closeDialog(dialogEl);
        });
    });

    dialogEl.querySelectorAll('[data-sur-action="modal-close"]').forEach((btn) => {
        btn.addEventListener('click', () => {
            syncCheckboxFromStorage(analyticsCheckbox);
            closeDialog(dialogEl);
        });
    });
}

if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initCookieBanner);
} else {
    initCookieBanner();
}
