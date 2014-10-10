<?php namespace Portico\Core\PhpSpec;

use Illuminate\Database\Eloquent\Relations\Relation;

trait EloquentMatcher
{
    public function getMatchers()
    {
        return [
            'defineRelationship' => function($subject, $relationshipType, $relatedModel, $table = null) {
                $relationClass = 'Illuminate\Database\Eloquent\Relations\\' . ucfirst($relationshipType);

                if (!class_exists($relationClass)) {
                    return false;
                }

                if (!$subject instanceof Relation) {
                    return false;
                }

                if (!$subject->getRelated() instanceof $relatedModel) {
                    return false;
                }

                return true;
            }
        ];
    }
} 