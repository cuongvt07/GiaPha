<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\FamilyBranch;

class FamilyBranchSeeder extends Seeder
{
    public function run()
    {
        $branches = [
            [
                'branch_name' => 'Chi Giáp (Trưởng)',
                'description' => 'Chi cả - Dòng trưởng',
                'branch_order' => 1,
            ],
            [
                'branch_name' => 'Chi Ất',
                'description' => 'Chi hai',
                'branch_order' => 2,
            ],
            [
                'branch_name' => 'Chi Bính',
                'description' => 'Chi ba',
                'branch_order' => 3,
            ],
            [
                'branch_name' => 'Chi Đinh',
                'description' => 'Chi bốn',
                'branch_order' => 4,
            ],
        ];

        foreach ($branches as $branch) {
            FamilyBranch::create($branch);
        }
    }
}
