<template>
    <div class="grid grid-cols-1 gap-3 xl:grid-cols-2 xl:justify-center">
        <div
            class="max-w-md rounded-xl border border-gray-300 bg-white p-4 md:mx-auto md:w-full"
        >
            <!-- header -->
            <div class="mb-4 flex items-center justify-between">
                <button
                    class="rounded px-2 py-1 text-lg hover:bg-gray-100"
                    @click="prevMonth"
                >
                    <ChevronLeft class="h-6 w-6" />
                </button>

                <h2 class="font-serif text-xl capitalize">
                    {{ formatMonth(currentMonth) }}
                </h2>

                <button
                    class="rounded px-2 py-1 text-lg hover:bg-gray-100"
                    @click="nextMonth"
                >
                    <ChevronRight class="h-6 w-6" />
                </button>
            </div>

            <!-- week days -->
            <div
                class="mb-2 grid grid-cols-7 text-center text-sm text-gray-600 sm:text-base"
            >
                <div>Du</div>
                <div>Lu</div>
                <div>Ma</div>
                <div>Mi</div>
                <div>Jo</div>
                <div>Vi</div>
                <div>Sâ</div>
            </div>

            <!-- grid calendar -->
            <div class="grid grid-cols-7 gap-1">
                <button
                    v-for="(date, i) in daysInMonth"
                    :key="i"
                    :class="{
                        invisible: !date,
                        'cursor-not-allowed text-gray-300':
                            date && isDisabled(date),
                        'hover:bg-gray-200 hover:text-black':
                            date && !isDisabled(date),
                        'bg-rosegold-500 text-white': isSelected(date),
                    }"
                    :disabled="isDisabled(date)"
                    class="aspect-square rounded-md text-sm transition sm:text-base"
                    @click="selectDate(date)"
                >
                    {{ date?.getDate() }}
                </button>
            </div>
        </div>
        <div>
            <div
                class="self-start rounded-xl bg-yellow-100/80 p-2 text-center font-sans text-base text-gray-800 sm:text-lg"
            >
                Poți selecta o dată începând cu
                <span class="font-semibold">
                    {{ minDate.toLocaleDateString('ro-RO') }}
                </span>
                (fără weekend-uri).
            </div>

            <div
                v-if="selectedDate"
                class="bg-rosegold-100 mt-3 self-start rounded-xl p-2 text-center font-sans text-base text-gray-800 sm:text-lg"
            >
                Livrare programată:
                <span class="font-semibold">
                    {{ selectedDate.toLocaleDateString('ro-RO') }}
                </span>
            </div>
        </div>
    </div>
</template>

<script setup>
const props = defineProps({
    modelValue: {
        type: [Date, String, null],
        default: null,
    },
})
const emit = defineEmits(['update:modelValue'])

/* -------------- utils --------------- */
import { computed, ref } from 'vue'
import { ChevronLeft, ChevronRight } from 'lucide-vue-next'

function isWeekend(date) {
    const d = date.getDay()
    return d === 0 || d === 6
}

function addDays(date, days) {
    const d = new Date(date)
    d.setDate(d.getDate() + days)
    return d
}

function formatMonth(date) {
    return new Intl.DateTimeFormat('ro-RO', {
        month: 'long',
        year: 'numeric',
    }).format(date)
}

/*----------------- state ---------------------*/
const today = new Date()
today.setHours(0, 0, 0, 0)

let min = addDays(today, 4)
while (isWeekend(min)) min = addDays(min, 1)

const minDate = min
const currentMonth = ref(new Date(min.getFullYear(), min.getMonth(), 1))

function parseYmdToLocalDate(ymd) {
    const [y, m, d] = ymd.split('-').map(Number)
    return new Date(y, m - 1, d)
}

const selectedDate = computed({
    get: () => {
        if (!props.modelValue) return null
        if (typeof props.modelValue === 'string')
            return parseYmdToLocalDate(props.modelValue)
        return props.modelValue instanceof Date
            ? props.modelValue
            : new Date(props.modelValue)
    },
    set: (value) => emit('update:modelValue', value),
})

/*------------------------ calendar logic -----------------*/
const daysInMonth = computed(() => {
    const year = currentMonth.value.getFullYear()
    const month = currentMonth.value.getMonth()

    const firstDay = new Date(year, month, 1)
    const lastDay = new Date(year, month + 1, 0)

    const days = []

    for (let i = 0; i < firstDay.getDay(); i++) {
        days.push(null)
    }

    for (let i = 1; i <= lastDay.getDate(); i++) {
        days.push(new Date(year, month, i))
    }

    return days
})

function isDisabled(date) {
    if (!date) return true
    if (date < minDate) return true
    if (isWeekend(date)) return true
    return false
}

function isSelected(date) {
    if (!date || !selectedDate.value) return false
    return date.toDateString() === selectedDate.value.toDateString()
}

function selectDate(date) {
    if (isDisabled(date)) return

    const y = date.getFullYear()
    const m = String(date.getMonth() + 1).padStart(2, '0')
    const d = String(date.getDate()).padStart(2, '0')

    selectedDate.value = `${y}-${m}-${d}`
}

function prevMonth() {
    currentMonth.value = new Date(
        currentMonth.value.getFullYear(),
        currentMonth.value.getMonth() - 1,
        1,
    )
}

function nextMonth() {
    currentMonth.value = new Date(
        currentMonth.value.getFullYear(),
        currentMonth.value.getMonth() + 1,
        1,
    )
}
</script>
