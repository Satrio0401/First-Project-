<?php

namespace App\Policies;

use App\Models\Anggota;
use App\Models\User;

class AnggotaPolicy
{
    // Super Admin bisa melakukan segalanya
    public function before(User $user, string $ability): bool|null
    {
        if ($user->hasRole('Super Admin')) {
            return true;
        }
        return null; // Lanjutkan ke pengecekan ability lain
    }

    // Siapa yang bisa melihat daftar anggota?
    public function viewAny(User $user): bool
    {
        // Admin Komisariat bisa melihat daftar anggotanya sendiri
        return $user->hasAnyRole(['Admin Komisariat','Anggota']);
    }

    // Siapa yang bisa melihat detail satu anggota?
    public function view(User $user, Anggota $anggota): bool
    {
        // Admin Komisariat hanya bisa lihat anggota dari komisariatnya
        if ($user->hasRole('Admin Komisariat')) {
            return $user->anggota?->komisariat_id === $anggota->komisariat_id;
        }
        if ($user->hasRole('Anggota')) {
            // Anggota bisa lihat semua, KECUALI yang rolenya 'Admin Komisariat'
            return !$anggota->user?->hasAnyRole(['Admin Komisariat','Super Admin']);
        }
        return false;
    }

    // Siapa yang bisa membuat anggota baru?
    public function create(User $user): bool
    {
        return $user->hasRole('Admin Komisariat');
    }

    // Siapa yang bisa mengedit anggota?
    public function update(User $user, Anggota $anggota): bool
    {
        // Admin Komisariat hanya bisa edit anggota dari komisariatnya
        if ($user->hasRole('Admin Komisariat')) {
            return $user->anggota?->komisariat_id === $anggota->komisariat_id;
        }
        return false;
    }

    // Siapa yang bisa menghapus anggota?
    public function delete(User $user, Anggota $anggota): bool
    {
        // Admin Komisariat hanya bisa hapus anggota dari komisariatnya
        if ($user->hasRole('Admin Komisariat')) {
            return $user->anggota?->komisariat_id === $anggota->komisariat_id;
        }
        return false;
    }
}