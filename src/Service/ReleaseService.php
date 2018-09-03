<?php

namespace App\Service;

use Entity\ReleaseNote;
use Repository\ReleaseNoteRepository;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\EntityManager;

class ReleaseService extends EntityRepository
{
    private $releaseNoteRepository;
    private $entityManager;

    public function __construct(EntityManager $entityManager, ReleaseNoteRepository $releaseNoteRepository, EntityRepository $entityRepository, ReleaseNote $releaseNote)
    {
        $this->entityManager = $entityManager;
        $this->releaseNoteRepository = $releaseNoteRepository;
        $this->entityRepository = $entityRepository;
        $this->releaseNote = $releaseNote;
    }

    public function dispMainTitle()
    {
        return '<h1>Bienvenue sur la release note</h1>';
    }

    /**
     * @param int $id TODO
     *
     * @return ReleaseNote[] Returns an array of Release objects
     */
    public function findFirst($id)
    {
        $sql = 'select r from App:ReleaseNote r where r.id= :id order by r.id desc';

        $results = $this->getEntityManager()->createQuery($sql)->setParameters(array('id' => $id))->setMaxResults(1)->getOneOrNullResult();

        return $results;
    }

    public function deleteRelease($id)
    {
        $release = $this->releaseNoteRepository->findFirst($id);

        if (!$release instanceof ReleaseNote) {
            throw new \Exception(
                sprintf('ReleaseNote [%s] cannot be found.', $id)
            );
        }

        try {
            $this->entityManager->remove($release);
            $this->entityManager->flush();

            return true;
        } catch (Exception $e) {
            error_log($e->getMessage());
        } catch (DBALException $e) {
            $message = sprintf('DBALException: %s', $e->getMessage());
        } catch (ORMException $e) {
            $message = sprintf('ORMException: %s', $e->getMessage());
        } catch (Exception $e) {
            $message = sprintf('Exception: %s', $e->getMessage());
        }
    }
}
