<template>
    <div>
        {{ store.user.data }}
    </div>
</template>

<script setup>
import { useAppStore } from '../store/index.js'

const store = useAppStore()
</script>
