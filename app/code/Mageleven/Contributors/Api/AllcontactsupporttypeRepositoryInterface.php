<?php
namespace Mageleven\Contributors\Api;

interface AllcontactsupporttypeRepositoryInterface
{
	public function save(\Mageleven\Contributors\Api\Data\AllcontactsupporttypeInterface $contactsupporttype);

    public function getById($csId);

    public function delete(\Mageleven\Contributors\Api\Data\AllcontactsupporttypeInterface $contactsupporttype);

    public function deleteById($csId);
}