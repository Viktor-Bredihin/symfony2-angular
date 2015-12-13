<?php

namespace AppBundle\Entity;

/**
 * PostRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class PostRepository extends \Doctrine\ORM\EntityRepository
{
    /**
     * Get collection of posts
     *
     * @param  array|null $params search params
     * @return json collection of posts
     */
    public function get(array $params = null)
    {
        // default params
        $defaultParams = array(
            'order' => 'ASC'
        );
        $params = array_merge($defaultParams, $params);

        $qb = $this->createQueryBuilder('p');

        if (!empty($params['order_by'])) {
            $qb->orderBy('p.'.$params['order_by'], $params['order']);
        }

        if (!empty($params['last_minutes'])) {
            $date = new \DateTime('-'.$params['last_minutes'].' minutes');
            $qb->where('p.created >= :date')
                ->setParameter('date', $date);
        }

        $result = $qb->getQuery()->getResult(\Doctrine\ORM\Query::HYDRATE_ARRAY);

        if (!empty($params['random'])) {
            shuffle($result);
        }

        return $result;
    }
}
