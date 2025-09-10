<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class LangCheck extends Command
{
    protected $signature = 'lang:check';

    protected $description = 'Ensure translation files have matching keys and no untranslated labels';

    public function handle(): int
    {
        $failed = false;

        // Check application level translations
        if (!$this->checkPair(lang_path('en.json'), lang_path('ar.json'))) {
            $failed = true;
        }

        // Check module translations
        $modules = glob(base_path('Modules/*'), GLOB_ONLYDIR);
        foreach ($modules as $modulePath) {
            $module = basename($modulePath);
            $enDir = $modulePath . '/Resources/lang/en';
            $arDir = $modulePath . '/Resources/lang/ar';

            if (!is_dir($enDir) || !is_dir($arDir)) {
                $this->error("Missing lang directories for module: {$module}");
                $failed = true;
                continue;
            }

            foreach (glob($enDir . '/*.php') as $file) {
                $name = basename($file);
                $arFile = $arDir . '/' . $name;
                if (!file_exists($arFile)) {
                    $this->error("Missing translation file in ar for {$module}: {$name}");
                    $failed = true;
                    continue;
                }

                if (!$this->checkPair($file, $arFile, "{$module}:{$name}")) {
                    $failed = true;
                }
            }
        }

        if ($failed) {
            return self::FAILURE;
        }

        $this->info('All translation keys are present and translated.');

        return self::SUCCESS;
    }

    private function checkPair(string $enPath, string $arPath, string $label = 'app'): bool
    {
        $en = str_ends_with($enPath, '.php')
            ? require $enPath
            : (json_decode(file_get_contents($enPath), true) ?? []);
        $ar = str_ends_with($arPath, '.php')
            ? require $arPath
            : (json_decode(file_get_contents($arPath), true) ?? []);

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
                $this->error("Missing key in {$label} ar: {$key}");
            }
            foreach (array_keys($extra) as $key) {
                $this->error("Extra key in {$label} ar: {$key}");
            }
            foreach ($untranslated as $key) {
                $this->error("Untranslated key in {$label}: {$key}");
            }

            return false;
        }

        return true;
    }
}
