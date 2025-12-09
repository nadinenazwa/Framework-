@extends('layouts.lte.main')

@section('title', 'Pets')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1>Pets</h1>
        <a href="{{ route('resepsionis.pets.create') }}" class="btn btn-primary">Create Pet</a>
    </div>

    <table class="table table-striped">
        <thead>
            <tr>
                @foreach($columns ?? ['idpet','nama'] as $col)
                    @if(\Illuminate\Support\Str::contains($col, 'deleted'))
                        @continue
                    @endif
                    @php
                        $header = ucfirst(str_replace('_',' ', $col));
                        if ($col == 'idpemilik') $header = 'Owner';
                        if ($col == 'idras_hewan') $header = 'Breed';
                        if ($col == 'tanggal_lahir') $header = 'Tanggal lahir';
                    @endphp
                    <th>{{ $header }}</th>
                @endforeach
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($pets ?? [] as $pet)
                <tr>
                    @foreach($columns ?? ['idpet','nama'] as $col)
                        @if(\Illuminate\Support\Str::contains($col, 'deleted'))
                            @continue
                        @endif
                        @php
                            $value = data_get($pet, $col);
                        @endphp
                        @if($col == 'idras_hewan')
                            <td>{{ optional($pet->rasHewan)->nama_ras ?? '-' }}</td>
                        @elseif($col == 'idpemilik')
                            <td>{{ optional(optional($pet->pemilik)->user)->nama ?? optional($pet->pemilik)->no_wa ?? '-' }}</td>
                        @elseif($col == 'tanggal_lahir')
                            <td>{{ optional($pet->tanggal_lahir)->format('Y-m-d') ?? '-' }}</td>
                        @else
                            <td>{{ is_null($value) ? '-' : (string) $value }}</td>
                        @endif
                    @endforeach
                    <td>
                        <a href="{{ route('resepsionis.pets.edit', $pet->idpet) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('resepsionis.pets.destroy', $pet->idpet) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger" onclick="return confirm('Hapus pet?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    @if(method_exists($pets ?? null, 'links'))
        {{ $pets->links() }}
    @endif
</div>
@endsection
