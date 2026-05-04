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
              <p style="margin:8px 0 0;font-size:14px;color:rgba(255,255,255,0.9);line-height:1.4;">Submit your idea</p>
            </td>
          </tr>
          <tr>
            <td style="padding:32px;">
              <p style="margin:0 0 16px;font-size:16px;line-height:1.5;color:#1a1a1a;">Hi,</p>
              <p style="margin:0 0 24px;font-size:15px;line-height:1.6;color:#3d3d3d;">A new lead from Webqa dashboard</p>
              <p style="margin:0 0 10px;font-size:14px;font-weight:600;color:#1a1a1a;">Name</p>
              <p style="margin:0 0 18px;font-size:15px;line-height:1.6;color:#3d3d3d;word-break:break-word;">{{ $leadName }}</p>
              <p style="margin:0 0 10px;font-size:14px;font-weight:600;color:#1a1a1a;">Email address</p>
              <p style="margin:0 0 18px;font-size:15px;line-height:1.6;color:#3d3d3d;word-break:break-word;"><a href="mailto:{{ $leadEmail }}" style="color:#1e63b8;text-decoration:none;">{{ $leadEmail }}</a></p>
              <p style="margin:0 0 10px;font-size:14px;font-weight:600;color:#1a1a1a;">URL</p>
              <p style="margin:0 0 18px;font-size:15px;line-height:1.6;color:#3d3d3d;word-break:break-all;">
                @if(trim((string) $leadUrl) !== '' && $leadUrl !== '—')
                  <a href="{{ $leadUrl }}" style="color:#1e63b8;text-decoration:none;">{{ $leadUrl }}</a>
                @else
                  <span style="color:#8a8a8a;">—</span>
                @endif
              </p>
              <p style="margin:0 0 10px;font-size:14px;font-weight:600;color:#1a1a1a;">Issue</p>
              <p style="margin:0 0 18px;font-size:15px;line-height:1.7;color:#3d3d3d;white-space:pre-wrap;word-break:break-word;">{{ $issue }}</p>
              <p style="margin:0 0 10px;font-size:14px;font-weight:600;color:#1a1a1a;">Severity</p>
              <p style="margin:0 0 24px;font-size:15px;line-height:1.6;color:#3d3d3d;">{{ $severity }}</p>
              <p style="margin:0;font-size:15px;line-height:1.5;color:#1a1a1a;">Thanks</p>
            </td>
          </tr>
        </table>
        <p style="margin:16px 0 0;font-size:12px;color:#8a8a8a;max-width:600px;">This notification was sent from the WebQA dashboard.</p>
      </td>
    </tr>
  </table>
</body>
</html>
