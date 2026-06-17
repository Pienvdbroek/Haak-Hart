<script setup lang="ts">
import StatusBadge from '@/components/StatusBadge.vue';

const props = defineProps<{
    reservation: {
        id: number;
        user: { name: string; email: string };
        item: { item_name: string; category?: string };
        borrow_date: string;
        end_date: string;
        quantity: number;
        commentary: string | null;
        status: string;
    };
}>();

const emit = defineEmits(['delete']);

function formatReadableDate(value: string | number | null | undefined) {
    if (!value) return '-';

    let date: Date;

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
        return String(value);
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
    <UCard
        variant="outline"
        :ui="{
            root: 'rounded-[18px] bg-magazijn-white shadow-sm ring-1 ring-magazijn-purple-soft',
            body: 'p-0 sm:p-0',
        }"
    >
        <div
            class="flex flex-col gap-4 px-5 py-4 sm:flex-row sm:items-center sm:justify-between"
        >
            <div class="flex min-w-0 items-center gap-5">
                <div class="h-16 w-16 shrink-0 rounded-[18px] bg-magazijn-purple" />

                <div class="min-w-0">
                    <h2 class="truncate text-lg font-semibold text-black">
                        {{ reservation.item.item_name }}
                    </h2>

                    <p class="text-sm text-magazijn-gray">
                        {{ reservation.user.name }} ({{
                            reservation.user.email
                        }})
                    </p>

                    <p
                        v-if="reservation.commentary"
                        class="mt-1 max-w-[520px] text-sm text-magazijn-gray"
                    >
                        <span class="font-semibold text-black">
                            Opmerking:
                        </span>
                        {{ reservation.commentary }}
                    </p>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4 text-sm">
                <div>
                    <span class="font-medium text-magazijn-gray">Aantal:</span>

                    <span class="ml-1 font-semibold">
                        {{ reservation.quantity }}
                    </span>
                </div>

                <div>
                    <span class="font-medium text-magazijn-gray">Start:</span>

                    <span class="ml-1 font-semibold">
                        {{ formatReadableDate(reservation.borrow_date) }}
                    </span>
                </div>

                <div>
                    <span class="font-medium text-magazijn-gray">Eind:</span>

                    <span class="ml-1 font-semibold">
                        {{ formatReadableDate(reservation.end_date) }}
                    </span>
                </div>
            </div>

            <div class="flex items-center gap-5">
                <StatusBadge :status="reservation.status" />

                <UButton
                    icon="i-lucide-trash"
                    color="error"
                    variant="ghost"
                    @click="emit('delete', reservation.id)"
                />
            </div>
        </div>
    </UCard>
</template>
