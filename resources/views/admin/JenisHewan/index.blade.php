<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr style="background-color: #f2f2f2;">
                <th style="padding: 10px;">ID</th>
                <th style="padding: 10px;">Nama Jenis Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($jenisHewan as $item)
            <tr>
                <td style="text-align: center;">{{ $item->idjenis_hewan }}</td>
                <td style="padding: 10px;">{{ $item->nama_jenis_hewan }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="2" style="text-align: center; padding: 10px;">Belum ada data jenis hewan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>