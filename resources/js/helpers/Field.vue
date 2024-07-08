<template>
    <slot :hasError="hasError" :errorMessage="errorMessage">
        <div
            class="input-group input-group-outline my-3"
            :class="{
                'is-invalid': hasError,
                'is-filled': modelValue || hasError,
            }">
            <slot name="label" v-if="!noLabel">
                <label class="form-label" :for="$attrs['id'] || id" :class="labelClass">{{ label }}</label>
            </slot>
            <slot name="input" :hasError="hasError">
                <input
                    v-if="!noInput"
                    v-bind="$attrs"
                    v-bind:type="$attrs['type'] || 'text'"
                    class="form-control"
                    :value="modelValue"
                    v-bind:id="$attrs['id'] || id"
                    @input="$emit('update:modelValue', $event.target.value)"
                />
            </slot>
            <slot name="error" :errorMessage="errorMessage" :hasError="hasError" v-if="hasError">
                <small style="font-size: 12px;">{{ errors[field][0] }}</small>
            </slot>
        </div>
    </slot>
</template>

<script setup>
import { computed } from "vue";

const props = defineProps({
    modelValue: {
        type: [String, Number, Boolean, Object, Array],
    },
    label: {
        type: String,
    },
    labelClass: {
        type: String,
        default: "",
    },
    id: {
        type: String,
    },
    field: {
        type: String,
    },
    errors: {
        type: Object,
        default: () => {},
    },
    noLabel: {
        type: Boolean,
        default: false,
    },
    noInput: {
        type: Boolean,
        default: false,
    },
});
defineEmits(["update:modelValue"]);

const hasError = computed(() => {
    if (!props.field) {
        return false;
    }

    return props.errors.hasOwnProperty(props.field);
});

const errorMessage = computed(() => {
    if (hasError.value) {
        return props.errors[props.field][0];
    }

    return "";
});
</script>

<style scoped></style>
