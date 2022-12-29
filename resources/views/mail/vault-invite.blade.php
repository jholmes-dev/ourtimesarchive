<div style="border-right:4px solid #fa7766;border-bottom:4px solid #fa7766;font-family:verdana, sans-serif;font-size:16px;line-height:1.5;max-width:600px;margin:0 auto;background:#eeeeee;border-radius:13px;">
    
    <div style="padding:32px 16px;text-align:center;border-bottom:2px solid #fa7766;">
        <img style="max-width:150px;" src="{{ Vite::asset('resources/images/logo-icon.png') }}" alt="{{ config('app.name') }}" />
    </div>

    <div style="padding:42px 32px;">
        
        <h1 style="text-align:center;font-family:trebuchet ms, sans-serif;font-weight:bold;font-size:26px;margin: 4px 0 0;">You've received a vault invitation!</h1>

        <div style="background:#fca379;color:white;padding: 16px;border-radius:3px;margin: 36px 0;">
            <p style="margin:0 0 12px;text-align:center;">{{ $invite->fromUser->name }} has invited you to join their vault:</p>
            <h3 style="text-align:center;font-size:20px;margin:0;"><strong>{{ $invite->vault->name }}</strong></h3>
        </div>

        <p>Use the button below to join the vault and start building your memory archive together!</p>

        <p style="text-align:center;margin:32px 0 16px;">
            <a href="" target="_blank" style="box-shadow:3px 3px 3px rgba(0, 0, 0, .3);border-right:4px solid #fa7766;border-bottom:4px solid #fa7766;background:#fa7766;border-radius:6px;color:white;font-size:20px;text-decoration:none;padding:8px 30px;display:inline-block;">Join Vault</a>
        </p>

    </div>

</div>