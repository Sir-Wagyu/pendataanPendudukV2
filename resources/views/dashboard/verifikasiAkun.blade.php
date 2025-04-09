<x-Layout>
        <h2 class="font-semibold text-xl text-warna-300 leading-tight mt-10 mb-6">
            Verifikasi Akun
        </h2>
      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
            <table
                class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400 border-collapse border border-gray-200">
                <thead class="text-xs text-warna-200 uppercase bg-warna-400/80 ">
                    <tr>
                        <th scope="col" class="px-10 py-3   ">
                            No
                        </th>
                        <th scope="col" class="px-10 py-3   ">
                            Status Verifikasi
                        </th>
                        <th scope="col"
                            class="px-10 py-4  whitespace-nowrap  sticky left-0 bg-warna-400  border-r border-warna-200">
                            Nama Lengkap
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Email
                        </th>
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Kontak
                        </th>
                        
                        <th scope="col" class="px-10 py-4  whitespace-nowrap ">
                            Aksi
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="bg-white border-b text-warna-300 border-gray-200">
                        @foreach ($users as $user )
                            <td class="px-10 py-3   ">
                                1
                            </td>
                            <td class="px-10 py-3   ">
                                {{ $user->is_verified ? 'Terverifikasi' : 'Belum Terverifikasi' }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap sticky left-0 bg-white  font-medium">
                                {{ $user->name }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap  ">
                                {{ $user->email }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap  ">
                                {{ $user->kontak }}
                            </td>
                            <td class="px-10 py-3 whitespace-nowrap flex flex-col gap-1">
                                <form action="{{ route('ubahStatus', $user->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="cursor-pointer font-semibold text-warna-600 underline">Ubah Status</button>
                                </form>
                            </td>
                        @endforeach
                    </tr>
                </tbody>
            </table>
        </div>
</x-Layout>