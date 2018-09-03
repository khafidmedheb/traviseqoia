<?php

namespace spec\Service;

use Entity\ReleaseNote;
use Service\ReleaseService;
use Repository\ReleaseNoteRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;
use Symfony\Component\DependencyInjection\ContainerInterface;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class ReleaseServiceSpec extends ObjectBehavior
{
    function let(EntityManager $entityManager,
                 ReleaseNoteRepository $releaseNoteRepository, 
                 EntityRepository $entityRepository,
                 ReleaseNote $releaseNote)
    {
    	$this->beConstructedWith(
            $entityManager,
            $releaseNoteRepository,
            $entityRepository,
            $releaseNote);
    }

    function it_is_initializable()
    {
        $this->shouldHaveType(ReleaseService::class);
    }

    function it_displays_the_main_title()
    {
    	$this->dispMainTitle("Bienvenue sur la release note")->shouldReturn("<h1>Bienvenue sur la release note</h1>");
    }

    function it_concats_description_and_version_of_release()
    {
    	$this->concatTitle("Test release - , version v1.1.2")->shouldReturn("Test release - version v1.1.2");
    }

    function it_should_remove_release(
        EntityManager $entityManager,
        ReleaseNoteRepository $releaseNoteRepository,
        ReleaseNote $releaseNote)
    {
    	$id = 1;
    	$releaseNoteRepository->findFirst($id)->willReturn($releaseNote);
    	$entityManager->remove($releaseNote)->shouldBeCalled();
    	$entityManager->flush()->shouldBeCalled();

    	$this->deleteRelease($id)->shouldReturn(true);
    }

    // TODO : Spec pour créer une release
    // function it_should_create_release(
    //     EntityManager $entityManager,
    //     ReleaseNoteRepository $releaseNoteRepository,
    //     ReleaseNote $releaseNote
    // ) {

     
    //  $releaseNoteRepository->findOneById($id)->willReturn($release);
    //  $entityManager->persist($release)->shouldBeCalled();
    //  $entityManager->flush()->shouldBeCalled();

    //  $this->createRelease($id)->shouldReturn(true);
    // }
    

    //TODO
    // function it_should_return_a_release_if_a_record_is_found_in_database(ReleaseNoteRepository $releaseNoteRepository, ReleaseNote $releaseNote)
    // {
    //     $id = 1;
    //     $releaseNoteRepository->findFirst($id)->willReturn($releaseNote);
    //     $releaseNoteRepository->findFirst($id)->willReturn([
    //         'id' => 1,
    //         'title' => 'testrelease',
    //         'description' => 'descrelease',
    //         'markdown' => 'markrelease',
    //         'version' => 'versrelease',
    //         'date' => '2018-08-30',
    //         'published' => 1,
    //     ])->shouldBeCalled();

    //     $response = $this->findFirst(1);

    //     $response->shouldHaveType(ReleaseNote::class);
    //     $response->id->shouldBe(1);
    //     $response->title->shouldBe('testrelease');
    //     $response->description->shouldBe('descrelease');
    //     $response->markdown->shouldBe('markrelease');
    //     $response->version->shouldBe('versrelease');
    //     $response->date->shouldBe('2018-08-30');
    //     $response->published->shouldBe(1);
    // }

    // function it_should_return_the_first_release(
    //     EntityManager $entityManager,
    //     ReleaseNoteRepository $releaseNoteRepository,
    //     ReleaseNote $releaseNote)
    // {
    // 	$id = 1;
    // 	// $releaseNoteRepository->findFirst($id)->willReturn($releaseNote);

    // 	// $this->showFirstRelease($id)->shouldReturn(true);

    // 	$this->findFirst($id)->willReturn($releaseNote);
    // }


    


    //TODO : Spec pour lire une release
    // function it_should_read_release(
    //     EntityManager $entityManager,
    //     ReleaseRepository $releaseRepository,
    //     Release $release
    // ) {

    //  $releaseRepository->findOneById($id)->willReturn($release);
    //  $entityManager->persist($release)->shouldBeCalled();
    //  $entityManager->flush()->shouldBeCalled();

    //  $this->showRelease($id)->shouldReturn(true);
    // }
    

    //Spec pour mettre à jour une release
    // function it_should_update_release(
    //     EntityManager $entityManager,
    //     ReleaseRepository $releaseRepository,
    //     ReleaseNote $release
    // ) {

    //  $id = 1;
    //  $releaseRepository->findOneById($id)->willReturn($release);
    //  $entityManager->persist($release)->shouldBeCalled();
    //  $entityManager->flush()->shouldBeCalled();

    //  $this->updateRelease($id)->shouldReturn(true);
    // }

    //Spec pour supprimer une release
    // function it_should_delete_release(
    //     EntityManager $entityManager,
    //     ReleaseRepository $releaseRepository,
    //     Release $release
    // ) {

    //  $id = 1;
    //  $releaseRepository->findOneById($id)->willReturn($release);
    //  $entityManager->remove($release)->shouldBeCalled();
    //  $entityManager->flush()->shouldBeCalled();

    //  $this->deleteRelease($id)->shouldReturn(true);
    // }

    
    // public function it_should_throw_an_exception_if_no_release_data_is_found_in_database(ReleaseNoteRepository $releaseNoteRepository,
    //     ReleaseNote $releaseNote)
    // {   
    //     $id = 99;

    //     $releaseNoteRepository->findFirst($id)->willReturn(null);

    //     $this->shouldThrow(
    //        new \Exception(
    //            sprintf('Release [%] cannot be found.', $id)
    //        )
    //    )->duringdeleteRelease($id);

    //     $releaseNoteRepository->findFirst(1)->willReturn(null)->shouldBeCalled();
    //     $this->shouldThrow(NoSuchReleaseException::class)->duringFindFirst(1);
      
    //     $releaseNoteRepository->findFirst($id)->willReturn(null)->shouldBeCalled();
    //     $this->shouldThrow(
    //        new \Exception(
    //            sprintf('Release [%] cannot be found.', $id)
    //        )
    //     )->duringFindFirst($id);
    // }

    //Spec to find last data
    //Spec to updtae the description




}
