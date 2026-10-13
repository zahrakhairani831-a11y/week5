<?php

namespace App\Http\Controllers;

abstract class Controller
{
    // pesan validasi bahasa Indonesia, dipakai semua controller
    protected function pesan(): array
    {
        return [
            'required' => ':attribute wajib diisi.',
            'unique'   => ':attribute sudah dipakai.',
            'max'      => ':attribute maksimal :max karakter.',
            'numeric'  => ':attribute harus berupa angka.',
            'integer'  => ':attribute harus berupa bilangan bulat.',
            'min'      => ':attribute minimal :min.',
            'exists'   => ':attribute yang dipilih tidak valid.',
            'email'    => 'Format :attribute tidak valid.',
            'in'       => ':attribute yang dipilih tidak valid.',
        ];
    }
}
