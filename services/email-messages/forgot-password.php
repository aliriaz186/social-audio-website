<?php

namespace services\email_messages;

class ForgotPasswordMessage
{
    public function invitationMessageBody(string $token)
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Please click on the below button to reset your password</div><br>
 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. url(''). '/reset-password/'. $token. '" style=" background-color: #1AAA55;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">RESET PASSWORD</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

}
