<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Kode</th>
                <th>Deskripsi Tindakan Terapi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kodeTindakanTerapi as $item)
            <tr>
                <td>{{ $item->idkode_tindakan_terapi }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->deskripsi_tindakan_terapi }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'N/A' }}</td>
                <td>{{ $item->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>