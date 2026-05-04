<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body style="margin:0;padding:0;background-color:#f4f6f8;font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,'Helvetica Neue',Arial,sans-serif;">
  <table role="presentation" width="100%" cellspacing="0" cellpadding="0" style="background-color:#f4f6f8;padding:24px 12px;">
    <tr>
      <td align="center">
        <table role="presentation" width="100%" style="max-width:600px;background-color:#ffffff;border-radius:8px;overflow:hidden;box-shadow:0 1px 3px rgba(0,0,0,0.08);">
          <tr>
            <td style="background:linear-gradient(135deg,#1e63b8 0%,#155a9e 100%);padding:24px 32px;">
              <p style="margin:0;font-size:20px;font-weight:700;color:#ffffff;">WebQA</p>
            </td>
          </tr>
          <tr>
            <td style="padding:32px;">
              <p style="margin:0 0 16px;font-size:16px;line-height:1.5;color:#1a1a1a;">Hi {{ $firstName }},</p>
              <p style="margin:0 0 16px;font-size:15px;line-height:1.6;color:#3d3d3d;">We received a request to reset the password for your WebQA account.</p>
              <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#3d3d3d;">Click the link below to create a new password:</p>
              <p style="margin:0 0 24px;font-size:15px;">
                <a href="{{ $resetUrl }}" style="display:inline-block;background-color:#1e63b8;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:6px;font-weight:600;">Reset Password</a>
              </p>
              <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#3d3d3d;">For security reasons, this link will expire in 24 hours.</p>
              <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#3d3d3d;">If you didn’t request a password reset, you can safely ignore this email – your account will remain secure.</p>
              <p style="margin:0 0 8px;font-size:15px;line-height:1.6;color:#3d3d3d;">Need help? Contact us at <a href="mailto:support@webqa.co" style="color:#1e63b8;text-decoration:none;">support@webqa.co</a> and we’ll be happy to assist.</p>
              <p style="margin:24px 0 0;font-size:15px;line-height:1.5;color:#1a1a1a;">Best regards,<br><span style="color:#5c5c5c;">Team WebQA</span></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
