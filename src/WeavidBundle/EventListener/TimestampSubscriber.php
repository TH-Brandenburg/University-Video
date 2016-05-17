<?php
namespace WeavidBundle\EventListener;

use Doctrine\Common\EventSubscriber;
use Doctrine\ORM\Event\LifecycleEventArgs;

class TimestampSubscriber implements EventSubscriber {
    public function getSubscribedEvents(){
        return array(
            'prePersist',
            'preUpdate'
        );
    }

    public function prePersist(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if(method_exists($entity, 'setCreatedAt') && method_exists($entity, 'setUpdatedAt')){
            $entity->setCreatedAt();
            $entity->setUpdatedAt();
        }
    }

    public function preUpdate(LifecycleEventArgs $args){
        $entity = $args->getEntity();

        if(method_exists($entity, 'setUpdatedAt')){
            $entity->setUpdatedAt();
        }
    }

}