<?php

namespace App\Http\Livewire\Settings;

use Livewire\Component;

class ShowSettings extends Component
{
    public $settings;
 
  

    public function updateState()
    {
    }

    public function saveSettings()
    {
        session()->flash('message', 'Settings successfully updated.');
    }

    public function render()
    {
        return view('livewire.settings.show-settings');
    }
}
