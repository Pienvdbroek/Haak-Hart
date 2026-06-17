<script setup>
import { computed, ref } from 'vue';
import { usePage } from '@inertiajs/vue3';
import HomeProductenTegelCarouselViewer from './HomeProductenTegelCarouselViewer.vue';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
});

const emit = defineEmits(['back', 'play-video']);

const page = usePage();

const user = computed(() => {
    return page.props.auth?.user || {
        name: 'Niet ingelogd',
        email: '',
    };
});

const startDate = ref('');
const endDate = ref('');
const note = ref('');
const quantity = ref(1);
const reserving = ref(false);

const maxQuantity = computed(() => {
    return Number(props.product.available || 1);
});

const quantityOptions = computed(() => {
    return Array.from({ length: maxQuantity.value }, (_, i) => i + 1);
});

const isFormValid = computed(() => {
    if (!startDate.value || !endDate.value) return false;

    const start = new Date(startDate.value);
    const end = new Date(endDate.value);

    if (Number.isNaN(start.getTime()) || Number.isNaN(end.getTime())) {
        return false;
    }

    const differenceInDays = (end - start) / (1000 * 60 * 60 * 24);

    return differenceInDays > 0 && differenceInDays <= 14;
});

function getCsrfToken() {
    return (
        document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || ''
    );
}

async function reserveProduct() {
    if (!page.props.auth?.user) {
        alert('Je moet ingelogd zijn om te reserveren.');
        return;
    }

    if (!isFormValid.value) {
        alert('De einddatum moet na de startdatum liggen en maximaal 14 dagen later zijn.');
        return;
    }

    reserving.value = true;

    try {
        const response = await fetch('/borrowings', {
            method: 'POST',
            credentials: 'same-origin',
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': getCsrfToken(),
            },
            body: JSON.stringify({
                item_id: props.product.id,
                quantity: quantity.value,
                start_date: startDate.value,
                end_date: endDate.value,
                commentary: note.value,
            }),
        });

        const data = await response.json().catch(() => ({}));

        if (!response.ok) {
            alert(data.message || data.error || 'Reserveren mislukt.');
            return;
        }

        alert('Reservering gelukt!');
        window.location.reload();
    } catch (error) {
        console.error('Fout bij reserveren:', error);
        alert('Er is een fout opgetreden bij het reserveren.');
    } finally {
        reserving.value = false;
    }
}
</script>

