<?php 
namespace App\Imports;

use App\Models\Anggota;
use App\Models\Jurusan;
use pxlrbt\FilamentExcel\Imports\Importer;
use pxlrbt\FilamentExcel\Imports\Importable;
use Carbon\Carbon;

class AnggotaImport extends Importer
{
    use Importable;

    public static function getColumns(): array
    {
        return [
            'nama',
            'ttl',
            'jenis kelamin',
            'alamat',
            'no hp/wa',
            'tahun masuk kuliah',
            'jurusan/program studi',
        ];
    }

    public function model(array $row)
    {
        $tempat = null;
        $tanggal = null;

        /**
         * TTL
         */
        if (!empty($row['ttl'])) {
            $value = trim($row['ttl']);

            if (strpos($value, ',') !== false) {
                $parts = explode(',', $value);
            } else {
                $parts = preg_split('/\s+(?=\d)/', $value, 2);
            }

            $tempat = trim($parts[0] ?? '');
            $tanggalRaw = trim($parts[1] ?? '');

            if ($tanggalRaw !== '') {
                try {
                    // jika numeric (format Excel)
                    if (is_numeric($tanggalRaw)) {
                        $tanggal = Carbon::createFromTimestamp(($tanggalRaw - 25569) * 86400)->format('Y-m-d');
                    } else {
                        $tanggal = Carbon::parse($tanggalRaw)->format('Y-m-d');
                    }
                } catch (\Exception $e) {
                    $tanggal = null;
                }
            }
        }

        /**
         * Kelamin
         */
        $kelamin = null;
        if (!empty($row['jenis kelamin'])) {
            $val = strtolower(trim($row['jenis kelamin']));
            $kelamin = in_array($val, ['l', 'laki', 'laki-laki']) ? 'Laki-laki'
                      : (in_array($val, ['p', 'perempuan']) ? 'Perempuan' : null);
        }

        /**
         * Jurusan
         */
        $jurusanId = null;
        if (!empty($row['jurusan/program studi'])) {
            $search = strtolower($row['jurusan/program studi']);
            $jurusan = Jurusan::whereRaw('LOWER(nama) LIKE ?', ["%$search%"])->first();
            $jurusanId = $jurusan?->id;
        }

        return new Anggota([
            'nama'                => $row['nama'] ?? null,
            'kelamin'             => $kelamin,
            'tempat_lahir'        => $tempat,
            'tanggal_lahir'       => $tanggal,
            'alamat'              => $row['alamat'] ?? null,
            'no_wa'               => $row['no hp/wa'] ?? null,
            'tahun_masuk_kuliah'  => $row['tahun masuk kuliah'] ?? null,
            'jurusan_id'          => $jurusanId,
        ]);
    }
}