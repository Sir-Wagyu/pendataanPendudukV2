<div class="space-y-4">
    {{-- Provinsi --}}
    <div>
        <label>Provinsi</label>
        <select wire:model="provinsi" class="w-full border px-3 py-2">
            <option value="">-- Pilih Provinsi --</option>
            @foreach($provinsiList as $prov)
                <option value="{{ $prov['id'] }}">{{ $prov['name'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Kabupaten --}}
    <div>
        <label>Kabupaten/Kota</label>
        <select wire:model="kabupaten" class="w-full border px-3 py-2">
            <option value="">-- Pilih Kabupaten/Kota --</option>
            @foreach($kabupatenList as $kab)
                <option value="{{ $kab['id'] }}">{{ $kab['name'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Kecamatan --}}
    <div>
        <label>Kecamatan</label>
        <select wire:model="kecamatan" class="w-full border px-3 py-2">
            <option value="">-- Pilih Kecamatan --</option>
            @foreach($kecamatanList as $kec)
                <option value="{{ $kec['id'] }}">{{ $kec['name'] }}</option>
            @endforeach
        </select>
    </div>

    {{-- Kelurahan --}}
    <div>
        <label>Kelurahan</label>
        <select wire:model="kelurahan" class="w-full border px-3 py-2">
            <option value="">-- Pilih Kelurahan --</option>
            @foreach($kelurahanList as $kel)
                <option value="{{ $kel['id'] }}">{{ $kel['name'] }}</option>
            @endforeach
        </select>
    </div>
</div>
