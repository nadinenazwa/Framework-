<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>No WA</th>
                <th>Alamat</th>
                <th>User</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pemilik as $item)
            <tr>
                <td>{{ $item->idpemilik }}</td>
                <td>{{ $item->no_wa }}</td>
                <td>{{ $item->alamat }}</td>
                <td>{{ $item->user->nama ?? 'N/A' }}</td>
                </td>
            </tr>
            @endforeach
        </tbody>
