@include('pemilik.profile.index')
                            <th>Jenis Kelamin</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse(Auth::user()->pemilik->pets as $index => $pet)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pet->nama }}</td>
                            <td>{{ $pet->rasHewan->jenisHewan->nama_jenis_hewan ?? 'N/A' }}</td>
                            <td>{{ $pet->rasHewan->nama_ras ?? 'N/A' }}</td>
                            <td>{{ $pet->jenis_kelamin == 'J' ? 'Jantan' : 'Betina' }}</td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Anda belum mendaftarkan pet.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection