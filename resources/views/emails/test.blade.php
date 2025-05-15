<div
    style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background-color: #1a1a1a; color: #f5f5f5; border-radius: 8px; border: 1px solid #333;">
    <h2 style="color: #bfbb00; border-bottom: 2px solid #bfbb00; padding-bottom: 10px; text-align: center;">
        SendGrid API Test Email
    </h2>

    <p style="margin-top: 20px; font-size: 16px; color: #dcdcdc; text-align: center;">
        This is a test email to verify that the SendGrid API integration is working correctly.
    </p>

    <div style="margin-top: 20px; padding: 15px; background-color: #292929; border-radius: 8px;">
        <h3 style="color: #bfbb00; margin-bottom: 10px;">Test Details</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Timestamp:</td>
                <td style="padding: 10px; color: #f5f5f5;">{{ $data->timestamp }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Application:</td>
                <td style="padding: 10px; color: #f5f5f5;">Smash Up Randomizer</td>
            </tr>
        </table>
    </div>

    <p style="margin-top: 20px; font-size: 14px; color: #999; text-align: center;">
        If you received this email, your SendGrid API integration is working correctly.
    </p>
</div>