<template>
    <UContainer class="px-3 pb-16 pt-[clamp(28px,6vw,34px)] sm:px-5">
        <button
            type="button"
            class="flex items-center gap-[14px] text-[16px] font-semibold text-magazijn-gray transition hover:text-magazijn-purple"
            @click="emit('back')"
        >
            <span
                class="grid size-[30px] place-items-center rounded-full bg-magazijn-purple text-magazijn-white"
            >
                <span
                    class="h-[9px] w-[9px] rotate-45 border-b-2 border-l-2 border-current"
                />
            </span>

            <span>Terug</span>
        </button>

        <section
            class="mt-[clamp(31px,5vw,32px)] grid gap-[clamp(28px,5vw,57px)] lg:grid-cols-[minmax(360px,591px)_minmax(360px,586px)]"
        >
            <article
                class="overflow-hidden rounded-[10px] border border-magazijn-purple-soft bg-magazijn-white"
            >
                <div
                    class="h-[clamp(260px,32vw,392px)] overflow-hidden bg-magazijn-purple"
                >
                    <HomeProductenTegelCarouselViewer
                        :product="product"
                        arrows
                        expandable
                    />
                </div>

                <div
                    class="relative min-h-[248px] bg-magazijn-white px-[25px] pt-[13px]"
                >
                    <div class="flex items-center gap-[6px]">
                        <UBadge
                            label="Beschikbaar"
                            class="h-[28px] rounded-[9px] bg-magazijn-green px-[28px] text-[13px] font-bold text-magazijn-white ring-0"
                        />

                        <UBadge
                            :label="product.available"
                            class="grid size-[28px] place-items-center rounded-full bg-magazijn-green p-0 text-[13px] font-bold text-magazijn-white ring-0"
                        />
                    </div>

                    <h1
                        class="mt-7 max-w-[calc(100%-86px)] truncate text-[26px] font-bold leading-8 tracking-[-0.02em] text-black"
                    >
                        {{ product.name }}
                    </h1>

                    <p
                        class="mt-[9px] truncate text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ product.type }}
                    </p>

                    <p
                        class="mt-7 truncate text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ product.info }}
                    </p>

                    <UButton
                        v-if="product.youtubeVideo"
                        type="button"
                        icon="i-lucide-play"
                        aria-label="Bekijk video"
                        variant="solid"
                        size="xl"
                        class="absolute right-[30px] top-10 !grid size-[56px] !place-items-center rounded-full bg-magazijn-purple !p-0 text-magazijn-white shadow-md transition hover:scale-110 hover:bg-magazijn-purple hover:shadow-xl active:scale-95"
                        @click="emit('play-video', product)"
                    />
                </div>
            </article>

            <UCard
                class="bg-magazijn-white"
                :ui="{
                    root: 'rounded-[10px] border border-magazijn-purple-soft shadow-none ring-0',
                    body: 'px-[clamp(24px,4vw,33px)] py-[clamp(28px,4vw,34px)] sm:px-[clamp(24px,4vw,33px)] sm:py-[clamp(28px,4vw,34px)]',
                }"
            >
                <div class="flex items-start gap-[26px]">
                    <div
                        class="relative mt-[1px] size-[47px] shrink-0 border-2 border-black/80"
                    >
                        <span
                            class="absolute left-[20px] top-[20px] h-[2px] w-[12px] bg-black/80"
                        />

                        <span
                            class="absolute left-0 top-[23px] h-[2px] w-full bg-black/80"
                        />
                    </div>

                    <div>
                        <h2
                            class="text-[24px] font-bold leading-7 tracking-[-0.03em] text-black"
                        >
                            Reserveren
                        </h2>

                        <p
                            class="mt-[6px] text-[16px] leading-5 text-magazijn-gray"
                        >
                            Max. 14 dagen
                        </p>
                    </div>
                </div>

                <div class="mt-8">
                    <label
                        class="block text-[18px] font-bold leading-6 text-black"
                    >
                        Naam student
                    </label>

                    <p
                        class="mt-[10px] text-[16px] leading-5 text-magazijn-gray"
                    >
                        {{ user.name }}
                        <span v-if="user.email">({{ user.email }})</span>
                    </p>
                </div>

                <div class="mt-[29px]">
                    <label
                        class="block text-[18px] font-bold leading-6 text-black"
                    >
                        Aantal
                        <span class="text-sm font-normal">
                            (max {{ maxQuantity }})
                        </span>
                    </label>

                    <USelect
                        v-model="quantity"
                        :items="quantityOptions"
                        size="xl"
                        class="mt-4 w-full"
                        :ui="{
                            base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black ring-1 ring-magazijn-purple-soft',
                            content: 'z-[9999]',
                        }"
                        :portal="'body'"
                    />
                </div>

                <div class="mt-[29px] grid gap-6 sm:grid-cols-2 sm:gap-[84px]">
                    <div>
                        <label
                            class="block text-[18px] font-bold leading-6 text-black"
                        >
                            Startdatum
                        </label>

                        <UInput
                            v-model="startDate"
                            type="date"
                            variant="outline"
                            size="xl"
                            class="mt-4 w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>

                    <div>
                        <label
                            class="block text-[18px] font-bold leading-6 text-black"
                        >
                            Einddatum
                        </label>

                        <UInput
                            v-model="endDate"
                            type="date"
                            variant="outline"
                            size="xl"
                            class="mt-4 w-full"
                            :ui="{
                                base: 'h-[41px] rounded-[8px] bg-magazijn-white text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                            }"
                        />
                    </div>
                </div>

                <p
                    v-if="startDate && endDate && !isFormValid"
                    class="mt-3 text-sm text-red-500"
                >
                    De reservering mag maximaal 14 dagen duren en de einddatum
                    moet na de startdatum liggen.
                </p>

                <div class="mt-[39px]">
                    <label
                        class="block text-[18px] font-bold leading-6 text-black"
                    >
                        Opmerkingen (optioneel)
                    </label>

                    <UTextarea
                        v-model="note"
                        placeholder="Bijv. voor welk project"
                        autoresize
                        :rows="3"
                        class="mt-[14px] w-full"
                        :ui="{
                            base: 'min-h-[95px] resize-none rounded-[10px] bg-magazijn-white px-[15px] py-[13px] text-[15px] text-black shadow-sm ring-1 ring-magazijn-purple-soft placeholder:text-magazijn-gray focus-visible:ring-2 focus-visible:ring-magazijn-purple',
                        }"
                    />
                </div>

                <UButton
                    label="Reserveren"
                    size="xl"
                    block
                    :loading="reserving"
                    :disabled="!isFormValid || quantity < 1 || reserving"
                    class="mt-[29px] h-[47px] rounded-[10px] bg-magazijn-purple text-[23px] font-bold tracking-wide text-magazijn-white hover:bg-magazijn-purple disabled:opacity-50"
                    @click="reserveProduct"
                />
            </UCard>
        </section>
    </UContainer>
</template>
