<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendTelegramOrderNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $orderData;
    protected $items;

    /**
     * Create a new job instance.
     */
    public function __construct(array $orderData, array $items)
    {
        $this->orderData = $orderData;
        $this->items = $items;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Telegram Bot Token we Chat ID
        $token = "8238051221:AAExkzLO7u9N_KBI33heKe-_B-216E3R0ds";
        $chatId = "6321983964";

        // Habaryň owadan görnüşi
        $message = "🔔 <b>TÄZE SARGYT!</b>\n\n";
        $message .= "🆔 <b>Sargyt №:</b> <code>{$this->orderData['order_number']}</code>\n";
        $message .= "👤 <b>Alyjy:</b> {$this->orderData['customer_name']}\n";
        $message .= "📞 <b>Telefon:</b> {$this->orderData['customer_phone']}\n";
        $message .= "📍 <b>Adres:</b> " . ($this->orderData['address'] ?? 'Görkezilmedi') . "\n\n";

        $message .= "🛒 <b>Harytlar:</b>\n";
        foreach ($this->items as $item) {
            $name = $item['name'] ?? 'Haryt';
            $qty = $item['quantity'] ?? 1;
            $message .= "• {$name} ({$qty} sany)\n";
        }

        $message .= "\n💰 <b>JEMI HASAP: " . number_format($this->orderData['total_price'], 2) . " TMT</b>";

        // Göni Telegram API Adresi (Hiç hili proxy-syz)
        $url = "https://api.telegram.org/bot{$token}/sendMessage";

        try {
            // Maximum 3 sekunt garaşýar
            $response = Http::withoutVerifying()
                ->timeout(3)
                ->post($url, [
                    'chat_id'    => $chatId,
                    'text'       => $message,
                    'parse_mode' => 'HTML'
                ]);

            if ($response->successful()) {
                Log::info("Telegram bildirişi üstünlikli ugradyldy!");
            }
        } catch (\Exception $e) {
            // VPN ýok bolsa cURL bökdençligi dörär, emma try-catch sebäpli saýt çökmez!
            Log::warning("Telegram-a baglanyp bolmady (VPN ýok bolup biler): " . $e->getMessage());
        }
    }
}
