<?php
namespace Mageleven\Discountrule\Api;

interface AlldiscountruleRepositoryInterface
{
	public function save(\Mageleven\Discountrule\Api\Data\AlldiscountruleInterface $discountrule);

    public function getById($discountruleId);

    public function delete(\Mageleven\Discountrule\Api\Data\AlldiscountruleInterface $discountrule);

    public function deleteById($discountruleId);
}
