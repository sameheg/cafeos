<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LangCheck extends Command
{
    protected $signature = 'lang:check';

    protected $description = 'Ensure translation files have matching keys and no untranslated labels';

    public function handle(): int
    {
        $en = json_decode(file_get_contents(lang_path('en.json')), true);
        $ar = json_decode(file_get_contents(lang_path('ar.json')), true);

        $missing = array_diff_key($en, $ar);
        $extra = array_diff_key($ar, $en);
        $untranslated = [];

        foreach ($en as $key => $value) {
            if (isset($ar[$key]) && $ar[$key] === $value) {
                $untranslated[] = $key;
            }
        }

        if ($missing || $extra || $untranslated) {
            foreach (array_keys($missing) as $key) {
                $this->error("Missing key in ar: {$key}");
            }
            foreach (array_keys($extra) as $key) {
                $this->error("Extra key in ar: {$key}");
            }
            foreach ($untranslated as $key) {
                $this->error("Untranslated key: {$key}");
            }

            return self::FAILURE;
        }

        $this->info('All translation keys are present and translated.');

        return self::SUCCESS;
    }
}
