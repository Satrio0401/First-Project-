<?php
// filepath: app\Imports\AnggotaImport.php
namespace App\Imports;

use App\Models\Anggota;
use App\Models\Jurusan;
use Carbon\Carbon;
use EightyNine\ExcelImport\EnhancedDefaultImport;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithValidation;
use Maatwebsite\Excel\Concerns\SkipsOnFailure;
use Maatwebsite\Excel\Validators\Failure;
use Maatwebsite\Excel\Concerns\SkipsFailures;

class AnggotaImport implements ToModel, WithHeadingRow, WithValidation, SkipsOnFailure
{
    use SkipsFailures;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $tempat = null;
        $tanggal = null;

        if (!empty($row['ttl'])) {
            $value = trim($row['ttl']);
            $parts = strpos($value, ',') !== false ? explode(',', $value, 2) : preg_split('/\s+(?=\d)/', $value, 2);
            $tempat = trim($parts[0] ?? '');
            try {
                // Coba parsing dengan format d/m/Y atau format lain yang umum
                $tanggal = Carbon::parse(trim($parts[1] ?? ''))->format('Y-m-d');
            } catch (\Exception $e) {
                $tanggal = null; // Gagal parsing, set null
            }
        }

        $kelamin = null;
        if (!empty($row['jenis_kelamin'])) {
            $val = strtolower(trim($row['jenis_kelamin']));
            $kelamin = match (true) {
                in_array($val, ['l', 'laki', 'laki-laki']) => 'Laki-laki',
                in_array($val, ['p', 'perempuan']) => 'Perempuan',
                default => null,
            };
        }

        $jurusanId = null;
        // Maatwebsite/excel akan mengubah 'jurusan/program studi' menjadi 'jurusanprogram_studi'
        if (!empty($row['jurusanprogram_studi'])) {
            $jurusan = Jurusan::where('nama_jurusan', 'LIKE', '%' . $row['jurusanprogram_studi'] . '%')->first();
            $jurusanId = $jurusan?->id;
        }

        return new Anggota([
            'nama'                => $row['nama'] ?? null,
            'kelamin'             => $kelamin,
            'tempat_lahir'        => $tempat,
            'tanggal_lahir'       => $tanggal,
            'alamat'              => $row['alamat'] ?? null,
            'no_wa'               => $row['no_hpwa'] ?? null,
            'tahun_masuk_kuliah'  => $row['tahun_masuk_kuliah'] ?? null,
            'jurusan_id'          => $jurusanId,
        ]);
    }

    public function rules(): array
    {
        return [
            'nama' => 'required|max:255',
            'jenis_kelamin' => 'required',
        ];
    }

    public function customValidationMessages()
    {
        return [
            'nama.required' => 'Kolom nama tidak boleh kosong.',
            'jenis_kelamin.required' => 'Kolom jenis kelamin tidak boleh kosong.',
        ];
    }

    
}