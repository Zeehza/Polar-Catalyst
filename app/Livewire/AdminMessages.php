<?php

namespace App\Livewire;

use App\Models\ContactSubmission;
use Livewire\Component;

class AdminMessages extends Component
{
    public function mount()
    {
        abort_unless(auth('admin')->check(), 403);
    }

    public function markAsRead(string $id)
    {
        $msg = ContactSubmission::find($id);
        if ($msg) {
            $msg->update(['isRead' => true]);
        }
    }

    public function deleteMessage(string $id)
    {
        $msg = ContactSubmission::find($id);
        if ($msg) {
            $msg->delete();
        }
    }

    public function render()
    {
        $messages = ContactSubmission::orderByDesc('createdAt')->get();

        return view('livewire.admin-messages', [
            'messages' => $messages,
        ]);
    }
}
