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


	public function findAllUsers()
	{
		$sql = 'SELECT u FROM App:User u ';

		$result = $this->getEntityManager()
		    ->createQuery($sql)
		    ->getResult();
        
        return $result;
	}


	/**
	 * Liste tous les users par nom
	 */
	public function findAllOrderedByName()
	{
		$sql = 'SELECT u FROM App:User u order by u.username asc';

		$result = $this->getEntityManager()
		    ->createQuery($sql)
		    ->getResult();
        
        return $result;
	}

	/**
	 * Recherche du dernier utilisateur enregistré
	 *
	 * @param string $name
	 *
	 * @return Entity
	 */
	public function findLastUser($name)
	{
		$sql = 'select u from App:User u where u.username= :name';


		$result = $this->getEntityManager()
		    ->createQuery($sql)
		    ->getResult();
        
        return $result;
	}


    /**
	 * Vérifie si un admin est présent dans la table users
	 *
	 * @param string $name
	 * @param string $email
	 *
	 * @return Entity
	 */
	public function verifyAdminTotoIsRegistered($name, $email)
    {
    	$sql = 'SELECT u FROM App:User u WHERE u.username = :name AND u.email = :email';

    	$result = $this->getEntityManager()
    	    ->createQuery($sql)
    	    ->getResult();

    	return $result;
    }
}