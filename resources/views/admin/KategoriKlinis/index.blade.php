<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Kategori Klinis</th>
            </tr>
        </thead>
        <tbody>
            @foreach($kategoriKlinis as $item)
            <tr>
                <td>{{ $item->idkategori_klinis }}</td>
                <td>{{ $item->nama_kategori_klinis }}</td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
