<div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Estudiantes
        </h2>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

        <form method="GET" action="{{ url('/students') }}" class="mb-6 flex items-center gap-4">
            <div class="relative w-full max-w-md">
                <input
                    type="text"
                    name="search"
                    value="{{ $searchTerm }}"
                    placeholder="Buscar estudiante por nombre..."
                    class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-2 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary"
                >
            </div>
            <button type="submit" class="flex justify-center rounded bg-primary px-6 py-2 font-medium text-gray hover:bg-opacity-90 text-white">
                Buscar
            </button>

            @if($searchTerm)
                <a href="{{ url('/students') }}" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                    Limpiar
                </a>
            @endif
        </form>

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white xl:px-8">Matrícula (ID)</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white xl:px-8">Nombre</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white xl:px-8">Fecha de Registro</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($students as $student)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark xl:px-8">
                                <p class="text-black dark:text-white">{{ $student->student_identifier }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark xl:px-8">
                                <p class="text-black dark:text-white">{{ $student->name }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark xl:px-8">
                                <p class="text-black dark:text-white">{{ $student->created_at->format('d/m/Y') }}</p>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="border-b border-[#eee] px-4 py-5 text-center dark:border-strokedark xl:px-8">
                                <p class="text-gray-500">No se encontraron estudiantes.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="py-4">
            {{ $students->links() }}
        </div>

    </div>
</div>
