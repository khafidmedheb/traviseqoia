<?php

namespace spec\Entity;

use Entity\ReleaseNote;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseNoteSpec extends ObjectBehavior
{

    function it_is_initializable()
    {
        $this->shouldHaveType(ReleaseNote::class);
    }

    // function it_is_a_dependent_function()
    // {
    //     if (!function_exists('ma_fonction_dependante')) {
    //         throw new SkippingException('ma fonction dependante is not installed');
    //     }

    //     $this->flyToTheMoon();
    // }
    
    //Spec pour les setters et getters
    //TODO
    // function its_id_should_be_readable ()
    // { 
    //     $this->setId(1); 
    //     $this->getId()->shouldReturn(1);
    //     $this->getId()->shouldBeInteger();
    // }
    
    function its_title_should_be_mutable ()
    {
        $this->setTitle('Toto'); 
        $this->getTitle()->shouldReturn('Toto');
        $this->getTitle()->shouldBeString();
    }

    function its_description_should_be_mutable ()
    {
        $this->setDescription('Developpeur');
        $this->getDescription()->shouldReturn('Developpeur');
        $this->getDescription()->shouldBeString();
    }

    function its_markdown_should_be_mutable ()
    {
        $this->setMarkdown('Ma release');
        $this->getMarkdown()->shouldReturn('Ma release');
        $this->getMarkdown()->shouldBeString();
    }

    function its_version_should_be_mutable ()
    {
        $this->setVersion('v1.1.2');
        $this->getVersion()->shouldReturn('v1.1.2');
        $this->getVersion()->shouldBeString();
    }

    function its_date_should_be_mutable ()
    {
         $this->setDate('2018-08-30');
         $this->getDate()->shouldReturn('2018-08-30');
    }

    function its_published_release_should_be_mutable ()
    {
        $this->setPublished(true);
        $this->getPublished()->shouldReturn(true);
        $this->getPublished()->shouldBeBool();
    }

    // TODO : à dev
    // function its_difference_of_date_should_be_seen (TimeNow $now)
    // {
    //     $this->getDiffDate()->shouldReturn($now-)
    // }
    
    //Pour avoir ça !
    // public function getDiffDate()
    // {
    //     $now = new \DateTime(date('Y-m-d'));

    //     return $now->diff($this->date)->format('%a');
    // }
}
