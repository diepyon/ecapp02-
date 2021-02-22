<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Thanks extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($mail_data)//コントローラーから送付先ユーザーの情報を格納した配列を取得
    {
        $this->mail_data = $mail_data; //thisクラスのmail_dataプロパティに送付先ユーザーの情報を格納
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('mails.thanks', $this->mail_data)->subject(config('app.name', 'Laravel'). 'でのご購入ありがとうございます');
        //$this->mail_dataは上記の__constructメソッドでしか定義していないのに、なぜこのbuildメソッドの中でも使えるのか
    }
}
