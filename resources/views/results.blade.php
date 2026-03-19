<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ $returnTo }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white hover:bg-gray-100 dark:border-strokedark dark:bg-boxdark dark:hover:bg-boxdark-2 transition">
                <svg class="h-5 w-5 fill-current text-black dark:text-white" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </a>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Resultados: <span class="text-primary">{{ $evaluation->name }}</span>
            </h2>
        </div>

        <a href="{{ route('evaluations.export_results', $evaluation->id) }}" class="flex items-center gap-2 rounded bg-[#10B981] px-6 py-2 font-medium text-white hover:bg-[#059669] transition">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path></svg>
            Exportar XLS
        </a>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white whitespace-nowrap">Matrícula</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white whitespace-nowrap">Nombre</th>

                        @foreach($factors as $factor)
                            <th class="px-4 py-4 font-medium text-black dark:text-white whitespace-nowrap text-center">
                                {{ $factor->name }}<br>
                                <span class="text-xs text-gray-500 font-normal">({{ floatval($factor->percentage) }}%)</span>
                            </th>
                        @endforeach

                        <th class="px-4 py-4 font-bold text-primary dark:text-primary whitespace-nowrap text-right border-l border-stroke dark:border-strokedark">Calificación Final</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white">{{ $student->identifier }}</td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white whitespace-nowrap">{{ $student->name }}</td>

                            @foreach($factors as $factor)
                                <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white text-center">
                                    {{ $student->factors[$factor->id] ?? 0 }}
                                    <span class="text-xs text-gray-500">/ {{ floatval($factor->total_hits) }}</span>
                                </td>
                            @endforeach

                            <td class="border-b border-[#eee] border-l border-stroke dark:border-strokedark px-4 py-5 text-right font-bold {{ $student->final_score >= 70 ? 'text-[#10B981]' : 'text-red-500' }}">
                                {{ $student->final_score }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="{{ count($factors) + 3 }}" class="border-b border-[#eee] px-4 py-5 text-center dark:border-strokedark text-gray-500">
                                No hay resultados calculados. Por favor, importa un archivo Excel primero.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
