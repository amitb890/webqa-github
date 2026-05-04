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
              <p style="margin:0 0 8px;font-size:15px;line-height:1.6;color:#3d3d3d;"><strong>Your Page Speed scores are ready for {{ $projectName }}</strong></p>
              <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#3d3d3d;">We’ve finished checking the performance scores for the {{ $urlCount }} URLs you submitted. Depending on the number of pages, these checks can take some time – but your results are now ready to review.</p>
              <p style="margin:0 0 12px;font-size:15px;font-weight:600;color:#1a1a1a;">What you can do next:</p>
              <ul style="margin:0 0 24px;padding:0 0 0 20px;font-size:15px;line-height:1.7;color:#3d3d3d;">
                <li>View performance scores for each URL</li>
                <li>Identify pages that may be slowing down your website</li>
                <li>Prioritise optimisation opportunities</li>
                <li>Improve user experience and search performance</li>
              </ul>
              <p style="margin:0 0 12px;font-size:15px;font-weight:600;color:#1a1a1a;">Access your results here:</p>
              <p style="margin:0 0 8px;font-size:15px;">
                <a href="{{ $reportUrl }}" style="display:inline-block;background-color:#1e63b8;color:#ffffff;text-decoration:none;padding:12px 24px;border-radius:6px;font-weight:600;">View Page Speed Report</a>
              </p>
              <p style="margin:0 0 24px;font-size:13px;line-height:1.5;color:#5c5c5c;word-break:break-all;">{{ $reportUrl }}</p>
              <p style="margin:0 0 20px;font-size:15px;line-height:1.6;color:#3d3d3d;">Improving page speed can positively impact user engagement, conversions, and SEO rankings – making it an important part of maintaining a high-performing website.</p>
              <p style="margin:0 0 24px;font-size:15px;line-height:1.6;color:#3d3d3d;">If you have any questions or need help interpreting the results, feel free to reach out at <a href="mailto:support@webqa.co" style="color:#1e63b8;text-decoration:none;">support@webqa.co</a>.</p>
              <p style="margin:0;font-size:15px;line-height:1.5;color:#1a1a1a;">Best regards,<br><span style="color:#5c5c5c;">Team WebQA</span></p>
            </td>
          </tr>
        </table>
      </td>
    </tr>
  </table>
</body>
</html>
