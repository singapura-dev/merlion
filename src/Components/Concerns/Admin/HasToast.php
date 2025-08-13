<?php

namespace Merlion\Components\Concerns\Admin;

trait HasToast
{
    public function toast($message, $type = 'primary', $position = 'center'): static
    {
        session()->flash('toast', [
            'message' => $message,
            'type' => $type,
            'position' => $position,
        ]);
        return $this;
    }

    public function success($message): static
    {
        return $this->toast($message, 'success');
    }

    public function info($message): static
    {
        return $this->toast($message, 'info');
    }

    public function danger($message): static
    {
        return $this->toast($message, 'danger');
    }

    public function getMessage()
    {
        return session('toast.message');
    }

    public function getAlert()
    {
        return session('alert.content');
    }

    public function alert($content, $type = 'success'): static
    {
        session()->flash('alert', [
            'content' => $content,
            'type' => $type,
        ]);
        return $this;
    }
}
