<?php

return [
    /*
     * Number of recent shuffle history rows to inspect when the anti-repeat
     * fairness option is active. Each row covers one full game (2–4 players
     * × 2 factions), so the default of 5 typically excludes 10–20 factions.
     */
    'anti_repeat_window' => (int) env('SHUFFLE_ANTI_REPEAT_WINDOW', 5),
];
