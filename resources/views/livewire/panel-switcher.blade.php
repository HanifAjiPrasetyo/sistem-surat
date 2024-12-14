<div>
    @foreach ($panels as $panel)
        <button wire:click="switchPanel('{{ $panel->getId() }}')">
            {{ $panel->getLabel() }}
        </button>
    @endforeach
</div>
