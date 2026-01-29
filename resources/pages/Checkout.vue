<template>
    <div class="mt-1 mb-10 overflow-x-hidden">
        <div class="relative right-1/2 left-1/2 -mx-[50vw] w-screen">
            <div class="mx-auto max-w-11/12 sm:max-w-10/12">
                <section class="w-full">
                    <CheckoutSteps :current-step="2" />
                    <div class="gap-12 bg-[#f3f3f3]">
                        <div
                            v-if="cartItemsCount > 0"
                            class="grid grid-cols-1 gap-3 sm:gap-6 xl:grid-cols-[3fr_1fr]"
                        >
                            <div class="flex flex-col gap-3 sm:gap-6">
                                <!--adresa livrare-->
                                <div
                                    class="rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-4"
                                >
                                    <div class="mb-2 flex gap-3 sm:mb-4">
                                        <div
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-500 text-base font-bold text-white sm:h-7 sm:w-7 sm:text-lg"
                                        >
                                            1
                                        </div>
                                        <p
                                            class="-translate-y-0.5 text-center font-serif text-lg sm:translate-y-0 sm:text-xl"
                                        >
                                            Adresă de livrare
                                        </p>
                                    </div>

                                    <div class="flex flex-col gap-3">
                                        <!-- email -->
                                        <div class="">
                                            <p class="mb-1 font-serif text-lg">
                                                E-mail
                                                <span class="text-red-600"
                                                    >*</span
                                                >
                                            </p>
                                            <input
                                                id="email"
                                                v-model="formData.email"
                                                class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                name="email"
                                                style="font-size: 15px"
                                                type="text"
                                                @input="formErrors.email = null"
                                            />
                                            <p
                                                v-if="formErrors.email"
                                                class="mt-1 text-sm text-red-600"
                                            >
                                                {{ formErrors.email }}
                                            </p>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- nume -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Nume
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="last_name"
                                                    v-model="formData.last_name"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="last_name"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.last_name =
                                                            null
                                                    "
                                                />
                                                <p
                                                    v-if="formErrors.last_name"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.last_name }}
                                                </p>
                                            </div>
                                            <!-- prenume -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Prenume
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="first_name"
                                                    v-model="
                                                        formData.first_name
                                                    "
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="first_name"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.first_name =
                                                            null
                                                    "
                                                />
                                                <p
                                                    v-if="formErrors.first_name"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.first_name }}
                                                </p>
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-2 gap-4">
                                            <!-- phone_number -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Telefon
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="phone_number"
                                                    v-model="
                                                        formData.phone_number
                                                    "
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="phone_number"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.phone_number =
                                                            null
                                                    "
                                                />
                                                <p
                                                    v-if="
                                                        formErrors.phone_number
                                                    "
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{
                                                        formErrors.phone_number
                                                    }}
                                                </p>
                                            </div>
                                            <!-- tara -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Țară
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="country"
                                                    v-model="fakeCountry"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 cursor-not-allowed rounded-lg border border-gray-300 bg-gray-50 text-gray-500 hover:ring-1"
                                                    disabled
                                                    name="country"
                                                    style="font-size: 15px"
                                                    type="text"
                                                />
                                            </div>
                                        </div>

                                        <div class="grid grid-cols-3 gap-4">
                                            <!-- judet -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Județ
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <select
                                                    id="state"
                                                    v-model="formData.state"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="state"
                                                    style="font-size: 15px"
                                                    @input="
                                                        formErrors.state = null
                                                    "
                                                >
                                                    <option disabled value="">
                                                        Selectează județul
                                                    </option>
                                                    <option
                                                        v-for="state in states"
                                                        :key="state.code"
                                                        :value="state.name"
                                                    >
                                                        {{ state.name }}
                                                    </option>
                                                </select>
                                                <p
                                                    v-if="formErrors.state"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.state }}
                                                </p>
                                            </div>
                                            <!-- Oras/Sat -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Oraș / Sat
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="city"
                                                    v-model="formData.city"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="city"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.city = null
                                                    "
                                                />
                                                <p
                                                    v-if="formErrors.city"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.city }}
                                                </p>
                                            </div>
                                            <!-- cod postal -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Cod poștal
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="zipcode"
                                                    v-model="formData.zipcode"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="zipcode"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.zipcode =
                                                            null
                                                    "
                                                />
                                                <p
                                                    v-if="formErrors.zipcode"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.zipcode }}
                                                </p>
                                            </div>
                                        </div>

                                        <div>
                                            <!-- adresa -->
                                            <div class="">
                                                <p
                                                    class="mb-1 font-serif text-lg"
                                                >
                                                    Adresă
                                                    <span class="text-red-600"
                                                        >*</span
                                                    >
                                                </p>
                                                <input
                                                    id="address"
                                                    v-model="formData.address"
                                                    class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                    name="address"
                                                    style="font-size: 15px"
                                                    type="text"
                                                    @input="
                                                        formErrors.address =
                                                            null
                                                    "
                                                />
                                                <p
                                                    v-if="formErrors.address"
                                                    class="mt-1 text-sm text-red-600"
                                                >
                                                    {{ formErrors.address }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!--data livrare-->
                                <div
                                    class="rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-4"
                                >
                                    <div class="mb-2 flex gap-3 sm:mb-4">
                                        <div
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-500 text-base font-bold text-white sm:h-7 sm:w-7 sm:text-lg"
                                        >
                                            2
                                        </div>
                                        <p
                                            class="-translate-y-0.5 text-center font-serif text-lg sm:translate-y-0 sm:text-xl"
                                        >
                                            Alege data livrării
                                        </p>
                                    </div>
                                    <MyCalendar v-model="delieveryDate" />
                                </div>

                                <!--adresa facturare-->
                                <div
                                    class="rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-4"
                                >
                                    <div class="mb-2 flex gap-3 sm:mb-4">
                                        <div
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-500 text-base font-bold text-white sm:h-7 sm:w-7 sm:text-lg"
                                        >
                                            3
                                        </div>
                                        <p
                                            class="-translate-y-0.5 text-center font-serif text-lg sm:translate-y-0 sm:text-xl"
                                        >
                                            Date facturare
                                        </p>
                                    </div>

                                    <div class="mb-3 flex justify-between">
                                        <div class="flex gap-3">
                                            <Building2
                                                class="h-7 w-7 text-gray-500"
                                            />
                                            <p class="font-serif text-xl">
                                                Doresc factură pe firmă.
                                            </p>
                                        </div>
                                        <button
                                            id="needsInvoice"
                                            :class="
                                                needsInvoice
                                                    ? 'bg-rosegold-500'
                                                    : 'bg-gray-400'
                                            "
                                            class="relative inline-flex h-7 w-12 items-center rounded-full transition-colors"
                                            type="button"
                                            @click="
                                                needsInvoice = !needsInvoice
                                            "
                                        >
                                            <span
                                                :class="
                                                    needsInvoice
                                                        ? 'translate-x-7'
                                                        : 'translate-x-1'
                                                "
                                                class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform"
                                            />
                                        </button>
                                    </div>

                                    <p
                                        v-if="!needsInvoice"
                                        class="font-serif text-lg"
                                    >
                                        Factura va fi emisă pe numele persoanei
                                        fizice, folosind datele de livrare.
                                    </p>

                                    <Transition name="fade">
                                        <div
                                            v-if="needsInvoice"
                                            class="flex flex-col gap-3"
                                        >
                                            <div class="grid grid-cols-3 gap-4">
                                                <!-- societate -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Societate
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="company_name"
                                                        v-model="
                                                            invoiceFormData.company_name
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="company_name"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.company_name =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.company_name
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.company_name
                                                        }}
                                                    </p>
                                                </div>
                                                <!-- cui -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        CUI
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="cui"
                                                        v-model="
                                                            invoiceFormData.cui
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="cui"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.cui =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="formErrors.cui"
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{ formErrors.cui }}
                                                    </p>
                                                </div>

                                                <!-- nr reg comert -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Nr. Reg. Com.
                                                    </p>
                                                    <input
                                                        id="nr_reg_com"
                                                        v-model="
                                                            invoiceFormData.nr_reg_com
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="nr_reg_com"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.nr_reg_com =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.nr_reg_com
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.nr_reg_com
                                                        }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- nume -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Nume
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_last_name"
                                                        v-model="
                                                            invoiceFormData.inv_last_name
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_last_name"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_last_name =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_last_name
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_last_name
                                                        }}
                                                    </p>
                                                </div>
                                                <!-- prenume -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Prenume
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_first_name"
                                                        v-model="
                                                            invoiceFormData.inv_first_name
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_first_name"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_first_name =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_first_name
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_first_name
                                                        }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-2 gap-4">
                                                <!-- phone_number -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Telefon
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_phone_number"
                                                        v-model="
                                                            invoiceFormData.inv_phone_number
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_phone_number"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_phone_number =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_phone_number
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_phone_number
                                                        }}
                                                    </p>
                                                </div>
                                                <!-- tara -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Țară
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="country"
                                                        v-model="fakeCountry"
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 cursor-not-allowed rounded-lg border border-gray-300 bg-gray-50 text-gray-500 hover:ring-1"
                                                        disabled
                                                        name="country"
                                                        style="font-size: 15px"
                                                        type="text"
                                                    />
                                                </div>
                                            </div>

                                            <div class="grid grid-cols-3 gap-4">
                                                <!-- judet -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Județ
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <select
                                                        id="inv_state"
                                                        v-model="
                                                            invoiceFormData.inv_state
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_state"
                                                        style="font-size: 15px"
                                                        @input="
                                                            formErrors.inv_state =
                                                                null
                                                        "
                                                    >
                                                        <option
                                                            disabled
                                                            value=""
                                                        >
                                                            Selectează județul
                                                        </option>
                                                        <option
                                                            v-for="state in states"
                                                            :key="state.code"
                                                            :value="state.name"
                                                        >
                                                            {{ state.name }}
                                                        </option>
                                                    </select>
                                                    <p
                                                        v-if="
                                                            formErrors.inv_state
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_state
                                                        }}
                                                    </p>
                                                </div>
                                                <!-- Oras/Sat -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Oraș / Sat
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_city"
                                                        v-model="
                                                            invoiceFormData.inv_city
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_city"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_city =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_city
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_city
                                                        }}
                                                    </p>
                                                </div>
                                                <!-- cod postal -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Cod poștal
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_zip_code"
                                                        v-model="
                                                            invoiceFormData.inv_zip_code
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_zip_code"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_zip_code =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_zip_code
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_zip_code
                                                        }}
                                                    </p>
                                                </div>
                                            </div>

                                            <div>
                                                <!-- adresa -->
                                                <div class="">
                                                    <p
                                                        class="mb-1 font-serif text-lg"
                                                    >
                                                        Adresă
                                                        <span
                                                            class="text-red-600"
                                                            >*</span
                                                        >
                                                    </p>
                                                    <input
                                                        id="inv_address1"
                                                        v-model="
                                                            invoiceFormData.inv_address1
                                                        "
                                                        class="focus:ring-rosegold-500 hover:ring-rosegold-500 w-full flex-1 rounded-lg border border-gray-300 bg-gray-50 hover:ring-1"
                                                        name="inv_address1"
                                                        style="font-size: 15px"
                                                        type="text"
                                                        @input="
                                                            formErrors.inv_address1 =
                                                                null
                                                        "
                                                    />
                                                    <p
                                                        v-if="
                                                            formErrors.inv_address1
                                                        "
                                                        class="mt-1 text-sm text-red-600"
                                                    >
                                                        {{
                                                            formErrors.inv_address1
                                                        }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                    </Transition>
                                </div>

                                <!--modalitate plata-->
                                <div
                                    class="rounded-xl bg-[rgba(204,204,204,0.2)] p-2 md:p-4"
                                >
                                    <div class="mb-2 flex gap-3 sm:mb-4">
                                        <div
                                            class="flex h-6 w-6 items-center justify-center rounded-full bg-gray-500 text-base font-bold text-white sm:h-7 sm:w-7 sm:text-lg"
                                        >
                                            4
                                        </div>
                                        <p
                                            class="-translate-y-0.5 text-center font-serif text-lg sm:translate-y-0 sm:text-xl"
                                        >
                                            Modalitate de plată
                                        </p>
                                    </div>
                                    <div class="flex flex-col gap-3">
                                        <!-- CARD -->
                                        <label
                                            :class="
                                                paymentMethod === 'card'
                                                    ? 'border-rosegold-500 bg-white/60'
                                                    : 'border-gray-300'
                                            "
                                            class="focus-within:ring-rosegold-300 flex cursor-pointer items-center gap-3 rounded-lg border p-4 transition-colors focus-within:ring-2 hover:bg-gray-100"
                                        >
                                            <input
                                                v-model="paymentMethod"
                                                class="peer sr-only"
                                                name="payment_method"
                                                type="radio"
                                                value="card"
                                            />

                                            <!-- radio custom -->
                                            <span
                                                :class="
                                                    paymentMethod === 'card'
                                                        ? 'border-rosegold-500'
                                                        : 'border-rosegold-400'
                                                "
                                                class="flex h-5 w-5 items-center justify-center rounded-full border-2 transition-colors"
                                            >
                                                <span
                                                    :class="
                                                        paymentMethod === 'card'
                                                            ? 'bg-rosegold-500'
                                                            : 'bg-transparent'
                                                    "
                                                    class="h-2.5 w-2.5 rounded-full transition"
                                                ></span>
                                            </span>

                                            <div
                                                class="flex flex-1 items-center gap-3"
                                            >
                                                <CreditCard
                                                    class="h-8 w-8 text-gray-500"
                                                />
                                                <div>
                                                    <p
                                                        class="font-serif text-base font-medium text-gray-900 sm:text-lg"
                                                    >
                                                        Card bancar
                                                    </p>
                                                    <p
                                                        class="text-sm text-gray-500 sm:text-base"
                                                    >
                                                        Plată securizată online
                                                    </p>
                                                </div>
                                            </div>

                                            <span
                                                class="rounded-full border border-gray-300 px-2 py-1 font-serif text-xs font-medium text-gray-600 sm:text-sm"
                                            >
                                                Recomandat
                                            </span>
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div
                                class="flex flex-col self-start rounded-xl bg-[rgba(204,204,204,0.2)] p-3"
                            >
                                <div class="flex w-full flex-col gap-2">
                                    <p
                                        class="line-clamp-3 font-serif text-[18px] font-medium text-gray-900 lg:text-2xl"
                                    >
                                        Rezumat comandă
                                    </p>
                                    <div class="flex justify-between px-2">
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Produse ({{ store.cartCount }})
                                        </span>
                                        <span
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ store.cartTotal }} RON
                                        </span>
                                    </div>
                                    <div
                                        class="flex justify-between border-t border-gray-400 px-2 pt-2"
                                    >
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Transport
                                        </span>
                                        <span
                                            v-if="transport === 0"
                                            class="font-serif text-[17px] font-semibold text-green-600 lg:text-xl"
                                        >
                                            GRATIS
                                        </span>
                                        <span
                                            v-else
                                            class="font-serif text-[17px] font-semibold lg:text-xl"
                                        >
                                            {{ transport }} RON
                                        </span>
                                    </div>

                                    <div
                                        v-if="discount > 0"
                                        class="flex items-center justify-between gap-2 px-2"
                                    >
                                        <span
                                            class="flex-1 font-serif text-[17px] lg:text-xl"
                                        >
                                            Discount
                                            <span class="font-semibold">{{
                                                store.couponCode
                                            }}</span>
                                        </span>
                                        <span
                                            class="font-serif text-[17px] font-semibold text-green-600 lg:text-xl"
                                        >
                                            - {{ discount }} RON
                                        </span>
                                        <X
                                            class="h-4 w-4 cursor-pointer hover:text-gray-500 sm:h-5 sm:w-5"
                                            @click="store.clearCoupon()"
                                        />
                                    </div>

                                    <div
                                        class="mt-2 flex w-full justify-between rounded-lg bg-[rgba(168,168,168,0.2)] p-2 font-semibold"
                                    >
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            Total:
                                        </span>
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            {{ total }} RON
                                        </span>
                                    </div>

                                    <button
                                        class="bg-rosegold-700 hover:bg-rosegold-500 mt-3 w-full rounded-lg border border-gray-300 py-1 font-semibold text-white transition-colors"
                                        style="border-radius: 10px"
                                        @click="submitOrder"
                                    >
                                        <span
                                            class="font-serif text-lg lg:text-xl"
                                        >
                                            Trimite comanda
                                        </span>
                                    </button>
                                </div>
                                <ErrorAlert :message="generalError" />
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </div>
    </div>
