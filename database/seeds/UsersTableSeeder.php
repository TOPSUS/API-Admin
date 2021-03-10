<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        if (env('APP_ENV') != 'production') {
            $password = Hash::make('admin');

            for ($i = 0; $i < 1; $i++) {
                $users[] = [
                    'nama' => 'admin',
                    'alamat' => 'jakarta',
                    'jeniskelamin' => 'Laki-laki',
                    'nohp' => '085155185533',
                    'email' => 'admin@admin.com',
                    'chat_id' => 'admin',
                    'pin' => '110201',
                    'password' => $password,
                    'foto' => 'admin',
                    'role' => 'Admin',
                    'fcm_token' => 'admin',
                    'token_login' => 'admin',
                    'id_speedboat' => 0
                ];
            }

            User::insert($users);
        }
    }
}
