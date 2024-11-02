<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; padding: 20px; background-color: #1a1a1a; color: #f5f5f5; border-radius: 8px; border: 1px solid #333;">
    <!-- Header -->
    <h2 style="color: #bfbb00; border-bottom: 2px solid #bfbb00; padding-bottom: 10px; text-align: center;">
        Hello, my name is {{ $data->name }}.
    </h2>

    <!-- Intro Text -->
    <p style="margin-top: 20px; font-size: 16px; color: #dcdcdc; text-align: center;">
        You have received a new message from <strong>{{ $data->name }}</strong> via the contact form on Smash Up Randomizer.
    </p>

    <!-- User Details Section -->
    <div style="margin-top: 20px; padding: 15px; background-color: #292929; border-radius: 8px;">
        <h3 style="color: #bfbb00; margin-bottom: 10px;">User Details</h3>
        <table style="width: 100%; border-collapse: collapse;">
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Name:</td>
                <td style="padding: 10px; color: #f5f5f5;">{{ $data->name }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Email:</td>
                <td style="padding: 10px; color: #f5f5f5;">{{ $data->email }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Phone:</td>
                <td style="padding: 10px; color: #f5f5f5;">{{ $data->phone }}</td>
            </tr>
            <tr>
                <td style="padding: 10px; font-weight: bold; color: #bfbb00;">Subject:</td>
                <td style="padding: 10px; color: #f5f5f5;">{{ $data->subject }}</td>
            </tr>
        </table>
    </div>

    <!-- Message Section -->
    <div style="margin-top: 20px; padding: 15px; background-color: #292929; border-radius: 8px;">
        <h3 style="color: #bfbb00;">Message</h3>
        <p style="font-size: 16px; color: #dcdcdc;">
            {{ $data->message }}
        </p>
    </div>

    <!-- Footer -->
    <p style="margin-top: 20px; font-size: 14px; color: #888888; text-align: center;">
        This message was sent from the <a href="https://www.smash-up-randomizer.com" style="color: #bfbb00; text-decoration: none;">Smash Up Randomizer</a> website.
    </p>
</div>
