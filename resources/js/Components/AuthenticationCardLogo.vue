<script setup>
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <Link :href="'/'">
        <svg class="w-16 h-16" viewBox="0 0 480 480" xmlns="http://www.w3.org/2000/svg">
            <defs>
                <linearGradient gradientUnits="userSpaceOnUse" x1="240" y1="0" x2="240" y2="480" id="gradient-0">
                    <stop offset="0" style="stop-color: rgb(100% 0% 0%)" />
                    <stop offset="1" style="stop-color: rgb(33% 0% 0%)" />
                </linearGradient>
            </defs>
            <path d="M 480 240 C 480 372.548 372.548 480 240 480 C 107.452 480 0 372.548 0 240 C 0 107.452 107.452 0 240 0 C 372.548 0 480 107.452 480 240 Z M 90 182 L 390 182 L 390 122 L 90 122 Z M 90 270 L 360 270 L 360 210 L 90 210 Z M 90 358 L 376 358 L 376 298 L 90 298 Z" style="fill-rule: nonzero; fill: url(&quot;#gradient-0&quot;);" />
        </svg>
    </Link>
</template>
