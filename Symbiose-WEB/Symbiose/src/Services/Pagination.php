<?php

namespace App\Services;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;

class Pagination{
    //determiner l'entité a qui on va appliquer la pagination
    private $entityClass;
    private $limit =10;
    private $currentPage=1;
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em=$em;
    }

    public function getPages(){
        //1) Connaitre le total des enregistrements de la table
        $repo=$this->em->getRepository($this->entityClass);
        $total= count($repo->findAll());
        //2) Faire la division l'arrondi et le renvoyer
        $pages = ceil($total/$this->limit);

        return $pages;

    }


    public function getData(){
        //1) calculer l'offset
            $offset= $this->currentPage*$this->limit-$this->limit;

        //2) Demander au repo de trouver les elements
            $repo=$this->em->getRepository($this->entityClass);
            $data= $repo->findBy([],[],$this->limit,$offset);

        //3) Renovyer les elements en question
            return $data;
    }

    public function setPage($page){
        $this->currentPage=$page;
        return $this;
    }
    public function getPage(){
        return $this->currentPage;
    }
    public function setLimit($limit){
        $this->limit=$limit;

        return $this;
    }
    public function getLimit(){
        return $this->limit;
    }
    public function setEntityClass($entityClass){
        $this->entityClass=$entityClass;

        return $this;
    }

    public function getEntityClass(){
        return $this->entityClass;
    }
}