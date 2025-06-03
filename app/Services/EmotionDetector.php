<?php
// app/Services/EmotionDetector.php

namespace App\Services;
use App\EmotionKeyword\EmotionsKeywords;
use App\Enum\Emotion;
use Illuminate\Support\Facades\Http;

class EmotionDetector
{
    public static function detect(?string $text): string
    {
        if (!$text) {
            return Emotion::NEUTRAL; // Return neutral if no text is provided
        }
        $text = strtolower($text);
        // List of negation words to look for
        $negations = ['not', "isn't", "wasn't", "aren't", "don't", "didn't", "no"];
        $hasNegationNear = function (string $keyword) use ($text, $negations): bool {
            // We'll check if any negation word appears within 3 words before the keyword
            foreach ($negations as $neg) {
                // Pattern: negation word followed by up to 3 words then the keyword
                $pattern1 = '/\b' . preg_quote($neg) . '\b(?:\W+\w+){0,3}?\W+' . preg_quote($keyword) . '\b/';
                // Pattern: keyword followed by up to 3 words then negation (less common but just in case)
                $pattern2 = '/\b' . preg_quote($keyword) . '\b(?:\W+\w+){0,3}?\W+' . preg_quote($neg) . '\b/';
                if (preg_match($pattern1, $text) || preg_match($pattern2, $text)) {
                    return true;
                }
            }
            return false;
        };

        // Check emotions in order; if negation near keyword, skip that emotion
        foreach (EmotionsKeywords::$angry as $keyword) {
            if (str_contains($text, $keyword)) {
                if ($hasNegationNear($keyword)) {
                    continue; // Negation detected near keyword — skip this emotion
                }
                return Emotion::ANGRY;
            }
        }
        foreach (EmotionsKeywords::$happy as $keyword) {
            if (str_contains($text, $keyword)) {
                if ($hasNegationNear($keyword)) {
                    continue;
                }
                return Emotion::HAPPY;
            }
        }
        foreach (EmotionsKeywords::$sad as $keyword) {
            if (str_contains($text, $keyword)) {
                if ($hasNegationNear($keyword)) {
                    continue;
                }
                return Emotion::SAD;
            }
        }
        foreach (EmotionsKeywords::$surprised as $keyword) {
            if (str_contains($text, $keyword)) {
                if ($hasNegationNear($keyword)) {
                    continue;
                }
                return Emotion::SURPRISED;
            }
        }

        return Emotion::NEUTRAL; // Default emotion if no keywords match
    }

}
