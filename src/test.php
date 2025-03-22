<html>
            <head>
                <style>
                    .email-container { font-family: Arial, sans-serif; max-width: 600px; margin: auto; border: 1px solid #ddd; padding: 20px; }
                    .header { background-color: #007bff; color: white; padding: 15px; text-align: center; font-size: 20px; }
                    .order-details { width: 100%; border-collapse: collapse; margin-top: 20px; }
                    .order-details th { background-color: #007bff; color: white; padding: 10px; text-align: left; }
                    .order-summary { font-size: 18px; font-weight: bold; text-align: right; padding: 10px; margin-top: 10px; }
                </style>
            </head>
            <body>
                <div class='email-container'>
                    <div class='header'>Invoice for Order #$referenceNum</div>
                    <p>Dear Customer,</p>
                    <p>Thank you for your order! Below is your order summary:</p>
                    
                    <table class='order-details'>
                        <tr>
                            <th>Product Name</th>
                            <th>Quantity</th>
                            <th>Total Price</th>
                        </tr>
                        $itemsHTML
                    </table>
                    
                    <p class='order-summary'>Total Order Amount: $" . number_format($totalOrderAmount, 2) . "</p>
                    
                    <p>If you have any questions, feel free to contact us.</p>
                    <p>Best regards,<br>Your Company Name</p>
                </div>
            </body>
            </html>