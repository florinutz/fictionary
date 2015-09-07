<?php
namespace Flo\Bundle\FictionaryBundle\Repository;

use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Flo\Bundle\FictionaryBundle\Entity\Fiction;

class FictionRepository extends EntityRepository
{
    /**
     * @return Fiction
     *
     * @throws \Doctrine\ORM\NoResultException
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public function getRandom()
    {
        $rsm = new ResultSetMapping;
        $rsm->addEntityResult(Fiction::class, 'f');
        $rsm->addFieldResult('f', 'id', 'id');
        $rsm->addFieldResult('f', 'name', 'name');
        $rsm->addFieldResult('f', 'slug', 'slug');
        $rsm->addFieldResult('f', 'description', 'description');
        $rsm->addFieldResult('f', 'created_at', 'createdAt');
        $rsm->addFieldResult('f', 'updated_at', 'updatedAt');
        $rsm->addFieldResult('f', 'deleted_at', 'deletedAt');

        $query = $this->getEntityManager()->createNativeQuery(
            'SELECT * FROM fiction WHERE deleted_at IS NULL ORDER BY RAND() DESC LIMIT 1',
            $rsm
        );

        return $query->getOneOrNullResult();
    }
}
