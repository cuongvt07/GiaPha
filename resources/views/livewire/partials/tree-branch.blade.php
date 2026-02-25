@props(['children', 'filters' => [], 'generationLevel' => 1])

@php
    // Use passed generationLevel or default to 1
    $currentGeneration = $generationLevel;
    $nextGeneration = $currentGeneration + 1;
@endphp

{{-- DYNAMIC LAYOUT: Vertical if > 4 children starting from Gen 3 --}}
@php
    $useVerticalLayout = false; // REVERTED: User requires horizontal alignment for generations
    $containerClass = 'flex flex-row justify-center pt-16 relative'; // Tightened vertical gap
@endphp

<div class="{{ $containerClass }}" 
     data-layout="horizontal"
     data-parent-node-id="node-{{ $children->first()->father_id ?? $children->first()->mother_id }}">

    @foreach ($children as $child)
        <div class="{{ $useVerticalLayout ? 'relative py-4' : 'flex flex-col items-center relative px-0.25' }}">

            <!-- The Node Itself -->
            <div class="relative z-10 pt-2">
                @include('livewire.partials.node-card', [
                    'person' => $child,
                    'filters' => $filters,
                    'generationLevel' => $currentGeneration,
                ])
            </div>

            <!-- Recursion for next level -->
            @if ($child->children->isNotEmpty())
                @if (!$useVerticalLayout)
                    {{-- Spacer for horizontal --}}
                    <div class="h-16 w-full"></div>
                @endif

                @include('livewire.partials.tree-branch', [
                    'children' => $child->children,
                    'filters' => $filters,
                    'generationLevel' => $nextGeneration,
                ])
            @endif

        </div>
    @endforeach

</div>
