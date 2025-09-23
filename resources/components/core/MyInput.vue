<template>
    <div>
        <label class="sr-only">
            {{ label }}
        </label>
        <div class="mt-1 flex rounded-md shadow-sm">
            <span
                v-if="prepend"
                class="inline-flex items-center rounded-l-md border border-r-0 border-gray-300 bg-gray-50 px-3 text-lg text-gray-500"
                >{{ prepend }}
            </span>
            <template v-if="type === 'select'">
                <select
                    :class="inputClasses"
                    :name="name"
                    :required="required"
                    :value="props.modelValue"
                    @change="onChange($event.target.value)"
                >
                    <option v-for="option of selectOptions" :value="option.key">
                        {{ option.text }}
                    </option>
                </select>
            </template>
            <template v-else-if="type === 'textarea'">
                <textarea
                    :class="inputClasses"
                    :name="name"
                    :placeholder="label"
                    :required="required"
                    :value="props.modelValue"
                    rows="3"
                    style="font-size: 18px"
                    @input="emit('update:modelValue', $event.target.value)"
                ></textarea>
            </template>
            <template v-else-if="type === 'file'">
                <input
                    :class="inputClasses"
                    :name="name"
                    :placeholder="label"
                    :required="required"
                    :type="type"
                    multiple
                    style="font-size: 18px"
                    @change="
                        emit(
                            'update:modelValue',
                            Array.from($event.target.files),
                        )
                    "
                />
            </template>
            <template v-else-if="type === 'checkbox'">
                <input
                    :id="id"
                    :checked="props.modelValue"
                    :name="name"
                    :required="required"
                    :type="type"
                    class="text-rosegold-700 focus:ring-rosegold-500 h-5 w-5 rounded border-gray-300"
                    @change="emit('update:modelValue', $event.target.checked)"
                />
                <label
                    :for="id"
                    class="ml-2 block -translate-y-1 text-lg font-medium text-gray-900"
                    >{{ label }}</label
                >
            </template>
            <template v-else>
                <input
                    :class="inputClasses"
                    :name="name"
                    :placeholder="label"
                    :required="required"
                    :type="type"
                    :value="props.modelValue"
                    step="0.01"
                    style="font-size: 18px"
                    @input="emit('update:modelValue', $event.target.value)"
                />
            </template>
            <span
                v-if="append"
                class="inline-flex items-center rounded-r-md border border-l-0 border-gray-300 bg-gray-50 px-3 text-lg text-gray-500"
                >{{ append }}</span
            >
        </div>
    </div>
</template>

<script setup>
import { computed } from 'vue'

const props = defineProps({
    modelValue: [String, Number, File, Boolean, Array],
    label: String,
    type: { type: String, default: 'text' },
    name: String,
    required: Boolean,
    prepend: {
        type: String,
        default: '',
    },
    append: {
        type: String,
        default: '',
    },
    selectOptions: Array,
})

const id = computed(() => {
    if (props.id) return props.id
    return `id-${Math.random().toString(36).substring(7)}`
})

const inputClasses = computed(() => {
    const cls = [
        `block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-rosegold-500 focus:border-rosegold-500 focus:z-10 text-lg
`,
    ]

    if (props.append && !props.prepend) {
        cls.push('rounded-l-md')
    } else if (props.prepend && !props.append) {
        cls.push('rounded-r-md')
    } else {
        cls.push('rounded-md')
    }
    return cls.join(' ')
})

const emit = defineEmits(['update:modelValue', 'change'])

function onChange(value) {
    emit('update:modelValue', value)
    emit('change', value)
}
</script>
