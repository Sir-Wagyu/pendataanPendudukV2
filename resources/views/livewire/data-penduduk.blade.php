<div>
    <form action="" class="w-full lg:w-1/2 mx-auto mt-5">
        <input type="text" wire:model="search" placeholder="Cari Nama Warga"
            class="border border-gray-400 rounded-lg px-4 py-2 w-full ">
    </form>
    
    @if (Auth::user()->role == 'admin')
    <div class="mt-6 mb-4 w-full overflow-x-auto">
        <div class="flex gap-3 justify-between md:justify-center w-max text-sm  mx-auto">
            <button wire:click="setTable('warga')"
            class="px-10 py-4 text-nowrap {{ $table === 'warga' ? 'bg-warna-400/30' : 'bg-warna-400/20' }} hover:bg-warna-400/30 rounded-lg shadow border-gray-400 active:scale-95 transition-all">
            Data Warga
        </button>
        <button wire:click="setTable('kepala')"
        class="px-10 py-4 text-nowrap {{ $table === 'kepala' ? 'bg-warna-400/30' : 'bg-warna-400/20' }} hover:bg-warna-400/30 rounded-lg shadow border-gray-400 active:scale-95 transition-all">
        Data Kepala Lingkungan
    </button>
    <button wire:click="setTable('penanggung')"
    class="px-10 py-4 text-nowrap {{ $table === 'penanggung' ? 'bg-warna-400/30' : 'bg-warna-400/20' }} hover:bg-warna-400/30 rounded-lg shadow border-gray-400 active:scale-95 transition-all">
    Data Penanggung Jawab
</button>
</div>
</div>
@endif




    <div class="mb-4 flex justify-between items-center">

        <p class="text-lg md:text-2xl font-semibold">
            @if($table === 'warga')
            Data Warga Terdaftar
            @elseif($table === 'kepala')
            Data Kepala Lingkungan
            @elseif($table === 'penanggung')
            Data Penanggung Jawab
            @endif
        </p>
        <button data-modal-target="crud-modal" data-modal-toggle="crud-modal"
            class="w-9 md:w-11 h-9 md:h-11 bg-warna-500 rounded-lg flex justify-center items-center text-white shadow-lg hover:bg-warna-500/80 active:scale-95 transition-all">
            <i class="fa-solid fa-user-plus md:text-lg "></i>
        </button>
    </div>

    <!-- content -->
    @if($table === 'warga')
    @include('dashboard.dataTable.tableWarga')
    @elseif($table === 'kepala')
    @include('dashboard.dataTable.tableKepala')
    @elseif($table === 'penanggung')
    @include('dashboard.dataTable.tablePenanggung')
    @endif


    <!-- modal -->
    <div id="crud-modal" tabindex="-1" aria-hidden="true"
        class=" hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full md:w-[80%] lg:max-w-2xl max-h-full">
            <!-- Modal content -->
            <div class="relative bg-white rounded-lg shadow-sm ">
                <!-- Modal header -->
                <div
                    class="flex items-center justify-between p-4 md:px-5 md:pt-7 md:pb-3 border-b rounded-t  border-gray-200">
                    <h3 class="text-lg font-semibold text-gray-900 ">
                        @if($table === 'warga')
                        Tambah Data Penduduk
                        @elseif ($table === 'kepala')
                        Tambah Data Kepala Lingkungan
                        @elseif ($table === 'penanggung')
                        Tambah Data Penanggung Jawab
                        @endif
                    </h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center hover:bg-gray-300 transition-all"
                        data-modal-toggle="crud-modal">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form class="p-4 md:px-5 md:pt-0 md:pb-5">
                    <div class="w-full h-95 overflow-y-auto mb-10">
                        <div class="w-full px-1 h-max">
                            <div class="grid gap-4 mb-4 grid-cols-2 mt-4">
                                <x-input-text name="nama" label="nama_lengkap" placeholder="Nama Lengkap" />
                                <x-input-text name="NIK" label="NIK" placeholder="NIK" type="number" />
                                <x-input-text name="email" label="email" placeholder="Email" type="email" />
                                @if($table === 'warga')

                                <x-input-text width="col-span-2 md:col-span-1" name="tempat_lahir" label="tempat_lahir"
                                    placeholder="Tempat Lahir" type="text" />
                                <x-input-text width="col-span-2 md:col-span-1" name="tanggal_lahir"
                                    label="tanggal_lahir" placeholder="Tanggal Lahir" type="date" />

                                <x-input-text name="jenis_kelamin" label="Jenis Kelamin" :options="[
                                        ['value' => 'Laki - Laki', 'text' => 'Laki - Laki'], 
                                        ['value' => 'Perempuan', 'text' => 'Perempuan']
                                    ]" type="radio" placeholder="Jenis Kelamin" />
                                <x-input-text name="alamat_asal" label="alamat_asal" placeholder="Alamat Asal"
                                    type="text" />
                                <x-input-text name="alamat_sekarang" label="alamat_sekarang"
                                    placeholder="Alamat Sekarang" type="text" />

                                @elseif($table === 'kepala')
                                <x-input-text name="wilayah_tugas" label="wilayah_tugas" placeholder="Wilayah Tugas"
                                    type="text" />
                                <x-input-text name="no_telp" label="Nomor telepon" placeholder="Nomor Telepon"
                                    type="number" />
                                @elseif($table === 'penanggung')
                                <x-input-text name="alamat_tinggal" label="alamat_tinggal" placeholder="Alamat Tinggal"
                                    type="text" />
                                <x-input-text name="jenis_penanggung_jawab" label="jenis_penanggung_jawab"
                                    placeholder="Jenis Penanggung Jawab" type="select" :select="[
                                        ['value' => 'pemilik_kos', 'text' => 'Pemilik Kos'], 
                                        ['value' => 'pemilik_kontrakan', 'text' => 'Pemilik Kontrakan'],
                                        ['value' => 'Lainnya', 'text' => 'Lainnya']
                                    ]" />
                                @endif
                            </div>
                        </div>
                    </div>
                    <button type="submit"
                        class="text-white inline-flex items-center bg-warna-400 hover:bg-warna-400/90 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center">
                        <svg class="me-1 -ms-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 5a1 1 0 011 1v3h3a1 1 0 110 2h-3v3a1 1 0 11-2 0v-3H6a1 1 0 110-2h3V6a1 1 0 011-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Tambah Data
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>