<template>
    <div class="min-h-full bg-[#f3f3f3]">
        <div>
            <Navbar></Navbar>
            <div class="px-14">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue'
</script>
