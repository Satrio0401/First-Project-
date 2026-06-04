<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Anggota extends Model
{
    use HasFactory;

    protected $fillable = [
        'nama',
        'foto',
        'alamat',
        'kelamin',
        'tempat_lahir',
        'tanggal_lahir',
        'no_wa',
        'tahun_masuk_kuliah',
        'jurusan_id',
        'tahun_lk1',
        'komisariat_id',
        'tahun_lk2',
        'cabang_lk2',
        'tahun_lk3',
        'badko_lk3',
        'tahun_lkk',
        'cabang_lkk',
        'prestasi',
        'latitude',
        'longitude',
    ];
    // protected $guarded = [];

    public function user()
    {
        return $this->hasOne(User::class, 'anggota_id');
    }


    public function jurusan()
    {
        return $this->belongsTo(Jurusan::class);
    }

    // Relasi ke Komisariat
    public function komisariat()
    {
        return $this->belongsTo(Komisariat::class);
    }

    use LogsActivity;

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly([
                'nama',
                'kelamin',
                'jurusan_id',
                'komisariat_id',
                'no_wa',
                'alamat',
                'tahun_lk1',
                // kolom lain yang mau ditrack
            ])
            ->logOnlyDirty()           // hanya log kalau ada perubahan
            ->dontSubmitEmptyLogs()    // jangan log kalau tidak ada yg berubah
            ->setDescriptionForEvent(fn(string $eventName) => match ($eventName) {
                'created' => 'Anggota baru ditambahkan',
                'updated' => 'Data anggota diperbarui',
                'deleted' => 'Anggota dihapus',
                default   => $eventName,
            });
    }
}
