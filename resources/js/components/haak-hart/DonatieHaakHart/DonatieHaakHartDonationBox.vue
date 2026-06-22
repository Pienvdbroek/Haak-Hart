<template>
    <section
        class="relative mx-auto w-full max-w-[560px] overflow-visible pb-24 sm:max-w-[680px] sm:pb-[120px]"
    >
        <div class="relative aspect-[760/1020] w-full overflow-visible">
            <img
                src="/heart.svg"
                alt=""
                class="pointer-events-none absolute top-[31%] left-[-12%] z-30 w-[23%] -rotate-12 opacity-90 sm:top-[30%] sm:left-[-8%] sm:w-[20%]"
            />

            <img
                src="/heart.svg"
                alt=""
                class="pointer-events-none absolute top-[-2%] right-[15%] z-30 w-[24%] opacity-90 sm:top-[-1%] sm:right-[21%] sm:w-[21%]"
            />

            <img
                src="/heart.svg"
                alt=""
                class="pointer-events-none absolute top-[37%] right-[-8%] z-10 w-[27%] rotate-20 opacity-90 sm:top-[39%] sm:right-[3%] sm:w-[24%]"
            />

            <div
                class="absolute top-[6%] left-1/2 z-20 w-[86%] max-w-[520px] -translate-x-1/2 rounded-2xl border border-borderstrokeline bg-white p-4 shadow-sm sm:top-[5%] sm:w-[72%] sm:p-6"
            >
                <slot />
            </div>

            <img
                src="/donatiebox.svg"
                alt="Donatiebox"
                class="absolute right-0 bottom-[-4%] left-0 z-10 mx-auto w-full sm:bottom-[-10%] sm:w-[96%]"
            />
        </div>
    </section>
</template>
