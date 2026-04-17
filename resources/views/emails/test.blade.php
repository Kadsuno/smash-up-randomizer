<x-emails.shell
    :title="__('frontend.email_test_title')"
    :subtitle="__('frontend.email_test_sub')"
>
    <div
        style="margin-top:8px;padding:16px 18px;background-color:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;"
    >
        <h2
            style="margin:0 0 12px;font-size:13px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#a5b4fc;"
        >
            {{ __('frontend.email_test_section') }}
        </h2>
        <table role="presentation" style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                    {{ __('frontend.email_field_timestamp') }}
                </td>
                <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">{{ $data->timestamp }}</td>
            </tr>
            <tr>
                <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                    {{ __('frontend.email_field_application') }}
                </td>
                <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">{{ config('app.name') }}</td>
            </tr>
        </table>
    </div>

    <p style="margin:20px 0 0;font-size:14px;line-height:1.55;color:#a1a1aa;text-align:center;">
        {{ __('frontend.email_test_ok') }}
    </p>
</x-emails.shell>
