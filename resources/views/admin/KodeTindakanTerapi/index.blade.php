<a href="{{ route('admin.kodetindakanterapi.create') }}" style="display: inline-block; margin-bottom: 15px; padding: 10px 20px; background-color: #007bff; color: white; text-decoration: none; border-radius: 5px;">Tambah Kode Tindakan Terapi</a>

    @if(session('success'))
        <div style="padding: 10px; margin-bottom: 15px; background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; border-radius: 5px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="padding: 10px; margin-bottom: 15px; background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; border-radius: 5px;">
            {{ session('error') }}
        </div>
    @endif

    <table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>No</th>
                <th>Kode</th>
                <th>Deskripsi Tindakan Terapi</th>
                <th>Kategori</th>
                <th>Kategori Klinis</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($kodeTindakanTerapi as $index => $item)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                <td>{{ $item->kode }}</td>
                <td>{{ $item->deskripsi_tindakan_terapi }}</td>
                <td>{{ $item->kategori->nama_kategori ?? 'N/A' }}</td>
                <td>{{ $item->kategoriKlinis->nama_kategori_klinis ?? 'N/A' }}</td>
                <td style="text-align: center; padding: 10px;">
                    <a href="{{ route('admin.kodetindakanterapi.edit', $item->idkode_tindakan_terapi) }}" style="display: inline-block; padding: 5px 15px; background-color: #ffc107; color: white; text-decoration: none; border-radius: 3px; margin-right: 5px;">Edit</a>
                    <form action="{{ route('admin.kodetindakanterapi.destroy', $item->idkode_tindakan_terapi) }}" method="POST" style="display: inline-block;" onsubmit="return confirm('Yakin ingin menghapus data ini?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="padding: 5px 15px; background-color: #dc3545; color: white; border: none; border-radius: 3px; cursor: pointer;">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" style="text-align: center; padding: 10px;">Belum ada data kode tindakan terapi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>