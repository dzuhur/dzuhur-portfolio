<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Route sudah dilindungi middleware auth
        return true;
    }

    protected function prepareForValidation(): void
    {
        $technologies = collect(explode(',', (string) $this->input('technologies_input')))
            ->map(fn ($tech) => trim($tech))
            ->filter()
            ->unique()
            ->values()
            ->all();

        $this->merge([
            'technologies' => $technologies,
            'featured' => $this->boolean('featured'),
            // Kosong = 0, tapi teks seperti "abc" tetap dikirim apa adanya supaya ditolak validasi
            'sort_order' => $this->input('sort_order') ?? 0,
        ]);
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'category' => ['required', Rule::in(['creative', 'tech'])],
            'description' => ['required', 'string', 'max:1000'],
            'technologies' => ['array', 'max:12'],
            'technologies.*' => ['string', 'max:50'],
            'year' => ['nullable', 'integer', 'min:2000', 'max:' . (now()->year + 1)],
            'live_url' => ['nullable', 'url:http,https', 'max:255'],
            'github_url' => ['nullable', 'url:http,https', 'max:255'],
            'featured' => ['boolean'],
            'sort_order' => ['required', 'integer', 'min:0', 'max:999'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
        ];
    }

    public function attributes(): array
    {
        return [
            'live_url' => 'live URL',
            'github_url' => 'GitHub URL',
            'sort_order' => 'display order',
        ];
    }
}