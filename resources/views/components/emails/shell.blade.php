@props([
    'title',
    'subtitle' => null,
])

@php
    $appHost = parse_url(config('app.url'), PHP_URL_HOST)
        ?: preg_replace('#^https?://#', '', rtrim((string) config('app.url'), '/'));
@endphp
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="color-scheme" content="dark light" />
    <meta name="supported-color-schemes" content="dark light" />
    <title>{{ $title }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700;800&display=swap" rel="stylesheet" />
</head>
<body style="margin:0;padding:0;background-color:#09090b;">
    <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#09090b;">
        <tr>
            <td align="center" style="padding:32px 16px;">
                <table
                    role="presentation"
                    width="100%"
                    cellspacing="0"
                    cellpadding="0"
                    style="max-width:560px;background-color:rgba(24,24,27,0.96);border:1px solid rgba(255,255,255,0.1);border-radius:16px;"
                >
                    <tr>
                        <td style="padding:28px 24px 8px;font-family:'Nunito',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
                            <p
                                style="margin:0 0 8px;font-size:11px;font-weight:700;letter-spacing:0.08em;text-transform:uppercase;color:#a1a1aa;"
                            >
                                {{ config('app.name') }}
                            </p>
                            <h1 style="margin:0;font-size:20px;font-weight:700;color:#fafafa;line-height:1.3;">
                                {{ $title }}
                            </h1>
                            @if ($subtitle)
                                <p style="margin:12px 0 0;font-size:15px;line-height:1.55;color:#a1a1aa;">
                                    {{ $subtitle }}
                                </p>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 24px 12px;font-family:'Nunito',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
                            {{ $slot }}
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:8px 24px 28px;font-family:'Nunito',-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;">
                            <p style="margin:0;font-size:12px;line-height:1.55;color:#71717a;text-align:center;">
                                <a href="{{ config('app.url') }}" style="color:#818cf8;text-decoration:none;">{{ $appHost }}</a>
                                <span style="color:#52525b;"> · </span>
                                © {{ date('Y') }}
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>
</html>
