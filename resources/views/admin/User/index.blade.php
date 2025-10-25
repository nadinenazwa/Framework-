<table border="1" cellpadding="8" cellspacing="8">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama</th>
                <th>Email</th>
                <th>Roles</th>
            </tr>
        </thead>
        <tbody>
            @foreach($user as $item)
            <tr>
                <td>{{ $item->iduser }}</td>
                <td>{{ $item->nama }}</td>
                <td>{{ $item->email }}</td>
                <td>
                    @foreach($item->roles as $role)
                        {{ $role->nama_role }},
                    @endforeach
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>