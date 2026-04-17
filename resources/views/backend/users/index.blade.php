<x-layouts.backend.backendMain>

<div class="mb-6">
    <h1 class="text-2xl font-bold text-white">{{ __('backend.users_title') }}</h1>
    <p class="mt-1 text-sm text-zinc-500">{{ __('backend.users_subtitle') }}</p>
</div>

@if(session('success'))
    <div class="mb-4 rounded-lg border border-emerald-500/30 bg-emerald-900/20 px-4 py-3 text-sm text-emerald-300">
        {{ session('success') }}
    </div>
@endif

@if ($errors->any())
    <div class="mb-4 rounded-lg border border-red-500/30 bg-red-900/20 px-4 py-3 text-sm text-red-300">
        {{ $errors->first() }}
    </div>
@endif

<div class="overflow-hidden rounded-xl border border-white/6 bg-zinc-900/60">
    <table class="w-full text-left text-sm">
        <thead>
            <tr class="border-b border-white/6 text-xs font-bold uppercase tracking-wide text-zinc-600">
                <th class="px-4 py-3">{{ __('backend.user_col_email') }}</th>
                <th class="px-4 py-3">{{ __('backend.user_col_name') }}</th>
                <th class="px-4 py-3">{{ __('backend.user_col_role') }}</th>
                <th class="px-4 py-3 text-end">{{ __('backend.table_actions') }}</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-white/[0.04]">
            @foreach($users as $user)
            <tr class="hover:bg-white/[0.02]">
                <td class="px-4 py-2.5 text-zinc-200">{{ $user->email }}</td>
                <td class="px-4 py-2.5 text-zinc-400">{{ $user->name }}</td>
                <td class="px-4 py-2.5">
                    <span class="rounded-md border px-2 py-0.5 text-xs font-semibold {{ $user->isAdmin() ? 'border-indigo-500/40 bg-indigo-500/10 text-indigo-300' : 'border-white/10 bg-zinc-800/60 text-zinc-400' }}">
                        {{ $user->role }}
                    </span>
                </td>
                <td class="px-4 py-2.5 text-end">
                    @if($user->isAdmin())
                    <form action="{{ route('admin.users.update-role') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="role" value="user">
                        <button type="submit" class="text-xs text-amber-400 hover:text-amber-300">{{ __('backend.user_demote') }}</button>
                    </form>
                    @else
                    <form action="{{ route('admin.users.update-role') }}" method="POST" class="inline">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ $user->id }}">
                        <input type="hidden" name="role" value="admin">
                        <button type="submit" class="text-xs text-indigo-400 hover:text-indigo-300">{{ __('backend.user_promote') }}</button>
                    </form>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

<div class="mt-4">
    {{ $users->links() }}
</div>

</x-layouts.backend.backendMain>
