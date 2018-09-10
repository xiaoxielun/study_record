<?php

namespace App\Console\Commands;

use App\User;
use App\DripEmailer;
use Illuminate\Console\Command;

class SendEmails extends Command
{
    /**
     * 控制台命令 signature 的名称。
     *
     * @var string
     */
    protected $signature = 'email:send {user}';

    /**
     * 控制台命令说明。
     *
     * @var string
     */
    protected $description = 'Send drip e-mails to a user';

    /**
     * 邮件服务的 drip 属性。
     *
     * @var DripEmailer
     */
    protected $drip;

    /**
     * 创建一个新的命令实例。
     *
     * @param  DripEmailer  $drip
     * @return void
     */
    public function __construct(DripEmailer $drip)
    {
        parent::__construct();

        $this->drip = $drip;
    }

    /**
     * 执行控制台命令。
     *
     * @return mixed
     */
    public function handle()
    {
        $this->drip->send(User::find($this->argument('user')));
    }
}