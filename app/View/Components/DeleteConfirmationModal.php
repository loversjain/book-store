<?php

namespace App\View\Components;

use Illuminate\View\Component;

class DeleteConfirmationModal extends Component
{
    public $id;
    public $title;
    public $message;
    public $actionUrl;

    public function __construct($id, $title, $message, $actionUrl=null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->message = $message;
        $this->actionUrl = $actionUrl;
    }

    public function render()
    {
        return view('components.delete-confirmation-modal');
    }
}
