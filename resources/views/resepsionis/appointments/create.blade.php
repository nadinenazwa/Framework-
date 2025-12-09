@extends('layouts.lte.main')

@section('title', 'Create Appointment')

@section('content')
<div class="container">
    <h1>Create Appointment</h1>

    <form action="{{ route('resepsionis.appointments.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label for="idpemilik" class="form-label">Owner</label>
            <select name="idpemilik" id="idpemilik" class="form-control">
                <option value="">-- Select Owner --</option>
                @foreach($owners ?? [] as $owner)
                    <option value="{{ $owner->idpemilik }}" {{ old('idpemilik') == $owner->idpemilik ? 'selected' : '' }}>
                        {{ optional($owner->user)->nama ?? $owner->no_wa }} (ID: {{ $owner->idpemilik }})
                    </option>
                @endforeach
            </select>
            @error('idpemilik')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="idpet" class="form-label">Pet</label>
            <select name="idpet" id="idpet" class="form-control">
                <option value="">-- Select Pet --</option>
                @foreach($pets ?? [] as $pet)
                    <option value="{{ $pet->idpet }}" {{ old('idpet') == $pet->idpet ? 'selected' : '' }}>
                        {{ $pet->nama ?? 'Pet '.$pet->idpet }} (ID: {{ $pet->idpet }})
                    </option>
                @endforeach
            </select>
            @error('idpet')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label for="idrole_user" class="form-label">Doctor</label>
            <select name="idrole_user" id="idrole_user" class="form-control">
                <option value="">-- Select Doctor --</option>
                @foreach($dokters ?? [] as $dok)
                    <option value="{{ $dok->idrole_user }}" {{ old('idrole_user') == $dok->idrole_user ? 'selected' : '' }}>
                        {{ optional($dok->user)->nama ?? ('RoleUser '.$dok->idrole_user) }}
                    </option>
                @endforeach
            </select>
            @error('idrole_user')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="mb-3">
            <label class="form-label">Waktu Daftar</label>
            <input type="text" class="form-control" value="(akan diisi otomatis)" disabled>
            <small class="form-text text-muted">Waktu daftar akan diisi otomatis dengan waktu server saat membuat janji.</small>
        </div>
        
        <button class="btn btn-primary">Save</button>
        <a href="{{ route('resepsionis.appointments.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
    </div>

    <script>
        (function(){
            // Mapping ownerId => [{idpet,nama}, ...]
            const petsByOwner = @json($petsByOwner ?? []);

            const ownerSelect = document.getElementById('idpemilik');
            const petSelect = document.getElementById('idpet');

            function populatePets(ownerId) {
                // Clear
                petSelect.innerHTML = '';
                const empty = document.createElement('option');
                empty.value = '';
                empty.textContent = '-- Select Pet --';
                petSelect.appendChild(empty);

                if (!ownerId) return;

                const list = petsByOwner[ownerId] || [];
                list.forEach(function(p){
                    const opt = document.createElement('option');
                    opt.value = p.idpet;
                    opt.textContent = (p.nama || ('Pet ' + p.idpet)) + ' (ID: ' + p.idpet + ')';
                    petSelect.appendChild(opt);
                });
            }

            ownerSelect && ownerSelect.addEventListener('change', function(e){
                populatePets(e.target.value);
            });

            // On load, if an owner is already selected (old input), populate pets
            document.addEventListener('DOMContentLoaded', function(){
                const initialOwner = ownerSelect ? ownerSelect.value : null;
                if (initialOwner) {
                    populatePets(initialOwner);
                    // try to preserve previously selected pet
                    const oldPet = "{{ old('idpet') }}";
                    if (oldPet) {
                        petSelect.value = oldPet;
                    }
                }
            });
        })();
    </script>

@endsection
