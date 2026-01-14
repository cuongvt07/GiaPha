<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;

class FamilySeeder extends Seeder
{
    public function run(): void
    {
        // === THẾHỆ 1: TỔ TIÊN ===
        $root = Person::create([
            'name' => 'Nguyễn Quý Tổ',
            'gender' => 'male',
            'date_of_birth' => '1850-01-01',
            'date_of_death' => '1920-01-01',
            'is_alive' => false,
            'nickname' => 'Cụ Tổ',
        ]);

        // === THẾ HỆ 2: CON (3 người - 3 nhánh) ===
        $gen2_1 = Person::create([
            'father_id' => $root->id,
            'name' => 'Nguyễn Văn Cả',
            'gender' => 'male',
            'date_of_birth' => '1880-01-01',
            'date_of_death' => '1950-01-01',
            'is_alive' => false,
            'nickname' => 'Ông Cả',
        ]);

        $gen2_2 = Person::create([
            'father_id' => $root->id,
            'name' => 'Nguyễn Văn Hai',
            'gender' => 'male',
            'date_of_birth' => '1885-01-01',
            'date_of_death' => '1960-01-01',
            'is_alive' => false,
            'nickname' => 'Ông Hai',
        ]);

        $gen2_3 = Person::create([
            'father_id' => $root->id,
            'name' => 'Nguyễn Thị Ba',
            'gender' => 'female',
            'date_of_birth' => '1890-01-01',
            'is_alive' => true,
            'nickname' => 'Bà Ba',
        ]);

        // === THẾ HỆ 3: CHÁU (8 người) ===
        // Nhánh Ông Cả (3 người)
        $gen3_1 = Person::create([
            'father_id' => $gen2_1->id,
            'name' => 'Nguyễn Văn Đích',
            'gender' => 'male',
            'date_of_birth' => '1910-01-01',
            'date_of_death' => '1980-01-01',
            'is_alive' => false,
        ]);

        $gen3_2 = Person::create([
            'father_id' => $gen2_1->id,
            'name' => 'Nguyễn Thị Lan',
            'gender' => 'female',
            'date_of_birth' => '1912-01-01',
            'is_alive' => true,
        ]);

        $gen3_3 = Person::create([
            'father_id' => $gen2_1->id,
            'name' => 'Nguyễn Văn Minh',
            'gender' => 'male',
            'date_of_birth' => '1915-01-01',
            'is_alive' => true,
        ]);

        // Nhánh Ông Hai (3 người)
        $gen3_4 = Person::create([
            'father_id' => $gen2_2->id,
            'name' => 'Nguyễn Văn Tứ',
            'gender' => 'male',
            'date_of_birth' => '1920-01-01',
            'is_alive' => true,
        ]);

        $gen3_5 = Person::create([
            'father_id' => $gen2_2->id,
            'name' => 'Nguyễn Văn Năm',
            'gender' => 'male',
            'date_of_birth' => '1925-01-01',
            'is_alive' => true,
        ]);

        $gen3_6 = Person::create([
            'father_id' => $gen2_2->id,
            'name' => 'Nguyễn Thị Sáu',
            'gender' => 'female',
            'date_of_birth' => '1928-01-01',
            'is_alive' => true,
        ]);

        // Nhánh Bà Ba (2 người - con của bà)
        $gen3_7 = Person::create([
            'mother_id' => $gen2_3->id,
            'name' => 'Trần Văn Bảy',
            'gender' => 'male',
            'date_of_birth' => '1930-01-01',
            'is_alive' => true,
        ]);

        $gen3_8 = Person::create([
            'mother_id' => $gen2_3->id,
            'name' => 'Trần Thị Tám',
            'gender' => 'female',
            'date_of_birth' => '1935-01-01',
            'is_alive' => true,
        ]);

        // === THẾ HỆ 4: CHẮT (12 người) ===
        // Con của Nguyễn Văn Đích (3 người)
        $gen4_1 = Person::create([
            'father_id' => $gen3_1->id,
            'name' => 'Nguyễn Văn An',
            'gender' => 'male',
            'date_of_birth' => '1945-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_1->id,
            'name' => 'Nguyễn Thị Bình',
            'gender' => 'female',
            'date_of_birth' => '1948-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_1->id,
            'name' => 'Nguyễn Văn Cường',
            'gender' => 'male',
            'date_of_birth' => '1950-01-01',
            'is_alive' => true,
        ]);

        // Con của Nguyễn Văn Minh (2 người)
        $gen4_4 = Person::create([
            'father_id' => $gen3_3->id,
            'name' => 'Nguyễn Văn Dũng',
            'gender' => 'male',
            'date_of_birth' => '1952-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_3->id,
            'name' => 'Nguyễn Thị Hoa',
            'gender' => 'female',
            'date_of_birth' => '1955-01-01',
            'is_alive' => true,
        ]);

        // Con của Nguyễn Văn Tứ (3 người)
        $gen4_6 = Person::create([
            'father_id' => $gen3_4->id,
            'name' => 'Nguyễn Văn Phong',
            'gender' => 'male',
            'date_of_birth' => '1958-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_4->id,
            'name' => 'Nguyễn Văn Quang',
            'gender' => 'male',
            'date_of_birth' => '1960-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_4->id,
            'name' => 'Nguyễn Thị Hương',
            'gender' => 'female',
            'date_of_birth' => '1962-01-01',
            'is_alive' => true,
        ]);

        // Con của Nguyễn Văn Năm (2 người)
        Person::create([
            'father_id' => $gen3_5->id,
            'name' => 'Nguyễn Văn Tâm',
            'gender' => 'male',
            'date_of_birth' => '1965-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_5->id,
            'name' => 'Nguyễn Thị Linh',
            'gender' => 'female',
            'date_of_birth' => '1968-01-01',
            'is_alive' => true,
        ]);

        // Con của Trần Văn Bảy (2 người)
        Person::create([
            'father_id' => $gen3_7->id,
            'name' => 'Trần Văn Nam',
            'gender' => 'male',
            'date_of_birth' => '1970-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen3_7->id,
            'name' => 'Trần Thị Mai',
            'gender' => 'female',
            'date_of_birth' => '1972-01-01',
            'is_alive' => true,
        ]);

        // === THẾ HỆ 5: CHÍT (6 người) ===
        Person::create([
            'father_id' => $gen4_1->id,
            'name' => 'Nguyễn Văn Khoa',
            'gender' => 'male',
            'date_of_birth' => '1990-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen4_1->id,
            'name' => 'Nguyễn Thị Ngọc',
            'gender' => 'female',
            'date_of_birth' => '1992-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen4_4->id,
            'name' => 'Nguyễn Văn Long',
            'gender' => 'male',
            'date_of_birth' => '1995-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen4_6->id,
            'name' => 'Nguyễn Văn Tuấn',
            'gender' => 'male',
            'date_of_birth' => '1998-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen4_6->id,
            'name' => 'Nguyễn Thị Thảo',
            'gender' => 'female',
            'date_of_birth' => '2000-01-01',
            'is_alive' => true,
        ]);

        Person::create([
            'father_id' => $gen4_6->id,
            'name' => 'Nguyễn Văn Đạt',
            'gender' => 'male',
            'date_of_birth' => '2002-01-01',
            'is_alive' => true,
        ]);
    }
}
