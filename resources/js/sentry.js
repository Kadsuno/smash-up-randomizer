import * as Sentry from '@sentry/browser';

const dsnMeta = document.querySelector('meta[name="sentry-dsn"]');

if (dsnMeta?.content) {
    Sentry.init({
        dsn: dsnMeta.content,
        environment: document.querySelector('meta[name="sentry-environment"]')?.content ?? 'production',
        release: document.querySelector('meta[name="sentry-release"]')?.content ?? undefined,

        integrations: [
            Sentry.browserTracingIntegration(),
        ],

        // Match backend sample rate — 10% of page loads traced.
        tracesSampleRate: 0.1,

        // Only send errors, not every console.warn.
        beforeSend(event) {
            // Drop events that originate from browser extensions.
            const frames = event.exception?.values?.[0]?.stacktrace?.frames ?? [];
            const isExtension = frames.some(
                (f) => f.filename?.startsWith('chrome-extension://') || f.filename?.startsWith('moz-extension://')
            );
            return isExtension ? null : event;
        },
    });
}

export default Sentry;