</template>

<script setup>
import CheckoutSteps from '../components/core/checkout-page/CheckoutSteps.vue'
import { useRouter } from 'vue-router'
import { useAppStore } from '../store/index.js'
import { computed, onMounted, reactive, ref } from 'vue'
import { useFieldErrors } from '../utils/useFieldErrors.js'
import axiosClient from '../js/axios.js'
import { Building2, CreditCard, X } from 'lucide-vue-next'
import MyCalendar from '../components/core/checkout-page/MyCalendar.vue'
import ErrorAlert from '../components/core/ErrorAlert.vue'

const router = useRouter()
const store = useAppStore()

const cartItemsCount = computed(() => store.cartCount)
const cartTotal = computed(() => store.cartTotal)
const transport = computed(() => (cartTotal.value > 300 ? 0 : 25))
const discount = computed(() => store.discount)

const total = computed(() => cartTotal.value + transport.value - discount.value)

onMounted(() => {
    if (!cartItemsCount || cartItemsCount.value === 0) {
        router.push({ name: 'app.cart' })
    }
})

const states = ref([])
async function fetchCounties() {
    generalError.value = null

    try {
        const res = await axiosClient.get('/countries/RO/states')
        states.value = res.data
    } catch (err) {
        handleApiError(err)
    }
}

