<?php

namespace spec;

use Markdown;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class MarkdownSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(Markdown::class);
    }
}
