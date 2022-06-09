<?php

namespace App\Services\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UsersExportService implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     * collect all user data
     */
    public function collection()
    {
        return User::all();
    }

    /**
     * dowload all user data with headers
     */
    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'Email',
            'email_verified_at',
            'Password',
            'Type',
            'Disable',
            'Updated_at',
            'Created_at'
        ];
    }
}
