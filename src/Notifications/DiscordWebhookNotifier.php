<?php

namespace CapsuleCmdr\SeATPM\Notifications;

use Illuminate\Support\Facades\Http;

class DiscordWebhookNotifier
{
    protected string $webhookUrl;

    public function __construct(?string $customWebhook = null)
    {
        $this->webhookUrl = $customWebhook ?: config('seatpm.webhook_url');
    }

    /**
     * Send a notification to Discord.
     *
     * @param string $title - The message title.
     * @param string $description - The body of the message.
     * @param string|null $url - Optional link to the SeAT-PM resource.
     * @param string $color - Hex or decimal embed color.
     */
    public function send(string $title, string $description, ?string $url = null, string $color = '3066993'): void
    {
        if (empty($this->webhookUrl)) {
            return; // Do nothing if webhook is not set
        }

        $payload = [
            'embeds' => [[
                'title' => $title,
                'description' => $description,
                'url' => $url,
                'color' => $this->parseColor($color),
                'timestamp' => now()->toIso8601String(),
                'footer' => [
                    'text' => 'SeAT-PM Plugin',
                ],
            ]],
        ];

        Http::withHeaders(['Content-Type' => 'application/json'])
            ->post($this->webhookUrl, $payload);
    }

    /**
     * Convert color name/hex to decimal for Discord.
     */
    protected function parseColor(string $color): int
    {
        // Accepts either hex (#36a64f) or decimal (3066993)
        if (is_numeric($color)) {
            return (int) $color;
        }

        $color = ltrim($color, '#');

        return hexdec(strlen($color) === 6 ? $color : '3066993'); // fallback to Discord blue
    }
}
