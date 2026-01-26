<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Person;

class FamilyTree extends Component
{
    public $rootPerson;
    public $focusedPersonId = null;
    public $originalRootId = null;
    public $breadcrumbPath = [];
    public $treeVersion = 0;

    // Tab & Search Logic for Mobile Menu
    public $activeTab = 'tree';
    public $listSearch = '';
    public $mobileMenuOpen = false; // Control loop via mobile menu

    public $filters = [
        'showAlive' => true,
        'showDeceased' => true,
        'showMale' => true,
        'showFemale' => true,
        'showDates' => true,
        'showTitles' => true,
        'showSpouses' => true,
        'treeTitle' => 'Gia đình ông Làng, bà Oanh - Kính dâng tặng',
    ];

    public function setTab($tab)
    {
        $this->activeTab = $tab;
    }

    public function openMenu()
    {
        $this->mobileMenuOpen = true;
    }

    public function closeMenu()
    {
        $this->mobileMenuOpen = false;
    }

    protected $listeners = [
        // 'refreshTree' => '$refresh', // Disabled to prevent flickering
        'filters-updated' => 'updateFilters',
        'focus-on-branch' => 'focusOnPerson',
        'tree-entity-saved' => 'onTreeEntitySaved',
    ];

    public function onTreeEntitySaved($personId)
    {
        // Refresh root to ensure fresh data (especially if children relation was cached)
        if ($this->rootPerson) {
            $this->rootPerson->refresh();
        } else {
            // If no root existed, find the one that was just created
            $originalRoot = Person::whereNull('father_id')
                ->whereNull('mother_id')
                ->first();

            if ($originalRoot) {
                $this->originalRootId = $originalRoot->id;
                $this->rootPerson = $originalRoot;
            }
        }

        $this->treeVersion++;

        // Dispatch browser event to center on the new/updated node
        $this->dispatch('center-on-node', nodeId: 'node-' . $personId);
    }

    public function updateFilters($filters)
    {
        $this->filters = array_merge($this->filters, $filters);
    }

    public function mount()
    {
        // Mobile Redirect Logic
        $userAgent = request()->header('User-Agent');
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $userAgent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($userAgent, 0, 4))) {
            return redirect()->route('mobile.tree');
        }

        // Get the original root person
        $originalRoot = Person::whereNull('father_id')
            ->whereNull('mother_id')
            ->first();

        if ($originalRoot) {
            $this->originalRootId = $originalRoot->id;
            $this->rootPerson = $originalRoot;
        }
    }

    public function focusOnPerson($personId)
    {
        $this->focusedPersonId = $personId;

        // Load the focused person as the NEW ROOT - only load descendants, not ancestors
        // This makes them the "top" of the tree
        // Load the focused person as the NEW ROOT - only load descendants, not ancestors
        // This makes them the "top" of the tree
        $focusedPerson = Person::find($personId);

        if ($focusedPerson) {
            $this->rootPerson = $focusedPerson;
            $this->breadcrumbPath = $focusedPerson->getAncestorPath();

            // Dispatch event to frontend to re-center view
            $this->dispatch('tree-focused', ['personId' => $personId]);
        }
    }

    public function resetToRoot()
    {
        $this->focusedPersonId = null;
        $this->breadcrumbPath = [];

        // Reload original root
        if ($this->originalRootId) {
            $this->rootPerson = Person::find($this->originalRootId);
        }

        // Dispatch event to frontend to re-center view
        $this->dispatch('tree-reset');
    }


    public function selectPerson($personId)
    {
        $this->dispatch('person-selected', id: $personId);
    }

    public function deletePerson($personId)
    {
        $person = Person::find($personId);
        if ($person) {
            // Check if deleting current root
            if ($this->rootPerson && $this->rootPerson->id == $personId) {
                $this->resetToRoot();
            }

            // Delete person (database should handle cascades or orphans)
            $person->delete();

            // Refresh logic handled by Livewire re-render
            // Optionally notify user
        }
    }


    public function render()
    {
        $stats = [];
        $members = [];

        if ($this->activeTab === 'stats') {
            $stats = [
                'total_members' => \App\Models\Person::count(),
                'living_members' => \App\Models\Person::where('is_alive', true)->count(),
                'deceased_members' => \App\Models\Person::where('is_alive', false)->count(),
                'total_generations' => \App\Models\Person::whereNotNull('generation_id')->distinct('generation_id')->count('generation_id'),
                'male_members' => \App\Models\Person::where('gender', 'male')->count(),
                'female_members' => \App\Models\Person::where('gender', 'female')->count(),
            ];
        }

        if ($this->activeTab === 'list') {
            $query = \App\Models\Person::query();
            if ($this->listSearch) {
                $query->where('name', 'like', '%' . $this->listSearch . '%')
                    ->orWhere('nickname', 'like', '%' . $this->listSearch . '%');
            }
            $members = $query->orderBy('name')->simplePaginate(15);
        }

        return view('livewire.family-tree', [
            'stats' => $stats,
            'members' => $members
        ])->layout('components.layouts.app-canvas');
    }
}