onMounted(() => {
    fetchCounties()
})

const { formErrors, generalError, handleApiError } = useFieldErrors()

const fakeCountry = 'România'
const formData = reactive({
    email: '',
    last_name: '',
    first_name: '',
    phone_number: '',
    state: '',
    city: '',
    zipcode: '',
    address: '',
})

const invoiceFormData = reactive({
    company_name: '',
    cui: '',
    nr_reg_com: '',
    inv_last_name: '',
    inv_first_name: '',
    inv_state: '',
    inv_city: '',
    inv_phone_number: '',
    inv_address1: '',
    inv_zip_code: '',
})

const needsInvoice = ref(false)
const paymentMethod = ref('card')
const loading = ref(false)

const requiredFields = [
    'email',
    'last_name',
    'first_name',
    'phone_number',
    'state',
    'city',
    'zipcode',
    'address',
]

const requiredInvoiceFields = [
    'company_name',
    'cui',
    'inv_last_name',
    'inv_first_name',
    'inv_state',
    'inv_city',
    'inv_phone_number',
    'inv_address1',
    'inv_zip_code',
]

const isFormValid = computed(() =>
    requiredFields.every(
        (field) => formData[field] && formData[field].toString().trim() !== '',
    ),
)

const isInvoiceFormValid = computed(() => {
    if (!needsInvoice.value) return true

    return requiredInvoiceFields.every(
        (field) =>
            invoiceFormData[field] &&
            invoiceFormData[field].toString().trim() !== '',
    )
})

