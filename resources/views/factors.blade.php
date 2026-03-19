<div x-data="{
        editMode: false,
        formAction: '{{ route('factors.store', $evaluation->id) }}',
        factorName: '{{ old('name') }}',
        factorPercentage: '{{ old('percentage') }}',
        factorColumn: '{{ old('excel_column') }}',
        factorHits: '{{ old('total_hits') }}',

        showDeleteModal: false,
        deleteAction: '',

        // Function to handle clicking 'Edit'
        editFactor(factor) {
            this.editMode = true;
            this.formAction = '/evaluations/{{ $evaluation->id }}/factors/' + factor.id;
            this.factorName = factor.name;
            this.factorPercentage = parseFloat(factor.percentage);
            this.factorColumn = factor.excel_column;
            this.factorHits = parseFloat(factor.total_hits);
            window.scrollTo({ top: 0, behavior: 'smooth' });
        },

        // Function to cancel editing
        cancelEdit() {
            this.editMode = false;
            this.formAction = '{{ route('factors.store', $evaluation->id) }}';
            this.factorName = '';
            this.factorPercentage = '';
            this.factorColumn = '';
            this.factorHits = '';
        },

        // Function to trigger delete modal
        confirmDelete(url) {
            this.deleteAction = url;
            this.showDeleteModal = true;
        }
    }"
    class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ $returnTo }}" class="flex h-10 w-10 items-center justify-center rounded-full border border-stroke bg-white hover:bg-gray-100 dark:border-strokedark dark:bg-boxdark dark:hover:bg-boxdark-2 transition">
                <svg class="h-5 w-5 fill-current text-black dark:text-white" viewBox="0 0 24 24"><path d="M20 11H7.83l5.59-5.59L12 4l-8 8 8 8 1.41-1.41L7.83 13H20v-2z"></path></svg>
            </a>
            <h2 class="text-title-md2 font-bold text-black dark:text-white">
                Factores: <span class="text-primary">{{ $evaluation->name }}</span>
            </h2>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-3 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30">
            <h5 class="text-lg font-bold text-black dark:text-[#34D399]">{{ session('success') }}</h5>
        </div>
    @endif

    <div class="mb-8 rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark flex justify-between items-center">
            <h3 class="font-medium text-black dark:text-white" x-text="editMode ? 'Editar Factor' : 'Nuevo Factor'"></h3>
            <button x-show="editMode" @click="cancelEdit()" type="button" class="text-sm text-red-500 hover:text-red-700">Cancelar Edición</button>
        </div>

        <form :action="formAction" method="POST">
            @csrf
            <template x-if="editMode">
                <input type="hidden" name="_method" value="PUT">
            </template>

            <div class="p-6.5 grid grid-cols-1 md:grid-cols-4 gap-4 items-start">
                <div>
                    <label class="mb-2 block text-sm text-black dark:text-white">Nombre <span class="text-red-500">*</span></label>
                    <input type="text" name="name" x-model="factorName" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-4 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input">
                    @error('name') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-black dark:text-white">Porcentaje (0-100) <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="percentage" x-model="factorPercentage" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-4 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input">
                    @error('percentage') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-black dark:text-white">Columna Excel <span class="text-red-500">*</span></label>
                    <input type="number" name="excel_column" x-model="factorColumn" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-4 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input">
                    @error('excel_column') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>

                <div>
                    <label class="mb-2 block text-sm text-black dark:text-white">Puntos Totales <span class="text-red-500">*</span></label>
                    <input type="number" step="0.01" name="total_hits" x-model="factorHits" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-4 py-2 outline-none focus:border-primary dark:border-form-strokedark dark:bg-form-input">
                    @error('total_hits') <span class="text-xs text-red-500 mt-1 block">{{ $message }}</span> @enderror
                </div>
            </div>

            <div class="px-6.5 pb-6">
                <button type="submit" class="w-full sm:w-auto flex justify-center rounded bg-primary px-8 py-2 font-medium text-white hover:bg-opacity-90 transition">
                    <span x-text="editMode ? 'Actualizar Factor' : 'Guardar Factor'"></span>
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">
        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Nombre</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Porcentaje</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Columna Excel</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Puntos Totales</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($factors as $factor)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white">{{ $factor->name }}</td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white">{{ floatval($factor->percentage) }}%</td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white">{{ $factor->excel_column }}</td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-black dark:text-white">{{ floatval($factor->total_hits) }}</td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark text-right">
                                <button @click="editFactor({{ json_encode($factor) }})" class="text-sm rounded border border-primary text-primary px-3 py-1 hover:bg-primary hover:text-white transition mr-2">Editar</button>

                                <button @click="confirmDelete('/evaluations/{{ $evaluation->id }}/factors/{{ $factor->id }}')" class="text-sm rounded bg-red-500 px-3 py-1 text-white hover:bg-red-600 transition">Eliminar</button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="border-b border-[#eee] px-4 py-5 text-center dark:border-strokedark text-gray-500">
                                No se han agregado factores a esta evaluación.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div x-show="showDeleteModal" style="display: none;" class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 px-4 py-5">
        <div @click.outside="showDeleteModal = false" class="w-full max-w-md rounded-lg bg-white px-8 py-12 text-center dark:bg-boxdark">
            <h3 class="pb-2 text-xl font-bold text-black dark:text-white sm:text-2xl">Confirmar Eliminación</h3>
            <p class="mb-10 text-gray-500">¿Estás seguro de que deseas eliminar este factor? Esta acción no se puede deshacer.</p>

            <div class="flex flex-wrap justify-center gap-4">
                <button @click="showDeleteModal = false" class="rounded border border-stroke px-6 py-2 font-medium text-black transition hover:shadow-1 dark:border-strokedark dark:text-white">
                    Cancelar
                </button>
                <form :action="deleteAction" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="rounded bg-red-500 px-6 py-2 font-medium text-white transition hover:bg-red-600">
                        Sí, Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

</div>
