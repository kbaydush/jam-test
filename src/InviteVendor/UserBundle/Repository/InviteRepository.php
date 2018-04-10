<?php

declare(strict_types=1);

namespace InviteVendor\UserBundle\Repository;

use InviteVendor\UserBundle\Entity\Invite;
use InviteVendor\UserBundle\Exception\InviteNotFoundException;
use InviteVendor\UserBundle\Model\InviteFilter;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\NonUniqueResultException;
use Doctrine\ORM\NoResultException;

class InviteRepository extends EntityRepository
{
    public function findAllByInviteFilter(InviteFilter $filter): array
    {
        $alias = 'invite';
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

    public function findMatchingInvites(Invite $invite): Collection
    {
        $expr = Criteria::expr();
        $criteria = Criteria::create();

        $criteria->where($expr->eq('senderId', $invite->getSenderId()));
        $criteria->where($expr->eq('invitedId', $invite->getInvitedId()));

        return $this->matching($criteria);
    }

    /**
     * @throws NonUniqueResultException
     * @throws InviteNotFoundException
     */
    public function findInvite(string $inviteId): Invite
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $queryBuilder = $this->createQueryBuilder('invite')
            ->where($expr->eq('invite.id', ':inviteId'))
            ->setParameter('inviteId', $inviteId);

        $invite = $queryBuilder->getQuery()->getOneOrNullResult();
        if (null === $invite) {
            throw new InviteNotFoundException();
        }

        return $invite;
    }

    /**
     * @throws NonUniqueResultException
     * @throws NoResultException
     */
    public function getInviteRecordAmount(): int
    {
        $expr = $this->getEntityManager()->getExpressionBuilder();

        $queryBuilder = $this->createQueryBuilder('invite')->select($expr->count('invite.id'));

        return (int) $queryBuilder->getQuery()->getSingleScalarResult();
    }
}
