<x-layouts.backend.backendMain>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">{{ __('backend.contacts_title') }}</h1>
    <p class="mt-1 text-sm text-zinc-500">{{ __('backend.contacts_subtitle') }}</p>
</div>

<div class="overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b border-white/6 text-xs font-bold uppercase tracking-wide text-zinc-600">
                <th class="px-4 py-3">{{ __('backend.contact_col_date') }}</th>
                <th class="px-4 py-3">{{ __('backend.contact_col_name') }}</th>
                <th class="px-4 py-3">{{ __('backend.contact_col_email') }}</th>
                <th class="px-4 py-3">{{ __('backend.contact_col_subject') }}</th>
                <th class="px-4 py-3 text-end">{{ __('backend.table_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/[0.04]">
            @forelse($contacts as $contact)
            <tr class="hover:bg-white/[0.02]">
                <td class="px-4 py-2.5 text-zinc-500 whitespace-nowrap">{{ $contact->created_at?->format('Y-m-d H:i') }}</td>
                <td class="px-4 py-2.5 text-zinc-200">{{ $contact->name }}</td>
                <td class="px-4 py-2.5 text-zinc-400 truncate max-w-[12rem]">{{ $contact->email }}</td>
                <td class="px-4 py-2.5 text-zinc-300 truncate max-w-[16rem]">{{ $contact->subject }}</td>
                <td class="px-4 py-2.5 text-end">
                    <a href="{{ route('admin.contacts.show', $contact) }}" class="text-xs text-indigo-400 hover:text-indigo-300">{{ __('backend.view') }}</a>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="5" class="px-4 py-10 text-center text-zinc-500">{{ __('backend.contacts_empty') }}</td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $contacts->links() }}
</div>

</x-layouts.backend.backendMain>
