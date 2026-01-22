<div style="font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; background-color: #f9f9f9;">
    <h2 style="color: #333; border-bottom: 2px solid #ccc; padding-bottom: 10px;">📝 New Become A Dealer Request</h2>
    
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
            <td style="padding: 8px;">{{ $formData['phone'] }}</td>
        </tr>
      
       
        <tr>
            <td style="padding: 8px; font-weight: bold;">Address:</td>
            <td style="padding: 8px;">{{ $formData['address'] }}</td>
        </tr>
         <tr>
            <td style="padding: 8px; font-weight: bold;">State:</td>
            <td style="padding: 8px;">{{ $formData['state'] }}</td>
        </tr>
        
        <tr>
            <td style="padding: 8px; font-weight: bold;">Message:</td>
            <td style="padding: 8px;">{{ $formData['message'] }}</td>
        </tr>
    </table>
</div>
