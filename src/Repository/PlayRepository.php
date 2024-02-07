<?php

namespace App\Repository;

use App\Entity\Game;
use App\Entity\Play;
use Doctrine\Persistence\ManagerRegistry;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;

/**
 * @extends ServiceEntityRepository<Play>
 *
 * @method Play|null find($id, $lockMode = null, $lockVersion = null)
 * @method Play|null findOneBy(array $criteria, array $orderBy = null)
 * @method Play[]    findAll()
 * @method Play[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PlayRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Play::class);
    }


    public function maxPlays(Game $game)
    {
        $queryBuilder = $this->createQueryBuilder('play')
        ->select('user.username', 'MAX(play.score) AS ScoreMax')
        ->innerJoin('play.user', 'user')
        ->where('play.game = :game')
        ->setParameter('game', $game->getId())
        ->groupBy('user.username')
        ->orderBy('ScoreMax', 'DESC');

        return $queryBuilder->getQuery()->getResult();
    }
}
