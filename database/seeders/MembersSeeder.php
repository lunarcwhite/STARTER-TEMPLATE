<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as faker;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class MembersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $user = User::all();
        foreach ($user as $item) {
                    $id = $item['id'];
                    $email = $item['email'];
                            DB::table('members')->insert([
                                'no_reg' => rand(0000000000 , 9999999999),
                                'nama' => $faker->name,
                                'tempat_lahir' => $faker->city,
                                'tanggal_lahir' => $faker->date,
                                'jenis_kelamin' => $faker->randomElement(['Laki - Laki' , 'Perempuan']),
                                'no_telp' => rand(00000000000, 20000000000),
                                'alamat' => $faker->address,
                                'kode_pos' => $faker->postcode,
                                'user_id' => $id,
                            ]);

                        }
    }
}
