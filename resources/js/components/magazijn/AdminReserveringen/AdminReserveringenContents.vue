<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import AdminReserveringenTegels from './AdminReserveringenTegels.vue';

const page = {
    title: 'Reserveringen overzicht',
    description: 'Bekijk alle uitgeschreven producten',
};

const allReservations = ref<any[]>([]);
const loading = ref(true);
const error = ref<string | null>(null);
const search = ref('');
const statusFilter = ref('Alle');
const statusOptions = ['Alle', 'Actief', 'Te laat', 'Verlopen'];

async function fetchReservations() {
    loading.value = true;
    try {
        const res = await fetch('/api/admin/reservations', {
            credentials: 'same-origin',
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
        });
        if (!res.ok) throw new Error('Netwerkfout');
        allReservations.value = await res.json();
    } catch (err) {
        console.error(err);
        error.value = 'Kon reserveringen niet laden';
    } finally {
        loading.value = false;
    }
}

async function deleteReservation(id: number) {
    if (
        !confirm(
            'Weet je zeker dat je deze reservering wilt verwijderen? De voorraad wordt weer beschikbaar.',
        )
    )
        return;
    try {
        const response = await fetch(`/api/admin/reservations/${id}`, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
            credentials: 'same-origin',
        });
        if (!response.ok) throw new Error('Verwijderen mislukt');
        allReservations.value = allReservations.value.filter(
            (r) => r.id !== id,
        );
    } catch (err) {
        console.error(err);
        alert('Fout bij verwijderen');
    }
}

const stats = computed(() => {
    const total = allReservations.value.length;
    const active = allReservations.value.filter(
        (r) => r.status === 'Actief',
    ).length;
    const late = allReservations.value.filter(
        (r) => r.status === 'Te laat',
    ).length;
    const expired = allReservations.value.filter(
        (r) => r.status === 'Verlopen',
    ).length;
    return { total, active, late, expired };
});

const filteredReservations = computed(() => {
    let result = allReservations.value;
    if (statusFilter.value !== 'Alle')
        result = result.filter((r) => r.status === statusFilter.value);
    const query = search.value.trim().toLowerCase();
    if (query) {
        result = result.filter(
            (r) =>
                r.user.name.toLowerCase().includes(query) ||
                r.user.email.toLowerCase().includes(query) ||
                r.item.item_name.toLowerCase().includes(query),
        );
    }
    return result;
});

onMounted(fetchReservations);
</script>

<template>
    <UContainer class="px-3 pt-[clamp(28px,6vw,61px)] pb-14 sm:px-5">
        <!-- Header -->
        <div class="flex items-start justify-between gap-4">
            <UPageHeader
                v-bind="page"
                :ui="{
                    root: 'border-0 py-0',
                    container: 'px-0',
                    title: 'text-[clamp(38px,7vw,40px)] font-bold leading-tight text-black',
                    description:
                        'mt-2 text-[clamp(18px,4vw,20px)] text-magazijn-gray',
                }"
            />
        </div>

        <!-- Stats -->
        <div class="mt-8 grid gap-4 md:grid-cols-4">
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm text-neutral-700"
                >
                    <UIcon name="i-lucide-package" class="h-4 w-4" /><span
                        >Totaal</span
                    >
                </div>
                <h2 class="text-5xl font-semibold">{{ stats.total }}</h2>
            </div>
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm text-neutral-700"
                >
                    <UIcon name="i-lucide-clock-3" class="h-4 w-4" /><span
                        >Actief</span
                    >
                </div>
                <h2 class="text-5xl font-semibold">{{ stats.active }}</h2>
            </div>
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm text-neutral-700"
                >
                    <UIcon name="i-lucide-alert-circle" class="h-4 w-4" /><span
                        >Te laat</span
                    >
                </div>
                <h2 class="text-5xl font-semibold">{{ stats.late }}</h2>
            </div>
            <div
                class="rounded-lg border border-neutral-200 bg-white p-5 shadow-sm"
            >
                <div
                    class="mb-6 flex items-center gap-2 text-sm text-neutral-700"
                >
                    <UIcon
                        name="i-lucide-check-circle-2"
                        class="h-4 w-4"
                    /><span>Verlopen</span>
                </div>
                <h2 class="text-5xl font-semibold">{{ stats.expired }}</h2>
            </div>
        </div>

        <!-- Filters -->
        <div class="mt-8 grid gap-4 md:grid-cols-[1fr_240px]">
            <UInput
                v-model="search"
                icon="i-lucide-search"
                placeholder="Zoek op gebruiker of product..."
                size="xl"
                :ui="{
                    base: 'h-[46px] rounded-[10px] bg-white text-magazijn-purple ring-1 ring-magazijn-purple-soft',
                }"
            />
            <select
                v-model="statusFilter"
                class="h-12 rounded-md border border-neutral-200 bg-white px-4 outline-none"
            >
                <option v-for="opt in statusOptions" :key="opt" :value="opt">
                    {{ opt }}
                </option>
            </select>
        </div>

        <!-- Lijst -->
        <div v-if="loading" class="mt-8 py-8 text-center">
            <UIcon
                name="i-lucide-loader-circle"
                class="mx-auto h-6 w-6 animate-spin text-magazijn-purple"
            />
            <p class="mt-2">Laden...</p>
        </div>
        <div v-else-if="error" class="mt-8 py-8 text-center text-red-500">
            {{ error }}
        </div>
        <div v-else>
            <div
                v-if="filteredReservations.length === 0"
                class="mt-8 py-8 text-center text-magazijn-gray"
            >
                Geen reserveringen gevonden.
            </div>
            <div v-else class="mt-8 space-y-4">
                <AdminReserveringenTegels
                    v-for="res in filteredReservations"
                    :key="res.id"
                    :reservation="res"
                    @delete="deleteReservation"
                />
            </div>
        </div>
    </UContainer>
</template>
