<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Tanggal Lahir</th>
                <th>Warna Tanda</th>
                <th>Jenis Kelamin</th>
                <th>Pemilik</th>
                <th>Ras Hewan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($pets as $pet)
                <tr>
                    <td>{{ $pet->idpet }}</td>
                    <td>{{ $pet->nama }}</td>
                    <td>{{ $pet->tanggal_lahir ? $pet->tanggal_lahir->format('d-m-Y') : '-' }}</td>
                    <td>{{ $pet->warna_tanda }}</td>
                    <td>{{ $pet->jenis_kelamin }}</td>
                    <td>{{ $pet->pemilik->user->nama ?? 'N/A' }}</td>
                    <td>{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No pets found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>