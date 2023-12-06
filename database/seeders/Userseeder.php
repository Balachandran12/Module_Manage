<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class Userseeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = [
            [
                'name' => 'demo',
                'email' => 'demo@gmail.com',
                'password' => 'demo'
            ],
        ];
        foreach($user as $users){
            User::create($users);
        }
    }
}
