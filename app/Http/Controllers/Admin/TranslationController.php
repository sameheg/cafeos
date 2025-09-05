<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\TranslationOverride;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;

class TranslationController extends Controller
{
    /**
     * Display translations for editing.
     */
    public function index(Request $request)
    {
        $locale = $request->get('locale', app()->getLocale());
        $search = $request->get('search');

        $translations = $this->loadTranslations($locale, $search);
        $locales = collect(File::directories(resource_path('lang')))->map(function ($dir) {
            return basename($dir);
        });

        return view('admin.translations.index', compact('translations', 'locale', 'locales', 'search'));
    }

    /**
     * Save a translation override.
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'locale' => 'required',
            'key' => 'required',
            'value' => 'nullable',
        ]);

        TranslationOverride::updateOrCreate(
            ['locale' => $data['locale'], 'key' => $data['key']],
            ['value' => $data['value']]
        );

        return response()->json(['status' => 'ok']);
    }

    protected function loadTranslations(string $locale, ?string $search)
    {
        $path = resource_path('lang/' . $locale);
        $translations = [];

        foreach (File::allFiles($path) as $file) {
            $name = $file->getFilenameWithoutExtension();
            $lines = Lang::get($name, [], $locale);
            $translations = array_merge($translations, Arr::dot([$name => $lines]));
        }

        $overrides = TranslationOverride::where('locale', $locale)->pluck('value', 'key');

        $collection = collect($translations)->map(function ($value, $key) use ($overrides) {
            return [
                'key' => $key,
                'base' => $value,
                'override' => $overrides[$key] ?? $value,
            ];
        });

        if ($search) {
            $collection = $collection->filter(function ($item) use ($search) {
                return Str::contains($item['key'], $search) || Str::contains($item['override'], $search);
            });
        }

        return $collection->values();
    }
}
