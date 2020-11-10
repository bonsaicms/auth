<?php

namespace App\Notifications;

use BonsaiCms\Notifications\AbstractResetPassword;

class ResetPassword extends AbstractResetPassword
{
    protected function resolveResetUrl($notifiable)
    {
        return url('admin/auth/password/reset', [
            $notifiable->getEmailForPasswordReset(),
            $this->token,
        ]);
    }
}
