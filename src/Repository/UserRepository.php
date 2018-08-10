<?php

namespace App\Repository;

use Doctrine\ORM\EntityRepository;

/**
 * Classe des queries sur la table Users
 */
class UserRepository extends EntityRepository
{
	
	/**
	 * Recherche du seul utilisateur Toto
	 * @param string $name nom du user attendu
	 * @return Entity
	 */
	public function getUserToto($name)
	{
		$sql = 'select u from App:User u where u.username= :name';
		$result = $this->getEntityManager()->createQuery($sql)->setParameters(array("name" => $name))->setMaxResults(1)->getOneOrNullResult();

		return $result;
	}


	/**
	 * Liste tous les users par nom
	 */
	public function findAllOrderedByName()
	{
		$sql = 'SELECT u FROM App:User u ORDER BY u.username ASC';
		return $this->getEntityManager()
		    ->createQuery($sql)
		    ->getResult();
	}
}