<x-emails.shell
    :title="__('frontend.email_contact_admin_title', ['name' => $data->name])"
    :subtitle="__('frontend.email_contact_admin_sub')"
>
    <div
        style="margin-top:8px;padding:16px 18px;background-color:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;"
    >
        <h2
            style="margin:0 0 12px;font-size:13px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#a5b4fc;"
        >
            {{ __('frontend.email_section_details') }}
        </h2>
        <table role="presentation" style="width:100%;border-collapse:collapse;">
            <tr>
                <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                    {{ __('frontend.email_field_name') }}
                </td>
                <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">{{ $data->name }}</td>
            </tr>
            <tr>
                <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                    {{ __('frontend.email_field_email') }}
                </td>
                <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">
                    <a href="mailto:{{ $data->email }}" style="color:#818cf8;text-decoration:none;">{{ $data->email }}</a>
                </td>
            </tr>
            @if (! empty($data->phone))
                <tr>
                    <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                        {{ __('frontend.email_field_phone') }}
                    </td>
                    <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">{{ $data->phone }}</td>
                </tr>
            @endif
            <tr>
                <td style="padding:8px 12px 8px 0;vertical-align:top;font-weight:700;font-size:13px;color:#c7d2fe;white-space:nowrap;">
                    {{ __('frontend.email_field_subject') }}
                </td>
                <td style="padding:8px 0;vertical-align:top;font-size:15px;color:#f4f4f5;line-height:1.45;">{{ $data->subject }}</td>
            </tr>
        </table>
    </div>

    <div
        style="margin-top:16px;padding:16px 18px;background-color:rgba(255,255,255,0.04);border:1px solid rgba(255,255,255,0.08);border-radius:12px;"
    >
        <h2
            style="margin:0 0 12px;font-size:13px;font-weight:700;letter-spacing:0.06em;text-transform:uppercase;color:#a5b4fc;"
        >
            {{ __('frontend.email_section_message') }}
        </h2>
        <p style="margin:0;font-size:15px;line-height:1.55;color:#d4d4d8;white-space:pre-wrap;">{{ $data->message }}</p>
    </div>
</x-emails.shell>
