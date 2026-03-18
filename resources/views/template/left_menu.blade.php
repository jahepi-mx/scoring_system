<aside class="absolute left-0 top-0 z-999 flex h-screen w-72 flex-col overflow-y-hidden bg-boxdark duration-300 ease-linear lg:static lg:translate-x-0">

    <div class="flex items-center justify-between gap-2 px-6 py-6 border-b border-strokedark">
        <a href="{{ url('/') }}" class="flex items-center gap-2 text-2xl font-bold text-white">
            <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.26 10.147a60.436 60.436 0 00-.491 6.347A48.627 48.627 0 0112 20.904a48.627 48.627 0 018.232-4.41 60.46 60.46 0 00-.491-6.347m-15.482 0a50.57 50.57 0 00-2.658-.813A59.905 59.905 0 0112 3.493a59.902 59.902 0 0110.399 5.84c-.896.248-1.783.52-2.658.814m-15.482 0A50.697 50.697 0 0112 13.489a50.702 50.702 0 017.74-3.342M6.75 15a.75.75 0 100-1.5.75.75 0 000 1.5zm0 0v-3.675A55.378 55.378 0 0112 8.443m-7.007 11.55A5.981 5.981 0 006.75 15.75v-1.5"></path>
            </svg>
            <span>Scoring<span class="text-primary">Sys</span></span>
        </a>
    </div>

    <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
        <nav class="mt-5 px-4 py-4 lg:mt-2 lg:px-6">

            <div>
                <h3 class="mb-4 ml-4 text-sm font-semibold text-bodydark2">MENU</h3>

                <ul class="mb-6 flex flex-col gap-1.5">
                    <li>
                        <a href="{{ url('/students') }}"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark2 transition-all duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->is('students*') ? 'bg-boxdark-2 text-white' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 002.625.372 9.337 9.337 0 004.121-.952 4.125 4.125 0 00-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 018.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0111.964-3.07M12 6.375a3.375 3.375 0 11-6.75 0 3.375 3.375 0 016.75 0zm8.25 2.25a2.625 2.625 0 11-5.25 0 2.625 2.625 0 015.25 0z"></path>
                            </svg>
                            Estudiantes
                        </a>
                    </li>

                    <li>
                        <a href="{{ url('/evaluations') }}"
                           class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium text-bodydark2 transition-all duration-300 ease-in-out hover:bg-boxdark-2 hover:text-white {{ request()->is('evaluations*') ? 'bg-boxdark-2 text-white' : '' }}">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Evaluaciones
                        </a>
                    </li>
                </ul>
            </div>

        </nav>
    </div>
</aside>
