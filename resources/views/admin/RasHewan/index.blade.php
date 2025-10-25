<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Ras</th>
                <th>Jenis Hewan</th>
            </tr>
        </thead>
        <tbody>
            @foreach($rasHewan as $item)
            <tr>
                <td>{{ $item->idras_hewan }}</td>
                <td>{{ $item->nama_ras }}</td>
                <td>{{ $item->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>