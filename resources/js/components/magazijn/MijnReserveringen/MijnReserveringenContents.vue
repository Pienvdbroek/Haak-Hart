<script setup lang="ts">
import { ref, computed, onMounted } from 'vue';
import { usePage } from '@inertiajs/vue3';
import MijnReserveringenTegels from './MijnReserveringenTegels.vue';

const user = computed(() => usePage().props.auth.user);
const reservations = ref([]);
const loading = ref(true);
const search = ref('');
const statusFilter = ref('Alle');
const statusOptions = ['Alle', 'Actief', 'Te laat', 'Verlopen'];

async function fetchMyReservations() {
    loading.value = true;
    try {
        const response = await fetch('/api/my-reservations', {
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
            },
            credentials: 'same-origin',
        });
        if (!response.ok) throw new Error('Netwerkfout');
        const data = await response.json();
        reservations.value = data;
    } catch (err) {
        console.error(err);
    } finally {
        loading.value = false;
    }
}

async function returnReservation(id) {
    if (!confirm('Weet je zeker dat je dit product wilt inleveren?')) return;
    try {
        const response = await fetch(`/borrowings/${id}/return`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN':
                    document
                        .querySelector('meta[name="csrf-token"]')
                        ?.getAttribute('content') || '',
                'Content-Type': 'application/json',
            },
            credentials: 'same-origin',
        });
        if (!response.ok) throw new Error('Inleveren mislukt');
        reservations.value = reservations.value.filter((r) => r.id !== id);
        alert('Product ingeleverd!');
    } catch (err) {
        console.error(err);
        alert('Fout bij inleveren');
    }
}

const stats = computed(() => {
    const total = reservations.value.length;
    const active = reservations.value.filter(
        (r) => r.status === 'Actief',
    ).length;
    const expired = reservations.value.filter(
        (r) => r.status === 'Verlopen',
    ).length;
    const late = reservations.value.filter(
        (r) => r.status === 'Te laat',
    ).length;
    const returned = reservations.value.filter(
        (r) => r.status === 'Teruggebracht',
    ).length;
    return { total, active, expired, late, returned };
});

const filteredReservations = computed(() => {
    let result = reservations.value;
    if (statusFilter.value !== 'Alle') {
        result = result.filter((r) => r.status === statusFilter.value);
    }
    const query = search.value.trim().toLowerCase();
    if (query) {
        result = result.filter((r) =>
            r.item.item_name.toLowerCase().includes(query),
        );
    }
    return result;
});

onMounted(fetchMyReservations);
</script>

<template>
    <div class="space-y-8">
        <!-- Profielkaart -->
        <div
            class="flex items-center gap-5 rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
        >
            <div class="flex h-14 w-14 items-center justify-center">
                <UIcon
                    name="i-lucide-user"
                    class="h-10 w-10 text-neutral-600"
                />
            </div>
            <div>
                <h1 class="text-2xl font-semibold">{{ user.name }}</h1>
                <p class="text-neutral-500">{{ user.email }}</p>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid gap-6 md:grid-cols-3">
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center">
                        <UIcon
                            name="i-lucide-package"
                            class="h-8 w-8 text-neutral-600"
                        />
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold">
                            {{ stats.total }}
                        </h2>
                        <p class="text-neutral-500">Totaal</p>
                    </div>
                </div>
            </div>
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center">
                        <UIcon
                            name="i-lucide-clock-3"
                            class="h-8 w-8 text-neutral-600"
                        />
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold">
                            {{ stats.active }}
                        </h2>
                        <p class="text-neutral-500">Actief</p>
                    </div>
                </div>
            </div>
            <div
                class="rounded-lg border border-neutral-200 bg-white p-6 shadow-sm"
            >
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center">
                        <UIcon
                            name="i-lucide-check-circle-2"
                            class="h-8 w-8 text-neutral-600"
                        />
                    </div>
                    <div>
                        <h2 class="text-2xl font-semibold">
                            {{ stats.returned || 0 }}
                        </h2>
                        <p class="text-neutral-500">Teruggebracht</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Titel & filters -->
        <div>
            <h2 class="mb-4 text-3xl font-semibold">Mijn reserveringen</h2>
            <div class="grid gap-4 md:grid-cols-[1fr_240px_240px]">
                <UInput
                    v-model="search"
                    icon="i-lucide-search"
                    placeholder="Zoek een reservering"
                    variant="outline"
                    size="xl"
                    class="min-w-[min(100%,360px)] flex-[999_1_360px]"
                    :ui="{
                        base: 'h-[46px] rounded-[10px] bg-magazijn-white text-[14px] text-magazijn-purple shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                        leadingIcon: 'text-magazijn-gray',
                    }"
                />
                <select
                    v-model="statusFilter"
                    class="mt-1 h-12 rounded-md border border-neutral-200 bg-white px-4 outline-none"
                >
                    <option
                        v-for="opt in statusOptions"
                        :key="opt"
                        :value="opt"
                    >
                        {{ opt }}
                    </option>
                </select>
                <select
                    class="mt-1 h-12 rounded-md border border-neutral-200 bg-white px-4 outline-none"
                >
                    <option>Deze maand</option>
                </select>
            </div>
        </div>

        <!-- Tegels -->
        <div v-if="loading" class="py-8 text-center">
            <UIcon
                name="i-lucide-loader-circle"
                class="mx-auto h-6 w-6 animate-spin text-magazijn-purple"
            />
            <p class="mt-2">Laden...</p>
        </div>
        <div
            v-else-if="filteredReservations.length === 0"
            class="py-8 text-center text-neutral-500"
        >
            Geen reserveringen gevonden.
        </div>
        <div v-else class="space-y-5">
            <MijnReserveringenTegels
                v-for="res in filteredReservations"
                :key="res.id"
                :reservation="res"
                @return="returnReservation"
            />
        </div>
    </div>
</template>
