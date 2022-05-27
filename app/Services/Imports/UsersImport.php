<?php

namespace App\Services\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithValidation;

class UsersImport implements ToModel, WithHeadingRow, WithValidation
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     * create user data into database
     */
    public function model(array $row)
    {
        return new User([
            'name' => $row['name'],
            'email' => $row['email'],
            'password' => Hash::make($row['password'])
        ]);
    }

    /**
     * return validation messages
     */
    public function rules(): array
    {
        return [
            'name' => 'required',

            // Above is alias for as it always validates in batches
            '*.name' => 'required',

            'email' => 'required',

            // Above is alias for as it always validates in batches
            '*.email' => 'required|email|unique:users',

            'password' => 'required',

            // Above is alias for as it always validates in batches
            '*.password' => 'required|min:8|regex:/^(?=.*?[A-Z])(?=.*?[a-z])(?=.*?[0-9])(?=.*?[#?!@$%^&*-]).{6,}$/',
        ];
    }
}
