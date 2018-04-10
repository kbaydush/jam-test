<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Repository;

use InviteVendor\UserBundle\Entity\User;
use InviteVendor\UserBundle\Exception\UserNotFoundException;
use InviteVendor\UserBundle\Model\UserFilter;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class UserRepository extends EntityRepository
{
    public function findAllByUsersFilter(UserFilter $filter): array
    {
        $alias = 'user';
        $sort = $filter->getSort($alias);
        $order = $filter->getOrder();
        $page = $filter->getOffset();
        $limit = $filter->getLimit();
//        $isActive = $filter->isActive();

        $expr = $this->getEntityManager()->getExpressionBuilder();
        $queryBuilder = $this->createQueryBuilder($alias);

//        if ('' !== $isActive) {
//            $queryBuilder->where($expr->eq($alias.'.active', ':active'));
//            $queryBuilder->setParameter('active', $isActive);
//        }

        $queryBuilder->orderBy($sort, $order);
        $queryBuilder->setFirstResult($page);
        $queryBuilder->setMaxResults($limit);

        return $queryBuilder->getQuery()->getResult();
    }

    public function findMatchingUsers(User $user): Collection
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();

        $criteria->where($expr->eq('externalId', $user->getExternalId()));

        return $this->matching($criteria);
    }

    /**
     * @throws NonUniqueResultException
     * @throws UserNotFoundException
     */
    public function findUser(string $userId): User
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $queryBuilder = $this->createQueryBuilder('user')
            ->where($expr->eq('user.id', ':userId'))
            ->setParameter('userId', $userId);

        $user = $queryBuilder->getQuery()->getOneOrNullResult();
        if (null === $user) {
            throw new UserNotFoundException();
        }

        return $user;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getUserRecordAmount(): int
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $queryBuilder = $this->createQueryBuilder('user')->select($expr->count('user.id'));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
