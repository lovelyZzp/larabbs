<?php

namespace App\Observers;

use App\Models\Reply;
use App\Notifications\TopicReplied;

class ReplyObserver
{
    public function created(Reply $reply)
    {
        if ($reply->topic) {
            $reply->topic->updateReplyCount();

            // 通知话题作者有新的评论（确保话题作者存在）
            if ($reply->topic->user) {
                $reply->topic->user->notify(new TopicReplied($reply));
            }
        }
    }

    public function creating(Reply $reply)
    {
        $reply->content = clean($reply->content, 'user_topic_body');
    }

    public function deleted(Reply $reply)
    {
        if ($reply->topic) {
            $reply->topic->updateReplyCount();
        }
    }
}
