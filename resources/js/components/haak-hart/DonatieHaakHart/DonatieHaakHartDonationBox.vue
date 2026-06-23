<template>
    <section
        class="
            relative
            mx-auto
            w-full
            max-w-[560px]
            overflow-visible
            pb-16

            [--donatiebox-overlap:-42%]
            [--donatiebox-width:116%]


            min-[380px]:[--donatiebox-overlap:-20%]
            min-[380px]:[--donatiebox-width:116%]

            min-[480px]:max-w-[620px]
            min-[480px]:[--donatiebox-overlap:-20%]
            min-[480px]:[--donatiebox-width:105%]

            sm:max-w-[680px]
            sm:[--donatiebox-overlap:-10%]
            sm:[--donatiebox-width:95%]

            md:max-w-[700px]
            md:[--donatiebox-overlap:-40%]
            md:[--donatiebox-width:93%]

            lg:max-w-[720px]
            lg:[--donatiebox-overlap:-15%]
            lg:[--donatiebox-width:90%]

            xl:max-w-[720px]
            xl:[--donatiebox-overlap:-35%]
            xl:[--donatiebox-width:90%]

            2xl:max-w-[720px]
            2xl:[--donatiebox-overlap:-35%]
            2xl:[--donatiebox-width:90%]
        "
    >
        <div
            class="
                relative
                min-h-[930px]
                w-full
                overflow-visible

                max-[360px]:min-h-[1000px]

                min-[380px]:min-h-[960px]

                min-[480px]:min-h-[940px]

                sm:min-h-[900px]

                md:aspect-[760/1020]
                md:min-h-0
            "
        >
            <img
                src="/heart.svg"
                alt=""
                class="
                    pointer-events-none
                    absolute
                    top-[28%]
                    left-[-8%]
                    z-30
                    w-[22%]
                    -rotate-12
                    opacity-90

                    max-[360px]:left-[-10%]

                    min-[380px]:top-[28%]
                    min-[380px]:left-[-7%]
                    min-[380px]:w-[22%]

                    min-[480px]:top-[28%]
                    min-[480px]:left-[-4%]
                    min-[480px]:w-[20%]

                    sm:top-[28%]
                    sm:left-[1%]
                    sm:w-[18%]

                    md:top-[28%]
                    md:left-[3.1%]
                    md:w-[17.5%]

                    lg:top-[28%]
                    lg:left-[3%]
                    lg:w-[17%]

                    xl:top-[28%]
                    xl:left-[3%]
                    xl:w-[17%]

                    2xl:top-[28%]
                    2xl:left-[3%]
                    2xl:w-[17%]
                "
            />

            <img
                src="/heart.svg"
                alt=""
                class="
                    pointer-events-none
                    absolute
                    top-[-1%]
                    right-[15.5%]
                    z-30
                    w-[23%]
                    rotate-30
                    opacity-90

                    min-[380px]:top-[-1%]
                    min-[380px]:right-[15.5%]
                    min-[380px]:w-[23%]

                    min-[480px]:top-[-1%]
                    min-[480px]:right-[14%]
                    min-[480px]:w-[21%]

                    sm:top-[-1%]
                    sm:right-[13%]
                    sm:w-[19%]

                    md:top-[-1%]
                    md:right-[12.5%]
                    md:w-[18.5%]

                    lg:top-[-1%]
                    lg:right-[12%]
                    lg:w-[18%]

                    xl:top-[-1%]
                    xl:right-[12%]
                    xl:w-[18%]

                    2xl:top-[-1%]
                    2xl:right-[12%]
                    2xl:w-[18%]
                "
            />

            <img
                src="/heart.svg"
                alt=""
                class="
                    pointer-events-none
                    absolute
                    top-[40%]
                    right-[3.9%]
                    z-10
                    w-[26%]
                    rotate-30
                    opacity-90

                    min-[380px]:top-[40%]
                    min-[380px]:right-[3.9%]
                    min-[380px]:w-[26%]

                    min-[480px]:top-[40%]
                    min-[480px]:right-[3.5%]
                    min-[480px]:w-[23%]

                    sm:top-[40%]
                    sm:right-[3.2%]
                    sm:w-[21%]

                    md:top-[40%]
                    md:right-[3.1%]
                    md:w-[20.5%]

                    lg:top-[40%]
                    lg:right-[3%]
                    lg:w-[20%]

                    xl:top-[40%]
                    xl:right-[3%]
                    xl:w-[20%]

                    2xl:top-[40%]
                    2xl:right-[3%]
                    2xl:w-[20%]
                "
            />

            <div
                class="
                    absolute
                    top-[6%]
                    left-1/2
                    z-20
                    w-[86%]
                    max-w-[520px]
                    -translate-x-1/2
                    rounded-2xl
                    border
                    border-borderstrokeline
                    bg-backgroundprimary
                    p-4
                    shadow-sm

                    min-[380px]:top-[5.5%]
                    min-[380px]:w-[84%]
                    min-[380px]:p-4

                    min-[480px]:top-[5.5%]
                    min-[480px]:w-[80%]
                    min-[480px]:p-5

                    sm:top-[5%]
                    sm:w-[72%]
                    sm:p-6

                    md:top-[5%]
                    md:w-[70%]
                    md:p-6

                    lg:top-[5%]
                    lg:w-[68%]
                    lg:p-6

                    xl:top-[5%]
                    xl:w-[68%]
                    xl:p-6

                    2xl:top-[5%]
                    2xl:w-[68%]
                    2xl:p-6
                "
            >
                <slot />
            </div>
        </div>

        <img
            src="/donatiebox.svg"
            alt="Donatiebox"
            class="
                pointer-events-none
                relative
                z-10
                mx-auto
                block
                w-[var(--donatiebox-width)]
                mt-[var(--donatiebox-overlap)]
            "
        />
    </section>
</template>
