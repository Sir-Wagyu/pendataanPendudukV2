<x-Layout>
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mt-10 mb-6">
            Verifikasi Akun
        </h2>
        @if(session('success'))
            <div class="bg-green-100 text-green-800 px-4 py-2 rounded-md mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 text-red-800 px-4 py-2 rounded-md mb-4">
                {{ session('error') }}
            </div>
        @endif
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200 bg-warna-100">
                <thead class="text-xs text-warna-300 uppercase border-b-2 border-gray-200 ">
                    <tr>
                        <th scope="col" class="px-10 py-3  whitespace-nowrap  sticky left-0 bg-white  border-r border-warna-200 ">
                            No
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap  sticky left-23 bg-white border-r border-warna-200">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-3   ">
                            Status Verifikasi
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap  ">
                            NIK
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Email
                        </th>

                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b text-warna-300 border-gray-200">
                        @forelse ($users as $user)
                            <td class="px-10 py-3 whitespace-nowrap sticky left-0 bg-white font-medium">
                                {{ $loop->iteration }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap sticky left-23 bg-white font-medium">
                                {{ $user->name }}
                            </td>
                            <td class="px-10 py-3">
                                {{ $user->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $user->email }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap">
                                {{ $user->telepon }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap flex flex-col gap-1">
                                <form action="{{ route('ubahStatus', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" name="status" value="approved">
                                        <i class="fa-solid fa-square-check text-3xl text-warna-600 active:scale-95 transition-all mr-1 cursor-pointer"></i>
                                    </button>
                                    <button type="submit" name="status" value="rejected">
                                        <i class="fa-solid fa-square-xmark text-3xl text-warna-800 active:scale-95 transition-all cursor-pointer"></i>
                                    </button>
                                </form>
                            </td>
                        @empty
                            <td colspan="6" class="px-10 py-3 text-base text-center text-gray-500">
                                Tidak ada data yang tersedia
                            </td>
                        @endforelse
                    </tr>
                </tbody>
            </table>
        </div>

        <h2 class="font-semibold text-xl text-warna-300 leading-tight mt-10 mb-6">
            Akun Terdaftar
        </h2>
</x-Layout>