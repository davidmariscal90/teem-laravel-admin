<!DOCTYPE html>
<html lang="en">

  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Prematch Email Notification</title>
  </head>


  <body style="font-family:'arial';">
      <div style="background: #fff max-width: 100%;text-align: left">
        <p class="thanking-text" style="color: #9d9d9d; font-size: 16px; padding-bottom: 15px;">Dear {{ $username }}</p>
      </div>

    <div class="email-block" style="background: #f6f6f6 none repeat scroll 0 0; border: 1px solid #e1e1e1; margin: 40px auto; max-width: 100%; padding: 30px 0; text-align: center; width: 600px; overflow: hidden;">
        <p align="center" style="padding-top:10px"><b>Your match has been canceled</b></p>
        <table align="left" style="padding: 10px 30px 10px 30px ;">
            <tr>
                <td align="left"><b>Match Name:</b></td>
                <td align="left">{{ $matchname}}</td>
            </tr>
            <tr>
                <td align="left"><b>Match Address:</b></td>
                <td align="left">{{ $matchaddress}}</td>
            </tr>
        </table>

        <p class="thanking-text" style="color: #9d9d9d; font-size: 16px; padding-bottom: 15px;">Thank you, <br> Teem Players</p>

    </div>

  </body>

</html>

