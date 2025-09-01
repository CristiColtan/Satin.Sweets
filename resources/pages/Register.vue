<script setup>
import '../css/app.css'

const emit = defineEmits(['submit'])
</script>

<template>
    <div
        class="flex min-h-screen flex-col items-center justify-center bg-[#f3f3f3] p-6 sm:p-14"
    >
        <form method="POST" @submit.prevent="emit('submit')">
            <div class="space-y-4">
                <div class="border-b border-gray-900/10 pb-4">
                    <h2 class="text-base/7 font-semibold text-gray-900">
                        Creeaza-ti un cont!
                    </h2>
                    <p class="">
                        Ai cont deja?
                        <RouterLink class="link-terms" to="/login"
                            >Autentifica-te!</RouterLink
                        >
                    </p>
                    <div
                        class="mt-10 grid grid-cols-1 gap-x-6 gap-y-6 sm:grid-cols-6"
                    >
                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="last_name"
                                >Nume <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="last_name"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="last_name"
                                        placeholder="Popescu"
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="first_name"
                                >Prenume
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="first_name"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="first_name"
                                        placeholder="Vasile"
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="email"
                                >E-mail
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="email"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="email"
                                        placeholder="popescu.vasile@yahoo.com"
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="phone_number"
                                >Telefon
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="phone_number"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="phone_number"
                                        placeholder="0754322400"
                                        type="text"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="password"
                                >Parola
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="password"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="password"
                                        placeholder="********"
                                        type="password"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="sm:col-span-3">
                            <label
                                class="block text-sm/6 font-medium text-gray-900"
                                for="confirm_password"
                                >Confirma parola
                                <span class="text-red-600">*</span></label
                            >
                            <div class="mt-2">
                                <div
                                    class="focus-within:outline-rosegold-500 flex items-center rounded-md bg-white pl-3 outline-1 -outline-offset-1 outline-gray-300 focus-within:outline-2 focus-within:-outline-offset-2"
                                >
                                    <input
                                        id="confirm_password"
                                        class="block min-w-0 grow bg-white py-1.5 pr-3 pl-1 text-base text-gray-900 placeholder:text-gray-400 focus:outline-none sm:text-sm/6"
                                        name="phone_number"
                                        placeholder="********"
                                        type="password"
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="border-b border-gray-900/10 pb-2">
                    <div class="space-y-10">
                        <fieldset>
                            <div class="space-y-1">
                                <div class="flex gap-3">
                                    <div class="flex h-6 shrink-0 items-center">
                                        <div
                                            class="group grid size-4 grid-cols-1"
                                        >
                                            <input
                                                id="terms_conds"
                                                aria-describedby="terms-and-conditions"
                                                class="h-4 w-4 accent-[#B87E7A] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#B87E7A]"
                                                name="terms_conds"
                                                type="checkbox"
                                            />
                                        </div>
                                    </div>
                                    <div class="text-sm/6">
                                        <p
                                            id="terms-and-conditions"
                                            class="text-gray-900"
                                        >
                                            Am citit si accept
                                            <RouterLink
                                                class="link-terms"
                                                to="/termeni-si-conditii"
                                                >Termenii si
                                                conditiile</RouterLink
                                            >.
                                            <span class="text-red-600">*</span>
                                        </p>
                                    </div>
                                </div>
                                <div class="flex gap-3">
                                    <div class="flex h-6 shrink-0 items-center">
                                        <div
                                            class="group grid size-4 grid-cols-1"
                                        >
                                            <input
                                                id="pol_conf"
                                                aria-describedby="policy-of-confidentiality"
                                                class="h-4 w-4 accent-[#B87E7A] focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-[#B87E7A]"
                                                name="pol_conf"
                                                type="checkbox"
                                            />
                                        </div>
                                    </div>
                                    <div class="text-sm/6">
                                        <p
                                            id="policy-of-confidentiality"
                                            class="text-gray-900"
                                        >
                                            Am citit si sunt de acord cu
                                            <RouterLink
                                                class="link-terms"
                                                to="/protectia-datelor"
                                                >Politica de
                                                Confidentialitate</RouterLink
                                            >.
                                            <span class="text-red-600">*</span>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </fieldset>
                    </div>
                </div>
            </div>

            <div class="mt-2 flex items-center justify-center gap-x-6">
                <button
                    class="bg-rosegold-700 hover:bg-rosegold-500 focus-visible:outline-rosegold-700 rounded-md px-7 py-2 text-sm font-semibold text-white shadow-xs focus-visible:outline-2 focus-visible:outline-offset-2"
                    type="submit"
                >
                    Creeaza
                </button>
            </div>
        </form>
    </div>
</template>

<style scoped></style>
