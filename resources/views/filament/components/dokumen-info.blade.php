<div>
    @if ($keperluan)
        <div class="p-4 mb-4 text-sm text-blue-700 bg-blue-100 rounded-lg dark:bg-blue-200 dark:text-blue-800"
            role="alert">
            <h4 class="text-lg font-medium">Dokumen yang perlu dilampirkan:</h4>
            <ul class="list-disc list-inside">
                @switch($keperluan)
                    @case('Surat Keterangan Tidak Mampu')
                        <li>Fotokopi KTP</li>
                        <li>Fotokopi Kartu Keluarga</li>
                        <li>Foto rumah</li>
                    @break

                    @case('Surat Izin Usaha')
                        <li>Fotokopi KTP</li>
                        <li>Fotokopi Kartu Keluarga</li>
                        <li>Fotokopi NPWP</li>
                        <li>Foto Lokasi Usaha</li>
                    @break

                    @case('Surat Keterangan Domisili')
                        <li>Fotokopi KTP</li>
                        <li>Fotokopi Kartu Keluarga</li>
                    @break

                    @default
                        <li>Fotokopi KTP</li>
                        <li>Dokumen pendukung lainnya sesuai keperluan</li>
                @endswitch
            </ul>
        </div>
    @endif
</div>
