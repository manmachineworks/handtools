<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
    <h2 style="color: #333; border-bottom: 2px solid #ccc; padding-bottom: 10px;">📝 New Quote Request</h2>

    <table style="width: 100%; border-collapse: collapse; margin-top: 15px;">
        <tr>
            <td style="padding: 8px; font-weight: bold; width: 30%;">Name:</td>
            <td style="padding: 8px;">{{ $formData['name'] }}</td>
        </tr>
        <tr style="background-color: #f0f0f0;">
            <td style="padding: 8px; font-weight: bold;">Email:</td>
            <td style="padding: 8px;">{{ $formData['email'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">Mobile:</td>
            <td style="padding: 8px;">{{ $formData['mobile'] }}</td>
        </tr>
        <tr style="background-color: #f0f0f0;">
            <td style="padding: 8px; font-weight: bold;">Product:</td>
            <td style="padding: 8px;">{{ $formData['product_type'] }}</td>
        </tr>
        <tr>
            <td style="padding: 8px; font-weight: bold;">City:</td>
            <td style="padding: 8px;">{{ $formData['city'] }}</td>
        </tr>
        <tr style="background-color: #f0f0f0;">
            <td style="padding: 8px; font-weight: bold;">State:</td>
            <td style="padding: 8px;">{{ $formData['state'] }}</td>
        </tr>
        @isset($formData['submitted_at'])
        <tr>
            <td style="padding: 8px; font-weight: bold;">Submitted at:</td>
            <td style="padding: 8px;">{{ $formData['submitted_at'] }}</td>
        </tr>
        @endisset
        @isset($formData['ip'])
        <tr style="background-color: #f0f0f0;">
            <td style="padding: 8px; font-weight: bold;">IP:</td>
            <td style="padding: 8px;">{{ $formData['ip'] }}</td>
        </tr>
        @endisset
        @isset($formData['user_agent'])
        <tr>
            <td style="padding: 8px; font-weight: bold;">User Agent:</td>
            <td style="padding: 8px; word-break: break-all;">{{ $formData['user_agent'] }}</td>
        </tr>
        @endisset
    </table>
</div>
