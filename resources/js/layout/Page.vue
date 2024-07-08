<template>
    <custom-navbar></custom-navbar>
    <div class="container-fluid py-4">
        <!-- dynamic content -->
        <slot></slot>
        <!-- footer -->
        <custom-footer></custom-footer>
    </div>
</template>

<script setup>
import CustomNavbar from "./components/CustomNavbar.vue";
import CustomFooter from "./components/CustomFooter.vue";
</script>
