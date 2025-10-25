<table border="1" cellpadding="8" cellspacing="8">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nama Kategori</th>
                </tr>
            </thead>
            <tbody>
                {{-- Loop data kategori yang akan diterima dari Controller --}}
                @forelse ($kategori as $row)
                <tr>
                    <td>{{ $row->idkategori }}</td>
                    <td>{{ htmlspecialchars($row->nama_kategori) }}</td>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="3" style="text-align: center;">Belum ada data kategori.</td>
                </tr>
                @endforelse
            </tbody>
        </table>