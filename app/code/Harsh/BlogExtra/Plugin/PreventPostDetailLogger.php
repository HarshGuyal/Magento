<?php declare(strict_types=1);

namespace harsh\BlogExtra\Plugin;

use Harsh\Blog\Observer\LogPostDetailView;

class PreventPostDetailLogger{

    public function aroundExecute(
        LogPostDetailView $subject,
        callable $proceed,
    ){
        // dont't do anything to prevent logger from executing
    }
}