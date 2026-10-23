<div class="space-y-6">
    <x-admin.input name="title" label="Title" :value="$project->title" required maxlength="255" />

    <div class="grid gap-6 sm:grid-cols-2">
        <div>
            <label for="category" class="block text-sm font-medium">Category</label>
            <select id="category" name="category" required
                    class="mt-2 block w-full rounded-lg border border-neutral-300 bg-white px-4 py-2.5 outline-none focus:border-accent dark:border-neutral-700 dark:bg-neutral-900">
                <option value="" disabled @selected(! old('category', $project->category))>Choose…</option>
                <option value="tech" @selected(old('category', $project->category) === 'tech')>Tech</option>
                <option value="creative" @selected(old('category', $project->category) === 'creative')>Creative</option>
            </select>
            @error('category')
                <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
            @enderror
        </div>

                <x-admin.input name="sort_order" label="Display order" type="number"
                       :value="$project->sort_order ?? 0"
                       min="0" max="999" hint="Lower numbers appear first" />
    </div>

    <div>
        <label for="description" class="block text-sm font-medium">Description</label>
        <textarea id="description" name="description" rows="4" required maxlength="1000"
                  class="mt-2 block w-full rounded-lg border border-neutral-300 bg-white px-4 py-2.5 outline-none focus:border-accent dark:border-neutral-700 dark:bg-neutral-900">{{ old('description', $project->description) }}</textarea>
        @error('description')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div>
        <x-admin.input name="technologies_input" label="Technologies / skills"
                       :value="implode(', ', $project->technologies ?? [])"
                       hint="Separate with commas, e.g. Laravel, Tailwind CSS, MySQL" />
        @error('technologies')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
        @error('technologies.*')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <div class="grid gap-6 sm:grid-cols-3">
        <x-admin.input name="live_url" label="Live URL" type="url" :value="$project->live_url"
                       placeholder="https://" hint="Optional" />
        <x-admin.input name="github_url" label="GitHub URL" type="url" :value="$project->github_url"
                       placeholder="https://github.com/…" hint="Optional" />
    </div>

        <div>
        <label for="image" class="block text-sm font-medium">Thumbnail</label>

        @if ($project->image)
            <img src="{{ asset('storage/' . $project->image) }}" alt="Current thumbnail"
                 class="mt-2 aspect-[16/10] w-48 rounded-lg border border-neutral-200 object-cover dark:border-neutral-800">
        @endif

        <input id="image" name="image" type="file" accept="image/jpeg,image/png,image/webp"
               class="mt-2 block w-full text-sm text-neutral-600 file:mr-4 file:rounded-full file:border-0 file:bg-neutral-200 file:px-4 file:py-2 file:text-sm file:font-medium hover:file:bg-neutral-300 dark:text-neutral-400 dark:file:bg-neutral-800 dark:file:text-neutral-200">

        <p class="mt-1 text-xs text-neutral-500">
            JPG, PNG, or WebP · max 2 MB · 16:10 recommended (e.g. 1600 × 1000 px)
        </p>

        @error('image')
            <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
        @enderror
    </div>

    <label class="flex items-center gap-3">
        <input type="checkbox" name="featured" value="1"
               @checked(old('featured', $project->featured))
               class="h-4 w-4 rounded border-neutral-300 accent-[var(--color-accent)]">
        <span class="text-sm">Featured (shown first on the website)</span>
    </label>

    <div class="flex flex-wrap items-center gap-4 border-t border-neutral-200 pt-6 dark:border-neutral-800">
        <button type="submit"
                class="inline-flex items-center rounded-full bg-accent px-6 py-2.5 text-sm font-medium text-neutral-950 transition-opacity hover:opacity-90">
            {{ $submitLabel }}
        </button>
        <a href="{{ route('admin.projects.index') }}" class="text-sm text-neutral-500 hover:text-accent">Cancel</a>
    </div>
</div>