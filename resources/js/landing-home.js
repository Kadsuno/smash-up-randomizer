/**
 * Alpine data components for the marketing home (landing) page carousels.
 *
 * @param {import('alpinejs').Alpine} Alpine
 * @returns {void}
 */
export default function registerLandingHome(Alpine) {
    Alpine.data('landingHero', (slideCount) => ({
        i: 0,
        n: slideCount,
        timer: null,
        init() {
            this.start();
        },
        next() {
            this.i = (this.i + 1) % this.n;
        },
        prev() {
            this.i = (this.i - 1 + this.n) % this.n;
        },
        go(j) {
            this.i = j;
        },
        start() {
            this.stop();
            this.timer = setInterval(() => this.next(), 6500);
        },
        stop() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
    }));

    Alpine.data('landingQuotes', () => ({
        q: 0,
        n: 3,
        timer: null,
        init() {
            this.start();
        },
        next() {
            this.q = (this.q + 1) % this.n;
        },
        prev() {
            this.q = (this.q - 1 + this.n) % this.n;
        },
        goQuote(j) {
            this.q = j;
        },
        start() {
            this.stop();
            this.timer = setInterval(() => this.next(), 8000);
        },
        stop() {
            if (this.timer) {
                clearInterval(this.timer);
                this.timer = null;
            }
        },
    }));
}
