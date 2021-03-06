<?php

namespace App\View\Components;

use Illuminate\View\Component;

/**
 * Class AppLayout
 * @package App\View\Components
 * @deprecated
 */
final class AppLayout extends Component
{
    /**
     * Get the view / contents that represents the component.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('layouts.app');
    }
}
