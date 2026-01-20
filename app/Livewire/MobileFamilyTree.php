<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Person;

class MobileFamilyTree extends Component
{
    // Tree Data
    public $rootPerson;
    public $focusedPersonId = null;
    public $treeVersion = 0;
    public $originalRootId = null;

    // UI States
    public $showMenu = false;
    public $showBottomSheet = false;
    public $selectedPerson = null;
    public $showAddModal = false;
    public $addParentId = null;
    public $editingPersonId = null;

    // Form Fields
    public $newPersonName;
    public $newPersonGender = 'male';
    public $newPersonBirthYear;
    public $newPersonIsAlive = true;

    // Filters
    public $filters = [
        'showAlive' => true,
        'showDeceased' => true,
        'showMale' => true,
        'showFemale' => true,
        'showDates' => true,
        'showSpouses' => true,
    ];

    public function mount()
    {
        $this->loadRootPerson();
    }

    protected function loadRootPerson()
    {
        $root = Person::with([
            'children',
            'children.children',
            'children.children.children',
            'children.children.children.children',
            'children.children.children.children.children'
        ])
            ->whereNull('father_id')
            ->whereNull('mother_id')
            ->first();

        if ($root) {
            $this->originalRootId = $root->id;
            $this->rootPerson = $root;
        }
    }

    // Menu Actions
    public function toggleMenu()
    {
        $this->showMenu = !$this->showMenu;
    }

    public function closeMenu()
    {
        $this->showMenu = false;
    }

    // Person Selection
    public function selectPerson($personId)
    {
        $this->selectedPerson = Person::with([
            'father',
            'mother',
            'children',
            'burialInfo',
            'achievements',
            'marriagesAsHusband.wife',
            'marriagesAsWife.husband'
        ])->find($personId);
        
        $this->showBottomSheet = true;
    }

    public function closeBottomSheet()
    {
        $this->showBottomSheet = false;
        $this->selectedPerson = null;
    }

    // Focus on branch
    public function focusOnPerson($personId)
    {
        $this->focusedPersonId = $personId;
        
        $focusedPerson = Person::with([
            'children',
            'children.children',
            'children.children.children',
            'children.children.children.children',
        ])->find($personId);

        if ($focusedPerson) {
            $this->rootPerson = $focusedPerson;
            $this->treeVersion++;
        }
        
        $this->closeBottomSheet();
        $this->dispatch('tree-updated');
    }

    public function resetToRoot()
    {
        $this->focusedPersonId = null;
        
        if ($this->originalRootId) {
            $this->loadRootPerson();
            $this->treeVersion++;
            $this->dispatch('tree-updated');
        }
    }

    // Add Person
    public function openAddModal($parentId = null)
    {
        $this->addParentId = $parentId;
        $this->editingPersonId = null;
        $this->reset(['newPersonName', 'newPersonGender', 'newPersonBirthYear', 'newPersonIsAlive']);
        $this->newPersonGender = 'male'; 
        $this->newPersonIsAlive = true;
        
        $this->showAddModal = true;
        $this->closeBottomSheet();
    }

    public function editPerson($personId)
    {
        $person = Person::find($personId);
        if ($person) {
            $this->editingPersonId = $person->id;
            $this->newPersonName = $person->name;
            $this->newPersonGender = $person->gender;
            $this->newPersonBirthYear = $person->birth_year;
            $this->newPersonIsAlive = (bool)$person->is_alive;
            
            $this->showAddModal = true;
            $this->closeBottomSheet();
        }
    }

    public function closeAddModal()
    {
        $this->showAddModal = false;
        $this->addParentId = null;
        $this->editingPersonId = null;
    }

    public function savePerson()
    {
        $this->validate([
            'newPersonName' => 'required|string|max:255',
            'newPersonGender' => 'required|in:male,female',
            'newPersonBirthYear' => 'nullable|integer|min:1800|max:2030',
            'newPersonIsAlive' => 'boolean',
        ]);

        if ($this->editingPersonId) {
            $person = Person::find($this->editingPersonId);
            if (!$person) return;
        } else {
            $person = new Person();
            $person->order = 1;
        }

        $person->name = $this->newPersonName;
        $person->gender = $this->newPersonGender;
        $person->birth_year = $this->newPersonBirthYear;
        $person->is_alive = $this->newPersonIsAlive;

        // Relation logic only for new person
        if (!$this->editingPersonId && $this->addParentId) {
            $parent = Person::find($this->addParentId);
            if ($parent) {
                if ($parent->gender === 'male') {
                    $person->father_id = $parent->id;
                } else {
                    $person->mother_id = $parent->id;
                }
            }
        }

        $person->save();

        if ($this->editingPersonId) {
             $this->selectedPerson = $person->fresh(); // Update selected person view if open
        }

        $this->reset(['newPersonName', 'newPersonGender', 'newPersonBirthYear', 'newPersonIsAlive']);
        $this->closeAddModal();
        
        $this->loadRootPerson();
        $this->treeVersion++;
        $this->dispatch('tree-updated');
    }

    public function deletePerson($personId)
    {
        $person = Person::find($personId);
        if ($person) {
            $person->delete();
            $this->closeBottomSheet();
            
            if ($this->rootPerson && $this->rootPerson->id == $personId) {
                $this->resetToRoot();
            } else {
                 $this->loadRootPerson(); // Refresh tree
                 $this->treeVersion++;
                 $this->dispatch('tree-updated');
            }
        }
    }

    // Filter updates
    public function updateFilter($key, $value)
    {
        $this->filters[$key] = $value;
        $this->treeVersion++;
        $this->dispatch('tree-updated');
    }

    public function render()
    {
        return view('livewire.mobile-family-tree')
            ->layout('components.layouts.mobile-layout');
    }
}
