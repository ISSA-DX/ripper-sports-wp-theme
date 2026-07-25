<?php
/**
 * Cursor Glow + Scroll-Tinted Gradient
 *
 * Two decorative layers that ride on top of the floating sports balls:
 *
 *   1. .cursor-glow — a soft gold radial that follows the mouse.
 *      Gives the page a "torch beam" feel and makes long scrolls feel alive.
 *
 *   2. .scroll-tint — a fixed full-viewport gradient that shifts hue
 *      based on scroll progress (deep-green at top → warmer green → cool
 *      blue-green at the bottom). Implemented as a CSS variable
 *      `--scroll-progress` (0 → 1) updated by JS on every scroll event.
 *
 * Both are aria-hidden, pointer-events: none, and disabled when
 * prefers-reduced-motion: reduce (CSS + JS both honor it).
 *
 * @package Ripper_Sports
 */
?>
<div class="cursor-glow" data-cursor-glow aria-hidden="true"></div>
<div class="scroll-tint" data-scroll-tint aria-hidden="true"></div>
