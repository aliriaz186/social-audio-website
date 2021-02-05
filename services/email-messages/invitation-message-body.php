<?php

namespace services\email_messages;

class InvitationMessageBody
{
    public function invitationMessageBody()
    {
        $emailBody = '
   <body>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Welcome to nincati!</div><br>
             <div style="margin-left: 50px;font-size: 25px;padding-top: 40px">Please Login to start uploading your own content!</div><br>
 <div style="padding-top: 30px;padding-bottom: 40px">
 <a href="'. url(''). '/user-login" style=" background-color: #1AAA55;
  border: none;
  color: white;
  padding: 10px 27px;
  text-align: center;
  text-decoration: none;
  display: inline-block;
  font-size: 18px;
  cursor: pointer;
  border-radius: 3px;margin-left: 50px">Login</a>
  </div>
            </body>
            ';
        return $emailBody;
    }

}
