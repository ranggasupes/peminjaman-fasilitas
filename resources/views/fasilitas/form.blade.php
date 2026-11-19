
@php
    $isAdmin = $isAdmin ?? false;
@endphp

<div class="fasilitas-form-grid">

    {{-- INSTANSI --}}
    <div class="fasilitas-form-field">

        <label for="instansi_id">
            Instansi <span>*</span>
        </label>

        @if ($isAdmin)

            {{-- Admin hanya melihat instansinya sendiri --}}
            <input
                type="text"
                value="{{ $instansi->first()->nama_instansi ?? 'Instansi belum tersedia' }}"
                readonly>

        @else

            {{-- Super Admin dapat memilih seluruh instansi --}}
            <select name="instansi_id" id="instansi_id" required>

                <option value="">-- Pilih Instansi --</option>

                @foreach ($instansi as $dataInstansi)

                    <option
                        value="{{ $dataInstansi->id }}"
                        @selected(old('instansi_id', $fasilitas?->instansi_id) == $dataInstansi->id)>

                        {{ $dataInstansi->nama_instansi }}

                    </option>

                @endforeach

            </select>

        @endif

    </div>

    {{-- NAMA FASILITAS --}}
    <div class="fasilitas-form-field">

        <label for="nama_fasilitas">
            Nama Fasilitas <span>*</span>
        </label>

        <input
            type="text"
            id="nama_fasilitas"
            name="nama_fasilitas"
            value="{{ old('nama_fasilitas', $fasilitas?->nama_fasilitas) }}"
            placeholder="Contoh: Gedung Olahraga"
            required>

    </div>

    {{-- TARIF --}}
    <div class="fasilitas-form-field">

        <label for="tarif">
            Tarif (Rp) <span>*</span>
        </label>

        <input
            type="number"
            id="tarif"
            name="tarif"
            value="{{ old('tarif', $fasilitas?->tarif ?? 0) }}"
            min="0"
            step="0.01"
            required>

    </div>

    {{-- LOKASI --}}
    <div class="fasilitas-form-field">

        <label for="lokasi">Lokasi</label>

        <input
            type="text"
            id="lokasi"
            name="lokasi"
            value="{{ old('lokasi', $fasilitas?->lokasi) }}"
            placeholder="Contoh: Kota Palu, Sulawesi Tengah">

    </div>

    {{-- DESKRIPSI --}}
    <div class="fasilitas-form-field fasilitas-form-full">

        <label for="deskripsi">Deskripsi Fasilitas</label>

        <textarea
            id="deskripsi"
            name="deskripsi"
            rows="4"
            placeholder="Jelaskan fungsi dan kondisi fasilitas">{{ old('deskripsi', $fasilitas?->deskripsi) }}</textarea>

    </div>

    {{-- PERSYARATAN --}}
    <div class="fasilitas-form-field fasilitas-form-full">

        <label for="persyaratan">Persyaratan Peminjaman</label>

        <textarea
            id="persyaratan"
            name="persyaratan"
            rows="3"
            placeholder="Tuliskan persyaratan peminjaman">{{ old('persyaratan', $fasilitas?->persyaratan) }}</textarea>

    </div>

    {{-- JADWAL --}}
    <div class="fasilitas-form-field fasilitas-form-full">

        <label for="jadwal_operasional">Jadwal Operasional</label>

        <textarea
            id="jadwal_operasional"
            name="jadwal_operasional"
            rows="3"
            placeholder="Contoh: Senin–Jumat, 08.00–16.00">{{ old('jadwal_operasional', $fasilitas?->jadwal_operasional) }}</textarea>

    </div>

    {{-- FOTO --}}
    <div class="fasilitas-form-field">

        <label for="foto">Foto Fasilitas</label>

        <input
            type="file"
            id="foto"
            name="foto"
            accept=".jpg,.jpeg,.png,.webp">

        <small>Format JPG, PNG, atau WEBP. Maksimal 2 MB.</small>

        @if ($fasilitas?->foto)

            <img
                src="{{ asset('storage/' . $fasilitas->foto) }}"
                alt="Foto fasilitas saat ini"
                class="fasilitas-form-preview">

            <small>Unggah foto baru jika ingin mengganti foto saat ini.</small>

        @endif

    </div>

    {{-- TEMPLATE SURAT --}}
    <div class="fasilitas-form-field">

        <label for="template_surat">Template Surat</label>

        <input
            type="file"
            id="template_surat"
            name="template_surat"
            accept=".pdf,.doc,.docx">

        <small>Format PDF, DOC, atau DOCX. Maksimal 5 MB.</small>

        @if ($fasilitas?->template_surat)

            <p class="fasilitas-current-file">
                Template surat sudah tersedia.
            </p>

        @endif

    </div>

    {{-- STATUS --}}
    <div class="fasilitas-form-field">

        <label for="aktif">
            Status Fasilitas <span>*</span>
        </label>

        <select name="aktif" id="aktif" required>

            <option
                value="1"
                @selected((string) old('aktif', $fasilitas?->aktif ?? 1) === '1')>
                Aktif
            </option>

            <option
                value="0"
                @selected((string) old('aktif', $fasilitas?->aktif ?? 1) === '0')>
                Nonaktif
            </option>

        </select>

    </div>

</div>
