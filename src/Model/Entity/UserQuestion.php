<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * UserQuestion Entity
 *
 * @property int $id
 * @property string $questions
 * @property string $category
 * @property int|null $answer_id
 * @property int|null $user_id
 * @property string|null $feedback
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\User $user
 */
class UserQuestion extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'questions' => true,
        'category' => true,
        'answer_id' => true,
        'user_id' => true,
        'feedback' => true,
        'created' => true,
        'modified' => true,
        'user' => true,
    ];
}
