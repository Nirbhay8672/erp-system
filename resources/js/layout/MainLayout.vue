<template>
    <custom-sidebar :auth="auth"></custom-sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <slot></slot>
    </main>
</template>

<script setup>
import CustomSidebar from "./components/CustomSidebar.vue";

const props = defineProps({
    auth: {
        type: Object,
        required: true,
    },
    url: {
        type: String,
        required: true,
    },
});
</script>
