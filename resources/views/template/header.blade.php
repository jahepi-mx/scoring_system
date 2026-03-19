<header class="sticky top-0 z-999 flex w-full bg-white shadow-sm dark:bg-boxdark dark:drop-shadow-none">
    <div class="flex flex-grow items-center justify-between px-4 py-4 md:px-6 2xl:px-11">

        <div class="flex items-center gap-2 sm:gap-4 lg:hidden">

            <button @click.stop="sidebarOpen = !sidebarOpen" class="z-99999 block rounded-sm border border-stroke bg-white p-1.5 shadow-sm lg:hidden">
                <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5"></path>
                </svg>
            </button>

            <span class="text-xl font-bold text-black">ScoringSys</span>
        </div>

        <div class="hidden lg:block"></div>

    </div>
</header>
