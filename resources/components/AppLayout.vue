<template>
    <div class="min-h-full bg-[#f3f3f3]">
        <div>
            <Navbar></Navbar>
            <div class="">
                <router-view></router-view>
            </div>
            <Footer></Footer>

            <MyToast />
        </div>
    </div>
</template>

<script setup>
import Navbar from './Navbar.vue'
import Footer from './Footer.vue'
import MyToast from './core/MyToast.vue'
</script>
