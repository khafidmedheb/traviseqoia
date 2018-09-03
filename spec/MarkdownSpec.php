<?php

namespace spec;

use Markdown;
use PhpSpec\ObjectBehavior;

/*
 Notes : BDD is a technique used at story level and spec level. phpspec is a tool for use at the spec level or SpecBDD. The technique is to first use a tool like phpspec to describe the behaviour of an object you are about to write. Next you write just enough code to meet that specification and finally you refactor this code.

 BDD is a technique derived from test-first development.

 */

/**
 * You are building a tool that converts Markdown into HTML.
 */
class MarkdownSpec extends ObjectBehavior
{
    //phpspec searches for these methods in your specification to run.
    // function it_is_initializable()
    // {
    //     $this->shouldHaveType(Markdown::class);
    // }

    public function it_converts_plain_text_to_html_paragraphs()
    {
        //you are telling phpspec that your object has a toHtml method
        //You are also telling it that this method should return “<p>Hi, there</p>”.
        $this->toHtml('Hi, there')->shouldReturn('<p>Hi, there</p>');
    }
}
