<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Person;
use App\Models\Marriage;
use Illuminate\Support\Facades\DB;

class LargeScaleFamilySeeder extends Seeder
{
    private $generationNames = [
        1 => 'Thủy Tổ',
        2 => 'Viễn Tổ',
        3 => 'Tiên Tổ',
        4 => 'Cao Tổ',
        5 => 'Tằng Tổ',
        6 => 'Nội Tổ',
    ];

    public function run(): void
    {
        // Clear existing data safely
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('people')->truncate();
        DB::table('marriages')->truncate();
        DB::table('generations')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->command->info('Cleared existing people, marriages, and generations.');

        // Create Generations 1-10
        for ($i = 1; $i <= 10; $i++) {
            DB::table('generations')->insert([
                'id' => $i,
                'generation_number' => $i,
                'generation_name' => "Đời " . $i,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // 1. Generation 1
        $root = Person::create([
            'name' => 'Nguyễn Quý Tổ High (Đời 1)',
            'gender' => 'male',
            'date_of_birth' => '1840-01-01',
            'date_of_death' => '1910-01-01',
            'is_alive' => false,
            'nickname' => 'Cụ Tổ',
            'generation_id' => 1,
        ]);

        $this->createSpouse($root);

        // 2. Generation 2
        // We create 3 children for the root.
        // One child will have 6 children to test the vertical layout in Gen 3.
        
        $childrenGen2 = [
            ['name' => 'Nguyễn Văn Cả (Đời 2)', 'child_count' => 3], 
            ['name' => 'Nguyễn Văn Hai (Đời 2)', 'child_count' => 2],
            ['name' => 'Nguyễn Thị Ba (Đời 2)', 'child_count' => 2],
        ];

        foreach ($childrenGen2 as $index => $data) {
            $child = Person::create([
                'father_id' => $root->id,
                'name' => $data['name'],
                'gender' => ($index < 2) ? 'male' : 'female',
                'date_of_birth' => (1870 + ($index * 5)) . '-01-01',
                'is_alive' => false,
                'generation_id' => 2,
            ]);

            if ($child->gender === 'male') {
                $this->createSpouse($child);
            }

            $this->seedDescendants($child, 3, $data['child_count'], 1900 + ($index * 10));
        }

        $this->command->info('Seeding completed for 6 generations.');
    }

    private function seedDescendants($parent, $genNum, $childCount, $approxYear)
    {
        if ($genNum > 6) return;

        for ($i = 1; $i <= $childCount; $i++) {
            $nameSuffix = ($parent->gender === 'male' ? 'Văn' : 'Thị');
            $child = Person::create([
                'father_id' => ($parent->gender === 'male' ? $parent->id : null),
                'mother_id' => ($parent->gender === 'female' ? $parent->id : null),
                'name' => "Nguyễn {$nameSuffix} " . $this->getOrdinalName($i) . " (Đời {$genNum})",
                'gender' => ($i % 2 === 0) ? 'female' : 'male',
                'date_of_birth' => ($approxYear + ($i * 2)) . '-01-01',
                'is_alive' => ($genNum >= 5),
                'generation_id' => $genNum,
            ]);

            if ($child->gender === 'male' && $genNum < 6) {
                $this->createSpouse($child);
            }

            // Adjusted child count to aim for ~200 total members across 6 generations
            $nextChildCount = 0;
            if ($genNum < 6) {
                if ($genNum == 1) $nextChildCount = 2; // Gen 1 -> 2 children (Gen 2)
                elseif ($genNum == 2) $nextChildCount = rand(2, 3); // Gen 2 -> 2-3 each (~5 total Gen 3)
                elseif ($genNum == 3) $nextChildCount = rand(2, 3); // Gen 3 -> 2-3 each (~12 total Gen 4)
                elseif ($genNum == 4) $nextChildCount = rand(2, 3); // Gen 4 -> 2-3 each (~30 total Gen 5)
                elseif ($genNum == 5) $nextChildCount = 2; // Gen 5 -> 2 each
            }
            
            if ($nextChildCount > 0) {
                $this->seedDescendants($child, $genNum + 1, $nextChildCount, $approxYear + 25);
            }
        }
    }

    private function createSpouse($person)
    {
        $spouse = Person::create([
            'name' => "Bà " . $person->name . " Phun",
            'gender' => ($person->gender === 'male' ? 'female' : 'male'),
            'is_alive' => $person->is_alive,
            'generation_id' => $person->generation_id,
        ]);

        Marriage::create([
            'husband_id' => ($person->gender === 'male' ? $person->id : $spouse->id),
            'wife_id' => ($person->gender === 'female' ? $person->id : $spouse->id),
            'marriage_order' => 1,
        ]);
        
        return $spouse;
    }

    private function getOrdinalName($i)
    {
        $ordinals = [1 => 'Nhất', 2 => 'Nhị', 3 => 'Tam', 4 => 'Tứ', 5 => 'Ngũ', 6 => 'Lục', 7 => 'Thất', 8 => 'Bát'];
        return $ordinals[$i] ?? "Thứ $i";
    }
}
