<?php

namespace App\View\Components\Notifikasi;

use App\Models\Notifikasi;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\Component;

class DropdownNotif extends Component
{
    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        //
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        $user = Auth::user();

        $notifs = Notifikasi::where('target_role', $user->role)
            ->where('status', 'Unread')
            ->latest()->take(5)->get();

        return view('components.notifikasi.dropdown-notif', [
            'notifs' => $notifs,
        ]);
    }
}
