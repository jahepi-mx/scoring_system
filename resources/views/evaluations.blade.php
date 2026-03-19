<div x-data="excelUploader()" class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

    <div class="mb-6">
        <h2 class="text-title-md2 font-bold text-black dark:text-white">
            Evaluaciones
        </h2>
    </div>

    @if(session('success'))
        <div class="mb-6 flex w-full border-l-6 border-[#34D399] bg-[#34D399] bg-opacity-[15%] px-7 py-3 shadow-md dark:bg-[#1B1B24] dark:bg-opacity-30">
            <div class="w-full">
                <h5 class="text-lg font-bold text-black dark:text-[#34D399]">
                    {{ session('success') }}
                </h5>
            </div>
        </div>
    @endif

    <div class="mb-8 rounded-sm border border-stroke bg-white shadow-default dark:border-strokedark dark:bg-boxdark">
        <div class="border-b border-stroke px-6.5 py-4 dark:border-strokedark">
            <h3 class="font-medium text-black dark:text-white">Nueva Evaluación</h3>
        </div>
        <form action="{{ route('evaluations.store') }}" method="POST">
            @csrf
            <div class="p-6.5 flex items-end gap-4">
                <div class="w-full xl:w-1/2">
                    <label class="mb-2.5 block text-black dark:text-white">Nombre de la Evaluación</label>
                    <input type="text" name="name" placeholder="Ej. Examen Final 2026" class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-3 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">

                    @error('name')
                        <span class="text-sm text-red-500 mt-1 block">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="flex justify-center rounded bg-primary p-3 font-medium text-gray hover:bg-opacity-90 text-white">
                    Crear Evaluación
                </button>
            </div>
        </form>
    </div>

    <div class="rounded-sm border border-stroke bg-white px-5 pb-2.5 pt-6 shadow-default dark:border-strokedark dark:bg-boxdark sm:px-7.5 xl:pb-1">

        <form method="GET" action="{{ url('/evaluations') }}" class="mb-6 flex items-center gap-4">
            <div class="relative w-full max-w-md">
                <input type="text" name="search" value="{{ $searchTerm }}" placeholder="Buscar evaluación..." class="w-full rounded border-[1.5px] border-stroke bg-transparent px-5 py-2 font-medium outline-none transition focus:border-primary active:border-primary disabled:cursor-default disabled:bg-whiter dark:border-form-strokedark dark:bg-form-input dark:focus:border-primary">
            </div>
            <button type="submit" class="flex justify-center rounded bg-primary px-6 py-2 font-medium text-gray hover:bg-opacity-90 text-white">
                Buscar
            </button>
            @if($searchTerm)
                <a href="{{ url('/evaluations') }}" class="flex justify-center rounded border border-stroke px-6 py-2 font-medium text-black hover:shadow-1 dark:border-strokedark dark:text-white">
                    Limpiar
                </a>
            @endif
        </form>

        <div class="max-w-full overflow-x-auto">
            <table class="w-full table-auto">
                <thead>
                    <tr class="bg-gray-2 text-left dark:bg-meta-4">
                        <th class="px-4 py-4 font-medium text-black dark:text-white">ID</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Nombre</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Fecha de Creación</th>
                        <th class="px-4 py-4 font-medium text-black dark:text-white">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($evaluations as $evaluation)
                        <tr>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $evaluation->id }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $evaluation->name }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <p class="text-black dark:text-white">{{ $evaluation->created_at->format('d/m/Y') }}</p>
                            </td>
                            <td class="border-b border-[#eee] px-4 py-5 dark:border-strokedark">
                                <div class="flex items-center space-x-3.5">
                                    <a href="{{ route('factors.index', ['evaluation' => $evaluation->id, 'return_to' => request()->fullUrl()]) }}" class="text-sm rounded bg-blue-500 px-3 py-1 text-white hover:bg-blue-600 transition">Factores</a>

                                    <button @click="openModal({{ $evaluation->id }}, '{{ $evaluation->name }}')" class="flex items-center gap-1 text-sm rounded bg-[#10B981] px-3 py-1 text-white hover:bg-[#059669] transition">
                                        Importar Excel
                                        @if($evaluation->has_data)
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"></path></svg>
                                        @endif
                                    </button>

                                    <a href="{{ route('evaluations.results', ['evaluation' => $evaluation->id, 'return_to' => request()->fullUrl()]) }}" class="text-sm rounded bg-purple-500 px-3 py-1 text-white hover:bg-purple-600 transition">Resultados</a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="border-b border-[#eee] px-4 py-5 text-center dark:border-strokedark">
                                <p class="text-gray-500">No hay evaluaciones registradas.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="py-4">
            {{ $evaluations->links() }}
        </div>

    </div>


    <div x-show="showModal" style="display: none;" class="fixed inset-0 z-99999 flex items-center justify-center bg-black/50 px-4 py-5">
        <div @click.outside="closeModal()" class="w-full max-w-md rounded-lg bg-white p-8 dark:bg-boxdark relative">

            <button @click="closeModal()" class="absolute top-4 right-4 text-gray-500 hover:text-black dark:hover:text-white">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>

            <h3 class="mb-2 text-xl font-bold text-black dark:text-white">Importar Datos</h3>
            <p class="mb-6 text-sm text-gray-500" x-text="'Evaluación: ' + evaluationName"></p>

            <div x-show="successMessage" class="mb-4 rounded bg-green-100 p-3 text-sm text-green-700 border border-green-200" x-text="successMessage"></div>
            <div x-show="errorMessage" class="mb-4 rounded bg-red-100 p-3 text-sm text-red-700 border border-red-200" x-text="errorMessage"></div>

            <form @submit.prevent="uploadFile">
                <div class="mb-6">
                    <label class="mb-2.5 block text-black dark:text-white">Seleccionar archivo Excel (.xls, .xlsx)</label>
                    <input type="file" x-ref="fileInput" accept=".xls,.xlsx,.csv" class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2 px-3 font-medium outline-none transition focus:border-primary active:border-primary dark:border-form-strokedark dark:bg-form-input">
                </div>

                <button type="submit" :disabled="isUploading" class="w-full flex justify-center rounded bg-primary p-3 font-medium text-white hover:bg-opacity-90 transition disabled:opacity-50">
                    <span x-show="!isUploading">Subir y Procesar</span>
                    <span x-show="isUploading">Procesando archivo...</span>
                </button>
            </form>
        </div>
    </div>

