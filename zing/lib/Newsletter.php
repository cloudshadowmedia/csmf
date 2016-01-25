<?php

class NewsLetter {

    public static function getValidSubscribers() {
        $subscribers = array_map("trim", file(APP_ROOT . "/files/subscribers.txt"));
        $unscubscribe = array_map("trim", file(APP_ROOT . "/files/unsubscribe.txt"));
        $bounced = array_map("trim", file(APP_ROOT . "/files/bounced.txt"));
        $remove = array_unique(array_merge($unscubscribe, $bounced));
        header('Content-Type: text/plain');
        foreach ($subscribers as $subscriber):
            if (!filter_var($subscriber, FILTER_VALIDATE_EMAIL)) {
                //print $subscriber . " NOT VALID EMAIL" . "\n";
            }
            if (!in_array($subscriber, $remove)) {
                print $subscriber . "\n";
            } else {
                //print "PURGING " . $subscriber;
            }
        endforeach;
    }

}