<template>
    <div class="bg-rosegold-700">
        <div class="mx-auto max-w-11/12 sm:max-w-10/12">
            <div class="hidden flex-row justify-between py-10 sm:flex">
                <div class="flex flex-col">
                    <p class="font-serif text-2xl font-semibold text-white">
                        Utile
                    </p>
                    <RouterLink
                        v-for="(link, i) in utils_footer"
                        :key="i"
                        :to="link.link"
                        class="mt-1 block"
                    >
                        <p
                            class="font-serif text-xl text-white underline-offset-2 hover:underline"
                        >
                            {{ link.name }}
                        </p>
                    </RouterLink>
                </div>
                <div class="flex flex-col">
                    <p class="font-serif text-2xl font-semibold text-white">
                        Tablouri personalizate
                    </p>
                    <RouterLink
                        v-for="(link, i) in links_t_footer"
                        :key="i"
                        :to="link.link"
                        class="mt-1 block"
                    >
                        <p
                            class="font-serif text-xl text-white underline-offset-2 hover:underline"
                        >
                            {{ link.name }}
                        </p>
                    </RouterLink>

                    <br />
                    <p class="font-serif text-2xl font-semibold text-white">
                        Buchete de flori
                    </p>
                    <RouterLink
                        v-for="(link, i) in links_b_footer"
                        :key="i"
                        :to="link.link"
                        class="mt-1 block"
                    >
                        <p
                            class="font-serif text-xl text-white underline-offset-2 hover:underline"
                        >
                            {{ link.name }}
                        </p>
                    </RouterLink>
                </div>
                <div class="flex flex-col">
                    <p class="font-serif text-2xl font-semibold text-white">
                        Beneficii
                    </p>
                    <RouterLink
                        v-for="(link, i) in benefits"
                        :key="i"
                        class="mt-1 flex items-center gap-2"
                        to="/benefits"
                    >
                        <component :is="link.icon" class="h-6 w-6 text-white" />
                        <p
                            class="font-serif text-xl text-white underline-offset-2 hover:underline"
                        >
                            {{ link.title }}
                        </p>
                    </RouterLink>
                </div>
                <div class="flex flex-col">
                    <p class="font-serif text-2xl font-semibold text-white">
                        Contact
                    </p>
                    <div
                        v-for="(link, i) in contact_footer"
                        :key="i"
                        class="mt-2 flex items-center gap-3"
                    >
                        <component :is="link.icon" class="h-8 w-8 text-white" />
                        <div class="flex flex-col">
                            <span
                                class="font-serif text-xl font-semibold text-white"
                            >
                                {{ link.title }}
                                <span class="font-normal">{{
                                    link.after_title
                                }}</span>
                            </span>
                            <span class="text-lg text-white">
                                {{ link.description }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="flex flex-col gap-3 py-10 sm:hidden">
                <div>
                    <button
                        class="flex w-full items-center justify-between"
                        @click="mobileOpen.utile = !mobileOpen.utile"
                    >
                        <span
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Utile
                        </span>
                        <span>
                            <ChevronUp
                                v-if="mobileOpen.utile"
                                class="h-8 w-8 text-white" />
                            <ChevronDown v-else class="h-8 w-8 text-white"
                        /></span>
                    </button>
                    <Transition name="accordion">
                        <div v-if="mobileOpen.utile" class="overflow-hidden">
                            <RouterLink
                                v-for="(link, i) in utils_footer"
                                v-if="mobileOpen.utile"
                                :key="i"
                                :to="link.link"
                                class="mt-1 block"
                            >
                                <span class="font-serif text-xl text-white">
                                    {{ link.name }}
                                </span>
                            </RouterLink>
                        </div>
                    </Transition>
                </div>

                <div>
                    <button
                        class="flex w-full items-center justify-between"
                        @click="mobileOpen.tablouri = !mobileOpen.tablouri"
                    >
                        <span
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Tablouri personalizate
                        </span>
                        <span>
                            <ChevronUp
                                v-if="mobileOpen.tablouri"
                                class="h-8 w-8 text-white" />
                            <ChevronDown v-else class="h-8 w-8 text-white"
                        /></span>
                    </button>
                    <Transition name="accordion">
                        <div v-if="mobileOpen.tablouri" class="overflow-hidden">
                            <RouterLink
                                v-for="(link, i) in links_t_footer"
                                v-if="mobileOpen.tablouri"
                                :key="i"
                                :to="link.link"
                                class="mt-1 block"
                            >
                                <p class="font-serif text-xl text-white">
                                    {{ link.name }}
                                </p>
                            </RouterLink>
                        </div>
                    </Transition>
                </div>

                <div>
                    <button
                        class="flex w-full items-center justify-between"
                        @click="mobileOpen.buchete = !mobileOpen.buchete"
                    >
                        <span
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Buchete de flori
                        </span>
                        <span>
                            <ChevronUp
                                v-if="mobileOpen.buchete"
                                class="h-8 w-8 text-white" />
                            <ChevronDown v-else class="h-8 w-8 text-white"
                        /></span>
                    </button>
                    <Transition name="accordion">
                        <div v-if="mobileOpen.buchete" class="overflow-hidden">
                            <RouterLink
                                v-for="(link, i) in links_b_footer"
                                v-if="mobileOpen.buchete"
                                :key="i"
                                :to="link.link"
                                class="mt-1 block"
                            >
                                <p class="font-serif text-xl text-white">
                                    {{ link.name }}
                                </p>
                            </RouterLink>
                        </div>
                    </Transition>
                </div>

                <div>
                    <button
                        class="flex w-full items-center justify-between"
                        @click="mobileOpen.beneficii = !mobileOpen.beneficii"
                    >
                        <span
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Beneficii
                        </span>
                        <span>
                            <ChevronUp
                                v-if="mobileOpen.beneficii"
                                class="h-8 w-8 text-white" />
                            <ChevronDown v-else class="h-8 w-8 text-white"
                        /></span>
                    </button>
                    <Transition name="accordion">
                        <div
                            v-if="mobileOpen.beneficii"
                            class="overflow-hidden"
                        >
                            <RouterLink
                                v-for="(link, i) in benefits"
                                v-if="mobileOpen.beneficii"
                                :key="i"
                                :to="link.link"
                                class="mt-1 block"
                            >
                                <p class="font-serif text-xl text-white">
                                    {{ link.title }}
                                </p>
                            </RouterLink>
                        </div>
                    </Transition>
                </div>

                <div>
                    <button
                        class="flex w-full items-center justify-between"
                        @click="mobileOpen.contact = !mobileOpen.contact"
                    >
                        <span
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Contact
                        </span>
                        <span>
                            <ChevronUp
                                v-if="mobileOpen.contact"
                                class="h-8 w-8 text-white" />
                            <ChevronDown v-else class="h-8 w-8 text-white"
                        /></span>
                    </button>
                    <Transition name="accordion">
                        <div v-if="mobileOpen.contact" class="overflow-hidden">
                            <RouterLink
                                v-for="(link, i) in contact_footer"
                                v-if="mobileOpen.contact"
                                :key="i"
                                :to="link.link"
                                class="mt-2 flex items-center gap-3"
                            >
                                <component
                                    :is="link.icon"
                                    class="h-8 w-8 text-white"
                                />
                                <div class="flex flex-col">
                                    <span
                                        class="font-serif text-xl font-semibold text-white"
                                    >
                                        {{ link.title }}
                                        <span class="font-normal">{{
                                            link.after_title
                                        }}</span>
                                    </span>
                                    <span class="text-lg text-white">
                                        {{ link.description }}
                                    </span>
                                </div>
                            </RouterLink>
                        </div>
                    </Transition>
                </div>
            </div>

            <div class="grid grid-cols-1 gap-8 sm:grid-cols-2">
                <!-- stanga -->
                <div>
                    <div class="mb-1 flex min-w-0 items-center gap-3">
                        <p
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Modalități de plată:
                        </p>
                        <div
                            class="h-px flex-1 -translate-y-1 bg-white/80 sm:h-[2px] sm:translate-y-0"
                        ></div>
                    </div>
                    <div
                        class="flex flex-wrap items-center gap-4 [&>svg]:block [&>svg]:h-12 [&>svg]:w-auto [&>svg]:shrink-0"
                    >
                        <MyIcon name="paypal" />
                        <MyIcon name="visa" />
                        <MyIcon name="mastercard" />
                    </div>
                </div>

                <!-- dreapta -->
                <div>
                    <div class="mb-1 flex min-w-0 items-center gap-3">
                        <p
                            class="font-serif text-2xl whitespace-nowrap text-white"
                        >
                            Urmărește-ne și pe:
                        </p>
                        <div
                            class="h-px flex-1 -translate-y-1 bg-white/80 sm:h-[2px] sm:translate-y-0"
                        ></div>
                    </div>

                    <div
                        class="flex flex-wrap items-center gap-3 [&>svg]:block [&>svg]:h-12 [&>svg]:w-auto [&>svg]:shrink-0"
                    >
                        <MyIcon
                            href="https://www.instagram.com/satin.and.sweets/"
                            label="Vezi pagina noastră de Instagram"
                            name="instagram"
                        />
                        <MyIcon
                            href="https://www.tiktok.com/@satin.and.sweets"
                            label="Vezi pagina noastră de TikTok"
                            name="tiktok"
                        />
                        <MyIcon
                            href="https://www.facebook.com/profile.php?id=61572116444445"
                            label="Vezi pagina noastră de Facebook"
                            name="facebook"
                        />
                    </div>
                </div>
            </div>

            <div class="flex flex-wrap items-center justify-center gap-6 py-4">
                <a
                    aria-label="Deschide site-ul ANPC într-o filă nouă"
                    class="rounded"
                    href="https://anpc.ro/ce-este-sal/"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    <img
                        :src="ANPC"
                        alt="ANPC te respectă"
                        class="pulse-hover h-16 w-auto transition-transform duration-200 ease-out will-change-transform"
                        loading="lazy"
                    />
                </a>
                <a
                    aria-label="Deschide site-ul Consumer Redress într-o filă nouă"
                    class="rounded"
                    href="https://consumer-redress.ec.europa.eu/index_en"
                    rel="noopener noreferrer"
                    target="_blank"
                >
                    <img
                        :src="ANPC_EU"
                        alt="Comisia Europeană"
                        class="pulse-hover h-20 w-auto transition-transform duration-200 ease-out will-change-transform"
                        loading="lazy"
                    />
                </a>
            </div>
        </div>
    </div>
    <div class="relative h-1 w-full bg-gray-200"></div>
    <div class="bg-rosegold-500 flex w-full justify-center">
        <span class="text-center font-serif text-lg text-gray-700"
            >© All rights reserved. Site creat de
            <a
                class="underline-offset-4 hover:underline"
                href="https://www.instagram.com/coltan_cristian/"
                rel="noopener noreferrer"
                style="color: black"
                target="_blank"
            >
                Colțan Cristian
            </a>
        </span>
    </div>
</template>

<script setup>
import {
    benefits,
    contact_footer,
    links_b_footer,
    links_t_footer,
    utils_footer,
} from '../utils/imports.js'
import MyIcon from './core/MyIcon.vue'
import ANPC from '../assets/ANPC.png'
import ANPC_EU from '../assets/ANPC2.webp'
import { reactive } from 'vue'
import { ChevronDown, ChevronUp } from 'lucide-vue-next'

const mobileOpen = reactive({
    utile: false,
    tablouri: false,
    buchete: false,
    beneficii: false,
    contact: false,
})
</script>

<style scoped>
@keyframes bump {
    0% {
        transform: scale(1);
    }
    50% {
        transform: scale(1.02);
    }
    100% {
        transform: scale(1);
    }
}

.pulse-hover:hover {
    animation: bump 420ms ease-in-out;
}

.accordion-enter-active,
.accordion-leave-active {
    transition: all 0.2s ease;
}

.accordion-enter-from,
.accordion-leave-to {
    max-height: 0;
    opacity: 0;
    transform: translateY(-4px);
}

.accordion-enter-to,
.accordion-leave-from {
    max-height: 500px;
    opacity: 1;
    transform: translateY(0);
}
</style>