</div>

<script>
    document.addEventListener('alpine:init', () => {
        Alpine.data('excelUploader', () => ({
            showModal: false,
            evaluationId: null,
            evaluationName: '',
            isUploading: false,
            successMessage: '',
            errorMessage: '',

            openModal(id, name) {
                this.evaluationId = id;
                this.evaluationName = name;
                this.showModal = true;
                this.successMessage = '';
                this.errorMessage = '';
                if(this.$refs.fileInput) this.$refs.fileInput.value = '';
            },

            closeModal() {
                this.showModal = false;
            },

            async uploadFile() {
                this.isUploading = true;
                this.errorMessage = '';
                this.successMessage = '';

                let file = this.$refs.fileInput.files[0];
                if (!file) {
                    this.errorMessage = 'Por favor selecciona un archivo primero.';
                    this.isUploading = false;
                    return;
                }

                let formData = new FormData();
                formData.append('file', file);
                formData.append('_token', '{{ csrf_token() }}');

                try {
                    let response = await fetch(`/evaluations/${this.evaluationId}/import`, {
                        method: 'POST',
                        body: formData,
                        headers: { 'Accept': 'application/json' }
                    });

                    let data = await response.json();

                    if (!response.ok) {
                        throw new Error(data.message || 'Error al procesar el archivo.');
                    }

                    this.successMessage = data.message;
                    setTimeout(() => { window.location.reload(); }, 2000);
                } catch (error) {
                    this.errorMessage = error.message;
                } finally {
                    this.isUploading = false;
                }
            }
        }));
    });
</script>
