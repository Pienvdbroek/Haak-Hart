<template>
    <div :class="badgeClass">
        <component :is="icon" class="mr-2 h-4 w-4" />
        {{ label }}
    </div>
</template>

<script setup>
import { computed } from 'vue';

// voorbeeld icons (lucide/vue heroicons etc.)
import { CheckCircle, Clock, AlertTriangle, Check, X } from 'lucide-vue-next';

const props = defineProps({
    status: {
        type: String,
        required: true,
    },

    // optioneel overrides
    customMap: {
        type: Object,
        default: null,
    },
});

const defaultMap = {
    available: {
        label: 'Beschikbaar',
        class: 'bg-green-100 text-green-600 border-green-600',
        icon: Check,
    },
    unavailable: {
        label: 'Uitgeleend',
        class: 'bg-red-100 text-red-500 border-red-500',
        icon: X,
    },
    returned: {
        label: 'Teruggebracht',
        class: 'bg-green-100 text-green-600 border-green-600',
        icon: CheckCircle,
    },
    active: {
        label: 'Actief',
        class: 'bg-blue-100 text-blue-600 border-blue-600',
        icon: Clock,
    },
    late: {
        label: 'Te laat',
        class: 'bg-red-100 text-red-600 border-red-600',
        icon: AlertTriangle,
    },
    // Toevoegingen voor de admin weergave
    Actief: {
        label: 'Actief',
        class: 'bg-blue-100 text-blue-600 border-blue-600',
        icon: Clock,
    },
    'Te laat': {
        label: 'Te laat',
        class: 'bg-red-100 text-red-600 border-red-600',
        icon: AlertTriangle,
    },
    Verlopen: {
        label: 'Verlopen',
        class: 'bg-orange-100 text-orange-600 border-orange-600',
        icon: AlertTriangle,
    },
};
const map = computed(() => props.customMap || defaultMap);

const config = computed(() => {
    return map.value[props.status] || map.value.active;
});

const label = computed(() => config.value.label);
const icon = computed(() => config.value.icon);

const badgeClass = computed(() => {
    return [
        'rounded-full px-4 py-1 text-sm font-semibold border flex items-center gap-1',
        config.value.class,
    ];
});
</script>
