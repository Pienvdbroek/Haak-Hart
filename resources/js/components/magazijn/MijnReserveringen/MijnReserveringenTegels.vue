<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';

const props = defineProps({
    reservation: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['return']);

function formatReadableDate(value) {
    if (!value) return '-';

    let date;

    if (typeof value === 'number' || /^\d+$/.test(String(value))) {
        const numberValue = Number(value);
        date = new Date(String(value).length === 10 ? numberValue * 1000 : numberValue);
    } else if (/^\d{4}-\d{2}-\d{2}$/.test(String(value))) {
        const [year, month, day] = String(value).split('-').map(Number);
        date = new Date(year, month - 1, day);
    } else {
        date = new Date(value);
    }

    if (Number.isNaN(date.getTime())) {
        return value;
    }

    const rawValue = String(value);
    const hasRealTime =
        /[T ]\d{2}:\d{2}/.test(rawValue) &&
        !/[T ]00:00(?::00)?/.test(rawValue);

    return new Intl.DateTimeFormat('nl-NL', {
        day: 'numeric',
        month: 'long',
        year: 'numeric',
        ...(hasRealTime
            ? {
                hour: '2-digit',
                minute: '2-digit',
            }
            : {}),
    }).format(date);
}
</script>

<template>
    <div
        class="flex flex-col justify-between gap-6 rounded-lg border border-neutral-200 bg-white p-6 shadow-sm md:flex-row md:items-center"
    >
        <div class="flex items-center gap-5">
            <div class="flex h-14 w-14 items-center justify-center rounded-xl">
                <UIcon
                    name="i-lucide-package"
                    class="h-10 w-10 text-neutral-600"
                />
            </div>

            <div>
                <h3 class="text-2xl font-semibold">
                    {{ reservation.item.item_name }}
                </h3>

                <p class="text-neutral-500">
                    Start: {{ formatReadableDate(reservation.borrow_date) }}
                    -
                    Eind: {{ formatReadableDate(reservation.end_date) }}
                </p>

                <p class="text-neutral-400">
                    Aantal: {{ reservation.quantity }}
                </p>

                <p v-if="reservation.commentary" class="text-neutral-400">
                    Opmerking: {{ reservation.commentary }}
                </p>
            </div>
        </div>

        <div class="flex items-center gap-4">
            <StatusBadge :status="reservation.status" />

            <UButton
                v-if="reservation.status === 'Actief'"
                label="Inleveren"
                color="green"
                variant="solid"
                size="sm"
                @click="emit('return', reservation.id)"
            />
        </div>
    </div>
</template>
