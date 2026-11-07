<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class TranslationService
{
    /**
     * Translate any input text to Indonesian.
     *
     * @param string $text
     * @return array{translated_text: string, original_text: string, detected_language: string, is_translated: bool}
     */
    public static function translateToIndonesian(string $text): array
    {
        $text = trim($text);

        if (empty($text)) {
            return [
                'translated_text' => '',
                'original_text' => '',
                'detected_language' => 'id',
                'is_translated' => false,
            ];
        }

        try {
            $response = Http::timeout(4)->get('https://translate.googleapis.com/translate_a/single', [
                'client' => 'gtx',
                'sl' => 'auto',
                'tl' => 'id',
                'dt' => 't',
                'q' => $text,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                
                if (is_array($data) && isset($data[0]) && is_array($data[0])) {
                    $translated = '';
                    foreach ($data[0] as $segment) {
                        if (isset($segment[0])) {
                            $translated .= $segment[0];
                        }
                    }

                    $detectedLanguage = $data[2] ?? 'auto';
                    $isTranslated = ($detectedLanguage !== 'id') && (strcasecmp(trim($translated), $text) !== 0);

                    return [
                        'translated_text' => !empty($translated) ? $translated : $text,
                        'original_text' => $text,
                        'detected_language' => (string) $detectedLanguage,
                        'is_translated' => $isTranslated,
                    ];
                }
            }
        } catch (\Throwable $e) {
            Log::warning('Translation to Indonesian failed, falling back to original text: ' . $e->getMessage());
        }

        return [
            'translated_text' => $text,
            'original_text' => $text,
            'detected_language' => 'id',
            'is_translated' => false,
        ];
    }
}

