<?php

namespace App\Livewire;

use Livewire\Component;
use Filament\Facades\Filament;
use Illuminate\Support\Facades\Auth;

class PanelSwitcher extends Component
{
    public function render()
    {
        $panels = [];

        // Get all panels that the user has access to
        foreach (Filament::getPanels() as $panel) {
            if (Auth::user()->canAccessPanel($panel)) {
                $panels[] = $panel;
            }
        }

        return view('livewire.panel-switcher', [
            'panels' => $panels,
        ]);
    }

    public function switchPanel($panelId)
    {
        // Switch to the selected panel
        return redirect()->route('filament.panel', ['panel' => $panelId]);
    }
}
