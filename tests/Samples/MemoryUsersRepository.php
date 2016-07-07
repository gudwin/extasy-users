<?php


namespace Extasy\Users\tests\Samples;

use Extasy\Model\NotFoundException;
use Extasy\Users\RepositoryInterface;
use Extasy\Users\User;
use Extasy\Users\Search\Request;

class MemoryUsersRepository implements RepositoryInterface
{
    protected $data = [];
    protected $idIncrement = 1;

    public function flush()
    {
        $this->data = [];
        $this->idIncrement = 1;
    }

    public function insert(User $model)
    {
        $model->id = $this->idIncrement;
        $this->idIncrement++;

        $this->data[] = $model;

    }

    public function update(User $updateUser)
    {
        foreach ($this->data as $key => $user) {
            if ($user->id->getValue() == $updateUser->id->getValue()) {
                $this->data[$key] = $updateUser;

                return;
            }
        }
        throw new \InvalidArgumentException('Unable update user - User not stored');
    }

    public function delete(User $updatedUser)
    {
        foreach ($this->data as $key => $user) {
            if ($user->id->getValue() == $updatedUser->id->getValue()) {
                unset( $this->data[$key]);

                return;
            }
        }
        throw new \InvalidArgumentException('Unable delete user - user not stored');
    }

    /**
     * @param $id
     * @return mixed
     * @throws \Extasy\Model\NotFoundException
     */
    public function get($id)
    {
        foreach ($this->data as $key => $user) {
            if ($user->id->getValue() == $id) {
                return $user;
            }
        }
        throw new NotFoundException('User not found');
    }

    public function find(Request $condition)
    {
        $result = $this->data;
        if (!empty($condition->fields)) {
            $fieldResult = [];

            foreach ($this->data as $key => $row) {
                if ($this->isMatchToCondition($row, $condition)) {
                    $fieldResult[] = $row;
                }
            }
            $result = array_map('unserialize',
                array_intersect(array_map('serialize', $result), array_map('serialize', $fieldResult)));

        }
        if (!empty($condition->likeFields)) {
            $likeResults = [];
            foreach ($this->data as $key => $row) {
                if ($this->isMatchToLikeCondition($row, $condition)) {
                    $likeResults[] = $row;
                }
            }
            $result = array_map('unserialize',
                array_intersect(array_map('serialize', $result), array_map('serialize', $likeResults)));
        }
        if (!empty($condition->offset)) {
            for ($i = 0; $i < $condition->offset; $i++) {
                if (!empty($result)) {
                    array_shift($result);
                }
            }
        }
        if ( !empty( $condition->limit )) {
            $tmp = array_chunk( $result, $condition->limit);
            $result = !empty( $tmp ) ? $tmp[0] : [];
        }

        return $result;
    }

    public function findOne(Request $condition)
    {
        $result = $this->find($condition);

        return !empty($result) ? $result[0] : null;
    }

    protected function isMatchToLikeCondition(User $a, Request $condition)
    {
        foreach ($condition->likeFields as $fieldName => $fieldValue) {
            if (!isset($a->$fieldName)) {
                return false;
            }
            $match = strpos($a->$fieldName->getValue(), $fieldValue);
            if (false === $match) {
                return false;
            }
        }

        return true;

    }

    protected function isMatchToCondition(User $a, Request $condition)
    {
        foreach ($condition->fields as $fieldName => $fieldValue) {
            if (!isset($a->$fieldName)) {
                return false;
            }
            if ($fieldValue != $a->$fieldName->getValue()) {
                return false;
            }

        }

        return true;

    }
}