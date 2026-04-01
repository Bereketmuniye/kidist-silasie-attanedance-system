<?php

namespace App\Services;

class ToasterService
{
    /**
     * Flash a success message to the session.
     */
    public function success(string $message, string $description = null): void
    {
        $this->flash('success', $message, $description);
    }

    /**
     * Flash an error message to the session.
     */
    public function error(string $message, string $description = null): void
    {
        $this->flash('error', $message, $description);
    }

    /**
     * Flash a warning message to the session.
     */
    public function warning(string $message, string $description = null): void
    {
        $this->flash('warning', $message, $description);
    }

    /**
     * Flash an info message to the session.
     */
    public function info(string $message, string $description = null): void
    {
        $this->flash('info', $message, $description);
    }

    /**
     * Flash a message to the session.
     */
    private function flash(string $type, string $message, ?string $description = null): void
    {
        // Try to get current Livewire component for direct dispatch
        try {
            $request = request();
            if ($request->hasHeader('X-Livewire')) {
                // We're in a Livewire request, try to dispatch directly
                $livewire = app(\Livewire\Mechanisms\FrontendAssets\FrontendAssets::class);
                if (method_exists($livewire, 'dispatch')) {
                    // This is a fallback - the main method should be session flash
                }
            }
        } catch (\Exception $e) {
            // Fall back to session
        }

        $notification = [
            'type' => $type,
            'message' => $message,
            'description' => $description,
        ];

        session()->flash('toaster', $notification);
    }

    /**
     * Get the current toaster notification from session.
     */
    public function get(): ?array
    {
        return session('toaster');
    }

    /**
     * Clear the current toaster notification.
     */
    public function clear(): void
    {
        session()->forget('toaster');
    }

    /**
     * Check if there's a toaster notification.
     */
    public function has(): bool
    {
        return session()->has('toaster');
    }
}