const delieveryDate = ref(null)

async function submitOrder() {
    loading.value = true
    generalError.value = null
    formErrors.value = {}

    if (!isFormValid.value) {
        generalError.value = 'Toate câmpurile din pasul 1 sunt obligatorii.'
        loading.value = false
        return
    }

    if (!isInvoiceFormValid.value) {
        generalError.value = 'Vă rugăm să completați formularul de facturare.'
        loading.value = false
        return
    }

    if (!delieveryDate.value) {
        generalError.value = 'Vă rugăm să selectați data livrării.'
        loading.value = false
        return
    }

    const invoice_details = needsInvoice.value
        ? {
              company_name: invoiceFormData.company_name,
              cui: invoiceFormData.cui,
              nr_reg_com: invoiceFormData.nr_reg_com,
              contact: {
                  first_name: invoiceFormData.inv_first_name,
                  last_name: invoiceFormData.inv_last_name,
                  phone_number: invoiceFormData.inv_phone_number,
                  email: formData.email,
              },
              address: {
                  country: 'România',
                  state: invoiceFormData.inv_state,
                  city: invoiceFormData.inv_city,
                  zipcode: invoiceFormData.inv_zip_code,
                  address: invoiceFormData.inv_address1,
              },
          }
        : null

    const payload = {
        items: store.cart.items.map((item) => ({
            product_id: item.product.id,
            quantity: item.quantity,
            unit_price: item.unit_price,
            addons: item.addons,
        })),
        delivery_date: new Date(delieveryDate.value).toISOString().slice(0, 10),
        payment_method: paymentMethod.value,
        coupon_code: store.couponCode ? store.couponCode : null,
        needs_invoice: needsInvoice.value,
        invoice_details,
        shipping: formData,
    }

    try {
        const res = await axiosClient.post('/checkout', payload)
        await router.push({
            name: 'app.thank-you',
            params: { orderId: res.data.order_id },
            query: { orderNumber: res.data.order_number },
        })
        store.clearCart()
    } catch (err) {
        handleApiError(err)
    } finally {
        loading.value = false
    }
}
</script>
