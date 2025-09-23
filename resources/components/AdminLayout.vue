<template>
    <div class="min-h-full bg-[#f3f3f3]">
        <div>
            <AdminNavbar></AdminNavbar>
            <div class="sm:px-14">
                <router-view></router-view>
            </div>
        </div>
    </div>
</template>

<script setup>
import AdminNavbar from './AdminNavbar.vue'
</script>
