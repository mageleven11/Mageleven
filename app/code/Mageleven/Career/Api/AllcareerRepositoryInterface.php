<?php
namespace Mageleven\Career\Api;

interface AllcareerRepositoryInterface
{
	public function save(\Mageleven\Career\Api\Data\AllcareerInterface $career);

    public function getById($careerId);

    public function delete(\Mageleven\Career\Api\Data\AllcareerInterface $career);

    public function deleteById($careerId);
}
