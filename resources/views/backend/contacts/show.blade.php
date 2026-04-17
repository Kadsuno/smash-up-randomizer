<x-layouts.backend.backendMain>

<div class="mb-6">
    <p class="text-xs text-zinc-600">
        <a href="{{ route('admin.contacts.index') }}" class="hover:text-zinc-400">{{ __('backend.contacts_title') }}</a>
        <span class="mx-1 text-zinc-700">/</span>
        <span class="text-zinc-500">#{{ $contact->id }}</span>
    </p>
    <h1 class="mt-1 text-2xl font-bold text-white">{{ $contact->subject }}</h1>
    <p class="mt-1 text-sm text-zinc-500">{{ $contact->created_at?->format('Y-m-d H:i') }}</p>
</div>

<div class="space-y-4 rounded-xl border border-white/6 bg-zinc-900/60 p-6 text-sm">
    <div>
        <span class="text-xs font-semibold uppercase tracking-wide text-zinc-600">{{ __('backend.contact_col_name') }}</span>
        <p class="mt-1 text-zinc-200">{{ $contact->name }}</p>
    </div>
    <div>
        <span class="text-xs font-semibold uppercase tracking-wide text-zinc-600">{{ __('backend.contact_col_email') }}</span>
        <p class="mt-1 text-zinc-200"><a href="mailto:{{ $contact->email }}" class="text-indigo-400 hover:text-indigo-300">{{ $contact->email }}</a></p>
    </div>
    @if($contact->phone)
    <div>
        <span class="text-xs font-semibold uppercase tracking-wide text-zinc-600">{{ __('backend.contact_col_phone') }}</span>
        <p class="mt-1 text-zinc-200">{{ $contact->phone }}</p>
    </div>
    @endif
    <div>
        <span class="text-xs font-semibold uppercase tracking-wide text-zinc-600">{{ __('backend.contact_message') }}</span>
        <pre class="mt-2 whitespace-pre-wrap rounded-lg border border-white/6 bg-zinc-950/60 p-4 text-zinc-300">{{ $contact->message }}</pre>
    </div>
</div>

</x-layouts.backend.backendMain>
