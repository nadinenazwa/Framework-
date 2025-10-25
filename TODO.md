# TODO: Implement Eloquent Models with Relationships

## Completed Tasks
- [x] Analyze SQL dump for table structures and relationships
- [x] Create comprehensive plan for model updates/creations

## Pending Tasks
- [x] Modify app/Models/User.php: Set table to 'user', primary key to 'iduser', fillable to ['nama', 'email', 'password'], add hasOne Pemilik, belongsToMany Role through 'role_user'
- [x] Create app/Models/JenisHewan.php: Table 'jenis_hewan', pk 'idjenis_hewan', fillable ['nama_jenis_hewan'], hasMany RasHewan
- [x] Create app/Models/Kategori.php: Table 'kategori', pk 'idkategori', fillable ['nama_kategori'], hasMany KodeTindakanTerapi
- [x] Create app/Models/KategoriKlinis.php: Table 'kategori_klinis', pk 'idkategori_klinis', fillable ['nama_kategori_klinis'], hasMany KodeTindakanTerapi
- [x] Create app/Models/KodeTindakanTerapi.php: Table 'kode_tindakan_terapi', pk 'idkode_tindakan_terapi', fillable ['kode', 'deskripsi_tindakan_terapi', 'idkategori', 'idkategori_klinis'], belongsTo Kategori, belongsTo KategoriKlinis, hasMany DetailRekamMedis
- [x] Create app/Models/Pet.php: Table 'pet', pk 'idpet', fillable ['nama', 'tanggal_lahir', 'warna_tanda', 'jenis_kelamin', 'idpemilik', 'idras_hewan'], belongsTo Pemilik, belongsTo RasHewan, hasMany RekamMedis
- [x] Create app/Models/RasHewan.php: Table 'ras_hewan', pk 'idras_hewan', fillable ['nama_ras', 'idjenis_hewan'], belongsTo JenisHewan, hasMany Pet
- [x] Create app/Models/Role.php: Table 'role', pk 'idrole', fillable ['nama_role'], belongsToMany User through 'role_user'
- [x] Create app/Models/Pemilik.php: Table 'pemilik', pk 'idpemilik', fillable ['no_wa', 'alamat', 'iduser'], belongsTo User, hasMany Pet
- [x] Create app/Models/RekamMedis.php: Table 'rekam_medis', pk 'idrekam_medis', fillable ['created_at', 'anamnesa', 'temuan_klinis', 'diagnosa', 'idpet', 'dokter_pemeriksa'], belongsTo Pet, belongsTo RoleUser, hasMany DetailRekamMedis
- [x] Create app/Models/DetailRekamMedis.php: Table 'detail_rekam_medis', pk 'iddetail_rekam_medis', fillable ['idrekam_medis', 'idkode_tindakan_terapi', 'detail'], belongsTo RekamMedis, belongsTo KodeTindakanTerapi
- [x] Create app/Models/RoleUser.php: Table 'role_user', pk 'idrole_user', fillable ['iduser', 'idrole', 'status'], belongsTo User, belongsTo Role

## Followup Steps
- [x] Verify models by checking relationships and fillable properties
- [x] Run php artisan tinker to test relations if needed
