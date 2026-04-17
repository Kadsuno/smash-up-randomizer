<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Authorization</title>

    @vite(['resources/css/app.css'])
</head>
<body class="min-h-screen bg-zinc-950 text-zinc-100 antialiased">
    <div class="mx-auto max-w-lg px-4 py-12 sm:px-6">
        <div class="sur-card border-white/10">
            <div class="border-b border-white/10 px-5 py-4">
                <h1 class="text-lg font-semibold text-white">Authorization Request</h1>
            </div>
            <div class="px-5 py-5 text-sm leading-relaxed text-zinc-300">
                <p class="mb-4"><strong class="text-white">{{ $client->name }}</strong> is requesting permission to access your account.</p>

                @if (count($scopes) > 0)
                    <div class="mb-6">
                        <p class="mb-2 font-medium text-zinc-200">This application will be able to:</p>
                        <ul class="list-disc space-y-1 pl-5">
                            @foreach ($scopes as $scope)
                                <li>{{ $scope->description }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                    <form method="post" action="{{ route('passport.authorizations.approve') }}" class="inline">
                        @csrf
                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <button type="submit" class="sur-btn-primary min-h-11 min-w-[8rem]">Authorize</button>
                    </form>

                    <form method="post" action="{{ route('passport.authorizations.deny') }}" class="inline">
                        @csrf
                        @method('DELETE')
                        <input type="hidden" name="state" value="{{ $request->state }}">
                        <input type="hidden" name="client_id" value="{{ $client->getKey() }}">
                        <input type="hidden" name="auth_token" value="{{ $authToken }}">
                        <button type="submit" class="sur-btn-secondary min-h-11 min-w-[8rem] border-red-500/40 text-red-200 hover:border-red-400/50 hover:bg-red-500/10">Cancel</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
