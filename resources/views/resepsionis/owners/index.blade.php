@extends('layouts.lte.main')

@section('title', 'Owners')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Owners</h1>
        <a href="{{ route('resepsionis.owners.create') }}" class="btn btn-primary">Create Owner</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Owner Name</th>
                <th>No WA</th>
                <th>Alamat</th>
                <th>Pets</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($owners ?? [] as $owner)
                <tr>
                    <td>{{ $owner->idpemilik }}</td>
                    <td>{{ optional($owner->user)->nama ?? '-' }}</td>
                    <td>{{ $owner->no_wa }}</td>
                    <td>{{ $owner->alamat }}</td>
                    <td>
                        @php
                            $petNames = $owner->pets->pluck('nama')->filter()->join(', ');
                        @endphp
                        {{ $petNames ?: '-' }}
                    </td>
                    <td>
                        <a href="{{ route('resepsionis.owners.edit', $owner->idpemilik) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('resepsionis.owners.destroy', $owner->idpemilik) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus owner?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    {{-- pagination jika tersedia --}}
    @if(method_exists($owners ?? null, 'links'))
        {{ $owners->links() }}
    @endif
</div>
@endsection
